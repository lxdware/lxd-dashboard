<?php
/*
LXDWARE LXD Dashboard - A web-based interface for managing LXD servers
Copyright (C) 2020-2021  LXDWARE.COM

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

//Start session if not already started
if (!isset($_SESSION)) {
  session_start();
}

//Declare and instantiate GET variables
$action = (isset($_GET['action'])) ? filter_var(urldecode($_GET['action']), FILTER_SANITIZE_STRING) : "";
$description = (isset($_GET['description'])) ? filter_var(urldecode($_GET['description']), FILTER_SANITIZE_STRING) : "";
$id = (isset($_GET['id'])) ? filter_var(urldecode($_GET['id']), FILTER_SANITIZE_NUMBER_INT) : "";
$group_id = (isset($_GET['group_id'])) ? filter_var(urldecode($_GET['group_id']), FILTER_SANITIZE_NUMBER_INT) : "";
$name = (isset($_GET['name'])) ? filter_var(urldecode($_GET['name']), FILTER_SANITIZE_STRING) : "";
$project = (isset($_GET['project'])) ? filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING) : "";
$remote = (isset($_GET['remote'])) ? filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_NUMBER_INT) : "";
$role_id = (isset($_GET['role_id'])) ? filter_var(urldecode($_GET['role_id']), FILTER_SANITIZE_NUMBER_INT) : "";

//Declare and instantiate POST variables
$email = (isset($_POST['email'])) ? filter_var(urldecode($_POST['email']), FILTER_SANITIZE_STRING) : "";
$first_name = (isset($_POST['first_name'])) ? filter_var(urldecode($_POST['first_name']), FILTER_SANITIZE_STRING) : "";
$last_name = (isset($_POST['last_name'])) ? filter_var(urldecode($_POST['last_name']), FILTER_SANITIZE_STRING) : "";
$password = (isset($_POST['password'])) ? $_POST['password'] : "";
$username = (isset($_POST['username'])) ? filter_var(urldecode($_POST['username']), FILTER_SANITIZE_STRING) : "";

//Require code from lxd-dashboard/backend/config/db.php
require_once('../config/db.php');

//Require code from lxd-dashboard/backend/aaa/accounting.php
require_once('../aaa/accounting.php');

if (isset($_SESSION['username'])) {

  require_once('../aaa/authorization.php');

  //Run the matching action
  switch ($action) {
    
    case "addRoleToGroup":
      if (validateAuthorization($action)) {
        $record_added = addGroupRoleMapping($id, $role_id);

        if ($record_added)
          $results = '{"status": "Ok", "status_code": 200, "metadata": {"status": "Record added"}}';
        else 
          $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Unable to add the record to the database"}}';
        
      }
      else {
        $results = '{"status": "Forbidden", "status_code": 403, "metadata": {"error": "You are not authorized to execute this action"}}';
      }

      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $id . " - " . $role_id;
      logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);

      break;

    case "addUserToGroup":
      if (validateAuthorization($action)) {
        $record_added = addUserGroupMapping($id, $group_id);

        if ($record_added)
          $results = '{"status": "Ok", "status_code": 200, "metadata": {"status": "Record added"}}';
        else 
          $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Unable to add the record to the database"}}';

      }
      else {
        $results = '{"status": "Forbidden", "status_code": 403, "metadata": {"error": "You are not authorized to execute this action"}}';
      }

      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $id . " - " . $group_id;
      logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);

      break;

    case "createGroup":
      if (validateAuthorization($action)) {
        $record_added = addGroup($name, $description);

        if($record_added){
          $results = '{"status": "Ok", "status_code": 200, "metadata": "{}"}';
          $group_id = retrieveGroupId($name);
        }
        else {
          $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Unable to add the record to the database"}}';
        }

      }
      else {
        $results = '{"status": "Forbidden", "status_code": 403, "metadata": {"error": "You are not authorized to execute this action"}}';
      }

      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $group_id . " - " . $name;
      logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);

      break;

    case "createUser":
      if (validateAuthorization($action)) {
        //Test to verify username and password both have a value
        if (!empty($username) && !empty($password)) {

          //Hash and salt password with bcrypt
          $passwd_hash = password_hash($password, PASSWORD_BCRYPT);
      
          if(isFirstUser()){
            $record_added = addUser($username, $first_name, $last_name, $passwd_hash, $email);
  
            if($record_added){
              $user_id = retrieveUserId($username);
              $group_id = retrieveGroupId('admin');
              addUserGroupMapping($user_id, $group_id);
            }
            $results = '{"status": "Ok", "status_code": 200, "metadata": "{}"}';
          }
          else {
            $record_added = addUser($username, $first_name, $last_name, $passwd_hash, $email);

            if($record_added){
              $user_id = retrieveUserId($username);
              $group_id = retrieveGroupId('auditor');

              if($group_id){
                addUserGroupMapping($user_id, $group_id);
              }
              
              $results = '{"status": "Ok", "status_code": 200, "metadata": "{}"}';
            }
            else {
              $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Unable to add the record to the database"}}';
            }
            
          }
        }
        else {
          $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Both a username and password must be supplied"}}';
        }
      }
      else {
        $results = '{"status": "Forbidden", "status_code": 403, "metadata": {"error": "You are not authorized to execute this action"}}';
      }

      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $user_id . " - " . $username;
      logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);

      break;

    case "deleteGroup":
      if (validateAuthorization($action)) {
        $record_removed = deleteGroup($id);

        if ($record_removed)
          $results = '{"status": "Ok", "status_code": 200, "metadata": {"status": "Record removed"}}';
        else 
          $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Unable to remove record from database"}}';

      }
      else {
        $results = '{"status": "Forbidden", "status_code": 403, "metadata": {"error": "You are not authorized to execute this action"}}';
      }

      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $id;
      logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);

      break;

    case "deleteUser":
      if (validateAuthorization($action)) {
        $record_removed = deleteUser($id);

        if ($record_removed)
          $results = '{"status": "Ok", "status_code": 200, "metadata": {"status": "Record removed"}}';
        else 
          $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Unable to remove record from database"}}';

      }
      else {
        $results = '{"status": "Forbidden", "status_code": 403, "metadata": {"error": "You are not authorized to execute this action"}}';
      }

      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $id;
      logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);

      break;

    case "displayUsername":
      echo htmlentities($_SESSION['username']);
      break;

    case "listGroups":
      if (validateAuthorization($action)) {
        $rows = retrieveTableRows('lxd_groups');

        $i = 0;
        echo '{ "data": [';
      
        foreach ($rows as $row){
      
          $roles = retrieveGroupRoles($row['id']);
          $users = retrieveGroupUsers($row['id']);
      
          if ($i > 0){
            echo ",";
          }
          $i++;
      
          echo "[ ";
          echo '"';
          echo "<i class='fas fa-users fa-lg' style='color:#4e73df'></i>";
          echo '",';
          echo '"' . htmlentities($row['name']) . '",';
          echo '"' . htmlentities($row['description']) . '",';
      
          echo '"';
          $ii = 0;
          foreach ($roles as $role){
            if ($ii > 0){
              echo ", ";
            }
            $ii++;
            echo htmlentities($role['name']); 
          }
          echo '",';
      
          echo '"';
            echo "<a href='#' onclick='loadAddRoleModal(".$row['id'].")'><i class='fas fa-plus fa-lg' style='color:#ddd' title='Add Role' aria-hidden='true'></i></a>";
            echo ' &nbsp ';
            echo "<a href='#' onclick='loadRemoveRoleModal(".$row['id'].")'><i class='fas fa-minus fa-lg' style='color:#ddd' title='Remove Role' aria-hidden='true'></i></a>";
            echo ' &nbsp ';
            echo "<a href='#' onclick='loadDeleteGroupModal(".$row['id'].")'><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete Group' aria-hidden='true'></i></a>";
          echo '"';
      
          echo " ]";
        }
      
        echo " ]}";
      }
      else {
        echo '{ "data": [] }';
      }
      break;


    case "listGroupsAssignedToUserForSelect":
      if (validateAuthorization($action)) {
        $groups = retrieveUserGroups($id);
        foreach ($groups as $group){
          echo '<option value="' . $group['id'] . '">' . htmlentities($group['name']) . '</option>';
        }
      }
      break;

    case "listGroupsNotAssignedToUserForSelect":
      if (validateAuthorization($action)) {
        $groups = retrieveTableRows('lxd_groups');
        $user_groups = retrieveUserGroups($id);

        foreach ($groups as $group){

          $group_belongs_to_user = false;

          foreach ($user_groups as $user_group){
            if ($user_group['name'] == $group['name']){
              $group_belongs_to_user = true;
            }
          }

          if(!$group_belongs_to_user){
            echo '<option value="' . $group['id'] . '">' . htmlentities($group['name']) . '</option>';
          }

        }
      }
      break;
    
    case "listRolesAssignedToGroupForSelect":
      if (validateAuthorization($action)) {
        $roles = retrieveGroupRoles($id);
        foreach ($roles as $role){
          echo '<option value="' . $role['id'] . '">' . htmlentities($role['name']) . '</option>';
        }
      }
      break;

    case "listRolesNotAssignedToGroupForSelect":
      if (validateAuthorization($action)) {
        $roles = retrieveDefaultRoles();

        $group_roles = retrieveGroupRoles($id);

        foreach ($roles as $role){

          $role_belongs_to_group = false;

          foreach ($group_roles as $group_role){
            if ($group_role['name'] == $role['name']){
              $role_belongs_to_group = true;
            }
          }

          if(!$role_belongs_to_group){
            echo '<option value="' . $role['id'] . '">' . htmlentities($role['name']) . '</option>';
          }

        }
      }
      break;
    
    case "listUsers":
      if (validateAuthorization($action)) {
        $rows = retrieveTableRows('lxd_users');

        $i = 0;
        echo '{ "data": [';

        foreach ($rows as $row){

          $groups = retrieveUserGroups($row['id']);

          if ($i > 0){
            echo ",";
          }
          $i++;

          echo "[ ";

          echo '"';
          echo "<a href='user-profile.php?user=".$row['id']."'><i class='fas fa-user fa-lg' style='color:#4e73df'></i> </a>";
          echo '",';

          echo '"';
          echo "<a href='user-profile.php?user=".$row['id']."'> ".htmlentities($row['username'])."</a>";
          echo '",';

          echo '"' . htmlentities($row['email']) . '",';
          echo '"' . htmlentities($row['type']) . '",';

          echo '"';
          $ii = 0;
          foreach ($groups as $group){
            if ($ii > 0){
              echo ", ";
            }
            $ii++;
            echo htmlentities($group['name']); 
          }
          echo '",';

          echo '"';
            echo "<a href='#' onclick='loadAddGroupModal(".$row['id'].")'><i class='fas fa-plus fa-lg' style='color:#ddd' title='Add Group' aria-hidden='true'></i></a>";
            echo ' &nbsp ';
            echo "<a href='#' onclick='loadRemoveGroupModal(".$row['id'].")'><i class='fas fa-minus fa-lg' style='color:#ddd' title='Remove Group' aria-hidden='true'></i></a>";
            echo ' &nbsp ';
            echo "<a href='#' onclick='loadDeleteUserModal(".$row['id'].")'><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete User' aria-hidden='true'></i></a>";
          echo '"';

          echo " ]";
        }

        echo " ]}";
      }
      else {
        echo '{ "data": [] }';
      }   
      break;

    case "removeGroupFromUser":
      if (validateAuthorization($action)) {
        $record_removed = deleteUserGroupMapping($id, $group_id);

        if ($record_removed)
          $results = '{"status": "Ok", "status_code": 200, "metadata": {"status": "Record removed"}}';
        else 
          $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Unable to remove record from database"}}';

      }
      else {
        $results = '{"status": "Forbidden", "status_code": 403, "metadata": {"error": "You are not authorized to execute this action"}}';
      }

      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $id . " - " . $group_id;
      logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);

      break;
 
    case "removeRoleFromGroup":
      if (validateAuthorization($action)) {
        $record_removed = deleteGroupRoleMapping($id, $role_id);

        if ($record_removed)
          $results = '{"status": "Ok", "status_code": 200, "metadata": {"status": "Record removed"}}';
        else 
          $results =  '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Unable to remove record from database"}}';

      }
      else {
        $results = '{"status": "Forbidden", "status_code": 403, "metadata": {"error": "You are not authorized to execute this action"}}';
      }

      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $id . " - " . $role_id;
      logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);

      break;
 
  }
  
}
else {
  switch ($action) {
    case "createUser":
      //Test to verify username and password both have a value
      if (!empty($username) && !empty($password)) {
        
        //Hash and salt password with bcrypt
        $passwd_hash = password_hash($password, PASSWORD_BCRYPT);
    
        if(isFirstUser()){
          $record_added = addUser($username, $first_name, $last_name, $passwd_hash, $email);

          if($record_added){
            $user_id = retrieveUserId($username);
            $group_id = retrieveGroupId('admin');
            addUserGroupMapping($user_id, $group_id);
          }
          $results = '{"status": "Ok", "status_code": 200, "metadata": "{}"}';
        }
        else {
          $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "User was not added as there are already existing user accounts"}}';
        }
        
      }
      else {
        $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Must supply both a username and password"}}';
      }

      echo $results;
      break;
    }
}
?>
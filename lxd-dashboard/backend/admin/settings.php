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
$certificates_page_rate = (isset($_GET['certificates_page_rate'])) ? filter_var(urldecode($_GET['certificates_page_rate']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$cluster_members_page_rate = (isset($_GET['cluster_members_page_rate'])) ? filter_var(urldecode($_GET['cluster_members_page_rate']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$containers_page_rate = (isset($_GET['containers_page_rate'])) ? filter_var(urldecode($_GET['containers_page_rate']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$containers_single_page_rate = (isset($_GET['containers_single_page_rate'])) ? filter_var(urldecode($_GET['containers_single_page_rate']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$delete_connection_timeout = (isset($_GET['delete_connection_timeout'])) ? filter_var(urldecode($_GET['delete_connection_timeout']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$delete_operation_timeout = (isset($_GET['delete_operation_timeout'])) ? filter_var(urldecode($_GET['delete_operation_timeout']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$description = (isset($_GET['description'])) ? filter_var(urldecode($_GET['description']), FILTER_SANITIZE_STRING) : "";
$get_connection_timeout = (isset($_GET['get_connection_timeout'])) ? filter_var(urldecode($_GET['get_connection_timeout']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "2";
$get_operation_timeout = (isset($_GET['get_operation_timeout'])) ? filter_var(urldecode($_GET['get_operation_timeout']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$images_page_rate = (isset($_GET['images_page_rate'])) ? filter_var(urldecode($_GET['images_page_rate']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$logs_enabled_status = (isset($_GET['logs_enabled_status'])) ? filter_var(urldecode($_GET['logs_enabled_status']), FILTER_SANITIZE_STRING) : "";
$logs_page_rate = (isset($_GET['logs_page_rate'])) ? filter_var(urldecode($_GET['logs_page_rate']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$logs_retrieval_number = (isset($_GET['logs_retrieval_number'])) ? filter_var(urldecode($_GET['logs_retrieval_number']), FILTER_SANITIZE_NUMBER_INT) : "";
$id = (isset($_GET['id'])) ? filter_var(urldecode($_GET['id']), FILTER_SANITIZE_NUMBER_INT) : "";
$group_id = (isset($_GET['group_id'])) ? filter_var(urldecode($_GET['group_id']), FILTER_SANITIZE_NUMBER_INT) : "";
$name = (isset($_GET['name'])) ? filter_var(urldecode($_GET['name']), FILTER_SANITIZE_STRING) : "";
$network_acls_page_rate = (isset($_GET['network_acls_page_rate'])) ? filter_var(urldecode($_GET['network_acls_page_rate']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$networks_page_rate = (isset($_GET['networks_page_rate'])) ? filter_var(urldecode($_GET['networks_page_rate']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$operations_page_rate = (isset($_GET['operations_page_rate'])) ? filter_var(urldecode($_GET['operations_page_rate']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$patch_connection_timeout = (isset($_GET['patch_connection_timeout'])) ? filter_var(urldecode($_GET['patch_connection_timeout']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$patch_operation_timeout = (isset($_GET['patch_operation_timeout'])) ? filter_var(urldecode($_GET['patch_operation_timeout']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$post_connection_timeout = (isset($_GET['post_connection_timeout'])) ? filter_var(urldecode($_GET['post_connection_timeout']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$post_operation_timeout = (isset($_GET['post_operation_timeout'])) ? filter_var(urldecode($_GET['post_operation_timeout']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$profiles_page_rate = (isset($_GET['profiles_page_rate'])) ? filter_var(urldecode($_GET['profiles_page_rate']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$project = (isset($_GET['project'])) ? filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING) : "";
$projects_page_rate = (isset($_GET['projects_page_rate'])) ? filter_var(urldecode($_GET['projects_page_rate']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$put_connection_timeout = (isset($_GET['put_connection_timeout'])) ? filter_var(urldecode($_GET['put_connection_timeout']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$put_operation_timeout = (isset($_GET['put_operation_timeout'])) ? filter_var(urldecode($_GET['put_operation_timeout']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$remote = (isset($_GET['remote'])) ? filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_NUMBER_INT) : "";
$remotes_single_page_rate = (isset($_GET['remotes_single_page_rate'])) ? filter_var(urldecode($_GET['remotes_single_page_rate']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$remotes_page_rate = (isset($_GET['remotes_page_rate'])) ? filter_var(urldecode($_GET['remotes_page_rate']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$role_id = (isset($_GET['role_id'])) ? filter_var(urldecode($_GET['role_id']), FILTER_SANITIZE_NUMBER_INT) : "";
$simplestreams_page_rate = (isset($_GET['simplestreams_page_rate'])) ? filter_var(urldecode($_GET['simplestreams_page_rate']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$storage_pools_page_rate = (isset($_GET['storage_pools_page_rate'])) ? filter_var(urldecode($_GET['storage_pools_page_rate']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$storage_volumes_page_rate = (isset($_GET['storage_volumes_page_rate'])) ? filter_var(urldecode($_GET['storage_volumes_page_rate']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$virtual_machines_page_rate = (isset($_GET['virtual_machines_page_rate'])) ? filter_var(urldecode($_GET['virtual_machines_page_rate']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";
$virtual_machines_single_page_rate = (isset($_GET['virtual_machines_single_page_rate'])) ? filter_var(urldecode($_GET['virtual_machines_single_page_rate']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "5";

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
   
    case "retrieveCurlTimeoutValues":
      //Retrieve SESSION variables and return JSON
      $arr = array();
      $arr['get_connection_timeout'] = $_SESSION['get_connection_timeout'];
      $arr['get_operation_timeout'] = $_SESSION['get_operation_timeout'];
      $arr['post_connection_timeout'] = $_SESSION['post_connection_timeout'];
      $arr['post_operation_timeout'] = $_SESSION['post_operation_timeout'];
      $arr['patch_connection_timeout'] = $_SESSION['patch_connection_timeout'];
      $arr['patch_operation_timeout'] = $_SESSION['patch_operation_timeout'];
      $arr['put_connection_timeout'] = $_SESSION['put_connection_timeout'];
      $arr['put_operation_timeout'] = $_SESSION['put_operation_timeout'];
      $arr['delete_connection_timeout'] = $_SESSION['delete_connection_timeout'];
      $arr['delete_operation_timeout'] = $_SESSION['delete_operation_timeout'];
      echo json_encode($arr);
      break;
    
    case "retrieveLogPreferences":
      $arr = array();
      $arr['logs_enabled'] = retrievePreference("logs_enabled");
      $arr['logs_retrieval'] = intval(retrievePreference("logs_retrieval"));
      echo json_encode($arr);
      break;

    case "retrievePageRefreshRateValues":
      //Retrieve SESSION variables and return JSON
      $arr = array();
      $arr['certificates_page_rate'] = $_SESSION['certificates_page_rate'];
      $arr['cluster_members_page_rate'] = $_SESSION['cluster_members_page_rate'];
      $arr['containers_page_rate'] = $_SESSION['containers_page_rate'];
      $arr['containers_single_page_rate'] = $_SESSION['containers_single_page_rate'];
      $arr['images_page_rate'] = $_SESSION['images_page_rate'];
      $arr['logs_page_rate'] = $_SESSION['logs_page_rate'];
      $arr['network_acls_page_rate'] = $_SESSION['network_acls_page_rate'];
      $arr['networks_page_rate'] = $_SESSION['networks_page_rate'];
      $arr['operations_page_rate'] = $_SESSION['operations_page_rate'];
      $arr['profiles_page_rate'] = $_SESSION['profiles_page_rate'];
      $arr['projects_page_rate'] = $_SESSION['projects_page_rate'];
      $arr['remotes_single_page_rate'] = $_SESSION['remotes_single_page_rate'];
      $arr['remotes_page_rate'] = $_SESSION['remotes_page_rate'];
      $arr['simplestreams_page_rate'] = $_SESSION['simplestreams_page_rate'];
      $arr['storage_pools_page_rate'] = $_SESSION['storage_pools_page_rate'];
      $arr['storage_volumes_page_rate'] = $_SESSION['storage_volumes_page_rate'];
      $arr['virtual_machines_page_rate'] = $_SESSION['virtual_machines_page_rate'];
      $arr['virtual_machines_single_page_rate'] = $_SESSION['virtual_machines_single_page_rate'];
      echo json_encode($arr);
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

    case "updateLogPreferences":
      if (validateAuthorization($action)) {
        if ($logs_enabled_status == "true" || $logs_enabled_status == "false"){
          $logs_enabled_status_updated = updatePreference("logs_enabled", $logs_enabled_status);
        }
        
        if (is_numeric($logs_retrieval_number) && $logs_retrieval_number >= 1){
          $logs_retrieval_number_updated = updatePreference("logs_retrieval", $logs_retrieval_number);
        }
        
        if ($logs_enabled_status_updated && $logs_retrieval_number_updated)
          $results = '{"status": "Ok", "status_code": 200, "metadata": {"status": "Record added"}}';
        else 
          $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "There was an error while updating the lxd_preferences table"}}';
        
      }
      else {
        $results = '{"status": "Forbidden", "status_code": 403, "metadata": {"error": "You are not authorized to execute this action"}}';
      }

      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = "";
      logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);

      break;

    case "updateOutboundRequestPreferences":
      if (validateAuthorization($action)) {
        
        if (is_numeric($get_connection_timeout) && $get_connection_timeout >= 1)
          $get_connection_timeout_updated = updatePreference("get_connection_timeout", $get_connection_timeout);
        if ($get_connection_timeout_updated)
          $_SESSION['get_connection_timeout'] = $get_connection_timeout;

        if (is_numeric($get_operation_timeout) && $get_operation_timeout >= 1)
          $get_operation_timeout_updated = updatePreference("get_operation_timeout", $get_operation_timeout);
        if ($get_operation_timeout_updated)
          $_SESSION['get_operation_timeout'] = $get_operation_timeout;
        
        if (is_numeric($post_connection_timeout) && $post_connection_timeout >= 1)
          $post_connection_timeout_updated = updatePreference("post_connection_timeout", $post_connection_timeout);
        if ($post_connection_timeout_updated)
          $_SESSION['post_connection_timeout'] = $post_connection_timeout;
        
        if (is_numeric($post_operation_timeout) && $post_operation_timeout >= 1)
          $post_operation_timeout_updated = updatePreference("post_operation_timeout", $post_operation_timeout);
        if ($post_operation_timeout_updated)
          $_SESSION['post_operation_timeout'] = $post_operation_timeout;
        
        if (is_numeric($patch_connection_timeout) && $patch_connection_timeout >= 1)
          $patch_connection_timeout_updated = updatePreference("patch_connection_timeout", $patch_connection_timeout);
        if ($patch_connection_timeout_updated)
          $_SESSION['patch_connection_timeout'] = $patch_connection_timeout;
        
        if (is_numeric($patch_operation_timeout) && $patch_operation_timeout >= 1)
          $patch_operation_timeout_updated = updatePreference("patch_operation_timeout", $patch_operation_timeout);
        if ($patch_operation_timeout_updated)
          $_SESSION['patch_operation_timeout'] = $patch_operation_timeout;

        if (is_numeric($put_connection_timeout) && $put_connection_timeout >= 1)
          $put_connection_timeout_updated = updatePreference("put_connection_timeout", $put_connection_timeout);
        if ($put_connection_timeout_updated)
          $_SESSION['put_connection_timeout'] = $put_connection_timeout;

        if (is_numeric($put_operation_timeout) && $put_operation_timeout >= 1)
          $put_operation_timeout_updated = updatePreference("put_operation_timeout", $put_operation_timeout);
        if ($put_operation_timeout_updated)
          $_SESSION['put_operation_timeout'] = $put_operation_timeout;

        if (is_numeric($delete_connection_timeout) && $delete_connection_timeout >= 1)
          $delete_connection_timeout_updated = updatePreference("delete_connection_timeout", $delete_connection_timeout);
        if ($delete_connection_timeout_updated)
          $_SESSION['delete_connection_timeout'] = $delete_connection_timeout;

        if (is_numeric($delete_operation_timeout) && $delete_operation_timeout >= 1)
          $delete_operation_timeout_updated = updatePreference("delete_operation_timeout", $delete_operation_timeout);
        if ($delete_operation_timeout_updated)
          $_SESSION['delete_operation_timeout'] = $delete_operation_timeout;

        
        if ($get_connection_timeout_updated && $get_operation_timeout_updated && $post_connection_timeout_updated && $post_operation_timeout_updated && $patch_connection_timeout_updated && $patch_operation_timeout_updated && $put_connection_timeout_updated && $put_operation_timeout_updated && $delete_connection_timeout_updated && $delete_operation_timeout_updated)
          $results = '{"status": "Ok", "status_code": 200, "metadata": {"status": "Record added"}}';
        else 
          $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "There was an error while updating the lxd_preferences table"}}';
        
      }
      else {
        $results = '{"status": "Forbidden", "status_code": 403, "metadata": {"error": "You are not authorized to execute this action"}}';
      }

      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = "";
      logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      break;

    case "updateRefreshRatePreferences":
      if (validateAuthorization($action)) {

        if (is_numeric($certificates_page_rate) && $certificates_page_rate >= 1)
          $certificates_page_rate_updated = updatePreference("certificates_page_rate", $certificates_page_rate);
        if ($certificates_page_rate_updated)
          $_SESSION['certificates_page_rate'] = $certificates_page_rate;

        if (is_numeric($cluster_members_page_rate) && $cluster_members_page_rate >= 1)
          $cluster_members_page_rate_updated = updatePreference("cluster_members_page_rate", $cluster_members_page_rate);
        if ($cluster_members_page_rate_updated)
          $_SESSION['cluster_members_page_rate'] = $cluster_members_page_rate;

        if (is_numeric($containers_page_rate) && $containers_page_rate >= 1)
          $containers_page_rate_updated = updatePreference("containers_page_rate", $containers_page_rate);
        if ($containers_page_rate_updated)
          $_SESSION['containers_page_rate'] = $containers_page_rate;

        if (is_numeric($containers_single_page_rate) && $containers_single_page_rate >= 1)
          $containers_single_page_rate_updated = updatePreference("containers_single_page_rate", $containers_single_page_rate);
        if ($containers_single_page_rate_updated  )
          $_SESSION['containers_single_page_rate'] = $containers_single_page_rate;

        if (is_numeric($images_page_rate) && $images_page_rate >= 1)
          $images_page_rate_updated = updatePreference("images_page_rate", $images_page_rate);
        if ($images_page_rate_updated)
          $_SESSION['images_page_rate'] = $images_page_rate;

        if (is_numeric($logs_page_rate) && $logs_page_rate >= 1)
          $logs_page_rate_updated = updatePreference("logs_page_rate", $logs_page_rate);
        if ($logs_page_rate_updated)
          $_SESSION['logs_page_rate'] = $logs_page_rate;

        if (is_numeric($network_acls_page_rate) && $network_acls_page_rate >= 1)
          $network_acls_page_rate_updated = updatePreference("network_acls_page_rate", $network_acls_page_rate);
        if ($network_acls_page_rate_updated)
          $_SESSION['network_acls_page_rate'] = $network_acls_page_rate;

        if (is_numeric($networks_page_rate) && $networks_page_rate >= 1)
          $networks_page_rate_updated = updatePreference("networks_page_rate", $networks_page_rate);
        if ($networks_page_rate_updated)
          $_SESSION['networks_page_rate'] = $networks_page_rate;

        if (is_numeric($operations_page_rate) && $operations_page_rate >= 1)
          $operations_page_rate_updated = updatePreference("operations_page_rate", $operations_page_rate);
        if ($operations_page_rate_updated)
          $_SESSION['operations_page_rate'] = $operations_page_rate;

        if (is_numeric($profiles_page_rate) && $profiles_page_rate >= 1)
          $profiles_page_rate_updated = updatePreference("profiles_page_rate", $profiles_page_rate);
        if ($profiles_page_rate_updated)
          $_SESSION['profiles_page_rate'] = $profiles_page_rate;

        if (is_numeric($projects_page_rate) && $projects_page_rate >= 1)
          $projects_page_rate_updated = updatePreference("projects_page_rate", $projects_page_rate);
        if ($projects_page_rate_updated)
          $_SESSION['projects_page_rate'] = $projects_page_rate;

        if (is_numeric($remotes_single_page_rate) && $remotes_single_page_rate >= 1)
          $remotes_single_page_rate_updated = updatePreference("remotes_single_page_rate", $remotes_single_page_rate);
        if ($remotes_single_page_rate_updated)
          $_SESSION['remotes_single_page_rate'] = $remotes_single_page_rate;

        if (is_numeric($remotes_page_rate) && $remotes_page_rate >= 1)
          $remotes_page_rate_updated = updatePreference("remotes_page_rate", $remotes_page_rate);
        if ($remotes_page_rate_updated)
          $_SESSION['remotes_page_rate'] = $remotes_page_rate;

        if (is_numeric($simplestreams_page_rate) && $simplestreams_page_rate >= 1)
          $simplestreams_page_rate_updated = updatePreference("simplestreams_page_rate", $simplestreams_page_rate);
        if ($simplestreams_page_rate_updated)
          $_SESSION['simplestreams_page_rate'] = $simplestreams_page_rate;

        if (is_numeric($storage_pools_page_rate) && $storage_pools_page_rate >= 1)
          $storage_pools_page_rate_updated = updatePreference("storage_pools_page_rate", $storage_pools_page_rate);
        if ($storage_pools_page_rate_updated)
          $_SESSION['storage_pools_page_rate'] = $storage_pools_page_rate;

        if (is_numeric($storage_volumes_page_rate) && $storage_volumes_page_rate >= 1)
          $storage_volumes_page_rate_updated = updatePreference("storage_volumes_page_rate", $storage_volumes_page_rate);
        if ($storage_volumes_page_rate_updated)
          $_SESSION['storage_volumes_page_rate'] = $storage_volumes_page_rate;

        if (is_numeric($virtual_machines_page_rate) && $virtual_machines_page_rate >= 1)
          $virtual_machines_page_rate_updated = updatePreference("virtual_machines_page_rate", $virtual_machines_page_rate);
        if ($virtual_machines_page_rate_updated)
          $_SESSION['virtual_machines_page_rate'] = $virtual_machines_page_rate;

        if (is_numeric($virtual_machines_single_page_rate) && $virtual_machines_single_page_rate >= 1)
          $virtual_machines_single_page_rate_updated = updatePreference("virtual_machines_single_page_rate", $virtual_machines_single_page_rate);
        if ($virtual_machines_single_page_rate_updated)
          $_SESSION['virtual_machines_single_page_rate'] = $virtual_machines_single_page_rate;


        if ($certificates_page_rate_updated && $cluster_members_page_rate_updated && $containers_page_rate_updated && $containers_single_page_rate_updated && $images_page_rate_updated && $logs_page_rate_updated && $network_acls_page_rate_updated && $networks_page_rate_updated && $operations_page_rate_updated && $profiles_page_rate_updated && $projects_page_rate_updated && $remotes_single_page_rate_updated && $remotes_page_rate_updated && $simplestreams_page_rate_updated && $storage_pools_page_rate_updated && $storage_volumes_page_rate_updated && $virtual_machines_page_rate_updated && $virtual_machines_single_page_rate_updated)
          $results = '{"status": "Ok", "status_code": 200, "metadata": {"status": "Record added"}}';
        else 
          $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "There was an error while updating the lxd_preferences table"}}';
        
      }
      else {
        $results = '{"status": "Forbidden", "status_code": 403, "metadata": {"error": "You are not authorized to execute this action"}}';
      }

      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = "";
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
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
$project = (isset($_GET['project'])) ? filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING) : "";
$remote = (isset($_GET['remote'])) ? filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_NUMBER_INT) : "";

//Declare and instantiate POST variables
$username = (isset($_POST['username'])) ? filter_var(urldecode($_POST['username']), FILTER_SANITIZE_STRING) : "";
$password = (isset($_POST['password'])) ? filter_var(urldecode($_POST['password']), FILTER_SANITIZE_STRING) : "";

//Require code from lxd-dashboard/backend/config/db.php
require_once('../config/db.php');

//Require code from lxd-dashboard/backend/aaa/authorization.php
require_once('../aaa/authorization.php');

//Require code from lxd-dashboard/backend/aaa/accounting.php
require_once('../aaa/accounting.php');

//Run the matching action
switch ($action) {

  case "authenticateUser":
    //Determine user info from database
    foreach (retrieveUserRecord($username) as $record){
      $user_id = $record['id'];
      $passwd_hash = $record['passwd_hash'];
    }

    //Verify password matches existing database passwd_hash
    if (password_verify($password, $passwd_hash)) {

      //Store username and user_id in SESSION variable
      $_SESSION['username'] = $username;
      $_SESSION['user_id'] = $user_id;

      //Get all the roles that the user belongs to
      $roles = array();
      foreach (retrieveUserRoles($user_id) as $role){
        array_push($roles, $role['name']);
      }

      //Make sure array only has unique values
      $roles = array_unique($roles);

      //Get array of contols based on the user's roles
      $controls = getControls($roles);

      //Store user's controls in a SESSION array
      $_SESSION['controls'] = $controls;

      //Store preference values in SESSION array
      $preferences = retrieveTableRows("lxd_preferences");
      foreach ($preferences as $preference){
        //API Preferences
        if ($preference['name'] == "get_connection_timeout")
          $_SESSION['get_connection_timeout'] = $preference['value'];
        if ($preference['name'] == "get_operation_timeout")
          $_SESSION['get_operation_timeout'] = $preference['value'];
        if ($preference['name'] == "post_connection_timeout")
          $_SESSION['post_connection_timeout'] = $preference['value'];
        if ($preference['name'] == "post_operation_timeout")
          $_SESSION['post_operation_timeout'] = $preference['value'];
        if ($preference['name'] == "patch_connection_timeout")
          $_SESSION['patch_connection_timeout'] = $preference['value'];
        if ($preference['name'] == "patch_operation_timeout")
          $_SESSION['patch_operation_timeout'] = $preference['value'];
        if ($preference['name'] == "put_connection_timeout")
          $_SESSION['put_connection_timeout'] = $preference['value'];
        if ($preference['name'] == "put_operation_timeout")
          $_SESSION['put_operation_timeout'] = $preference['value'];
        if ($preference['name'] == "delete_connection_timeout")
          $_SESSION['delete_connection_timeout'] = $preference['value'];
        if ($preference['name'] == "delete_operation_timeout")
          $_SESSION['delete_operation_timeout'] = $preference['value'];
        //Page Refresh Preferences
        if ($preference['name'] == "certificates_page_rate")
          $_SESSION['certificates_page_rate'] = $preference['value'];
        if ($preference['name'] == "cluster_members_page_rate")
          $_SESSION['cluster_members_page_rate'] = $preference['value'];
        if ($preference['name'] == "containers_page_rate")
          $_SESSION['containers_page_rate'] = $preference['value'];
        if ($preference['name'] == "containers_single_page_rate")
          $_SESSION['containers_single_page_rate'] = $preference['value'];
        if ($preference['name'] == "images_page_rate")
          $_SESSION['images_page_rate'] = $preference['value'];
        if ($preference['name'] == "logs_page_rate")
          $_SESSION['logs_page_rate'] = $preference['value'];
        if ($preference['name'] == "network_acls_page_rate")
          $_SESSION['network_acls_page_rate'] = $preference['value'];
        if ($preference['name'] == "networks_page_rate")
          $_SESSION['networks_page_rate'] = $preference['value'];
        if ($preference['name'] == "operations_page_rate")
          $_SESSION['operations_page_rate'] = $preference['value'];
        if ($preference['name'] == "profiles_page_rate")
          $_SESSION['profiles_page_rate'] = $preference['value'];
        if ($preference['name'] == "projects_page_rate")
          $_SESSION['projects_page_rate'] = $preference['value'];
        if ($preference['name'] == "remotes_single_page_rate")
          $_SESSION['remotes_single_page_rate'] = $preference['value'];
        if ($preference['name'] == "remotes_page_rate")
          $_SESSION['remotes_page_rate'] = $preference['value'];
        if ($preference['name'] == "simplestreams_page_rate")
          $_SESSION['simplestreams_page_rate'] = $preference['value'];
        if ($preference['name'] == "storage_pools_page_rate")
          $_SESSION['storage_pools_page_rate'] = $preference['value'];
        if ($preference['name'] == "storage_volumes_page_rate")
          $_SESSION['storage_volumes_page_rate'] = $preference['value'];
        if ($preference['name'] == "virtual_machines_page_rate")
          $_SESSION['virtual_machines_page_rate'] = $preference['value'];
        if ($preference['name'] == "virtual_machines_single_page_rate")
          $_SESSION['virtual_machines_single_page_rate'] = $preference['value'];
      }

      $results = '{"status": "Ok", "status_code": 200, "metadata": "{}"}';
    }
    else {
      //Return 401 Unauthorized despite it technically being unauthenticated
      $results = '{"status": "Unauthorized", "status_code": 401, "metadata": {"error": "Incorrect username or password"}}';
    }

    echo $results;

    //Send event to accounting
    $event = json_decode($results, true);
    $object = $username;
    logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);

    break;

  case "deauthenticateUser":
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    //Clear the SESSION variables
    $_SESSION = array();
    if (session_destroy())
      $results = '{"status": "Ok", "status_code": 200, "metadata": "{}"}';
    
    echo $results;

    //Send event to accounting
    $event = json_decode($results, true);
    $object = $username;
    logEvent($action, $remote, $project, $object, $event['status_code'], $event['status'], $user_id);

    break;
    
  case "validateAuthentication":
    if (isset($_SESSION['username'])){
      echo '{"status": "Ok", "status_code": 200, "metadata": "{}"}';
    } 
    else {
      echo '{"status": "Unauthorized", "status_code": 401, "metadata": {"error": "Failed authentication validation"}}';
    }
    break;
  
  default:
    echo "LXDWARE";
}

?>
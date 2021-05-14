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

//Require code from lxd-dashboard/php/config/db.php
require_once('../config/db.php');

//Require code from lxd-dashboard/php/aaa/authorization.php
require_once('../aaa/authorization.php');

//Require code from lxd-dashboard/php/aaa/accounting.php
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
    //Clear the SESSION variables
    $_SESSION = array();
    if (session_destroy())
      $results = '{"status": "Ok", "status_code": 200, "metadata": "{}"}';
    
    echo $results;

    //Send event to accounting
    $event = json_decode($results, true);
    $object = $username;
    logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);

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
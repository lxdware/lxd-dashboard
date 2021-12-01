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
$email = (isset($_GET['email'])) ? filter_var(urldecode($_GET['email']), FILTER_SANITIZE_STRING) : "";
$first_name = (isset($_GET['first_name'])) ? filter_var(urldecode($_GET['first_name']), FILTER_SANITIZE_STRING) : "";
$id = (isset($_GET['id'])) ? filter_var(urldecode($_GET['id']), FILTER_SANITIZE_NUMBER_INT) : "";
$last_name = (isset($_GET['last_name'])) ? filter_var(urldecode($_GET['last_name']), FILTER_SANITIZE_STRING) : "";
$project = (isset($_GET['project'])) ? filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING) : "";
$remote = (isset($_GET['remote'])) ? filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_NUMBER_INT) : "";

//Declare and instantiate POST variables
$password = (isset($_POST['password'])) ? $_POST['password'] : "";

//Require code from lxd-dashboard/backend/config/db.php
require_once('../config/db.php');

//Require code from lxd-dashboard/backend/aaa/accounting.php
require_once('../aaa/accounting.php');

if (isset($_SESSION['username'])) {

  require_once('../aaa/authorization.php');

  //Run the matching action
  switch ($action) {
    
    case "retrieveUserId":
      if (validateAuthorization($action)) {
        $user_id = $_SESSION['user_id'];
         echo '{"id": "'.$user_id.'"}';
      }
      else {
        echo '{"status": "Forbidden", "status_code": 403, "metadata": {"error": "You are not authorized to execute this action"}}';
      }
      break;

    case "retrieveUserDetails":
      if (validateAuthorization($action)) {
        foreach (retrieveUserDetails($id) as $record){
          $user_id = $record['id'];
          $username = $record['username'];
          $first_name = $record['first_name'];
          $last_name = $record['last_name'];
          $email = $record['email'];
          $type = $record['type'];
        }
        echo '{"id": "'.$user_id.'", "username":"'.$username.'", "firstName":"'.$first_name.'", "lastName":"'.$last_name.'", "email":"'.$email.'", "type":"'.$type.'"}';
      }
      else {
        echo '{"status": "Forbidden", "status_code": 403, "metadata": {"error": "You are not authorized to execute this action"}}';
      }
      break;

    case "updateUserAccount":
      if (validateAuthorization($action) || $id == $_SESSION['user_id']) {
        $record_updated = updateUserAccount($id, $first_name, $last_name, $email);

        if ($record_updated)
          $results = '{"status": "Ok", "status_code": 200, "metadata": {"status": "Record updated"}}';
        else 
          $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Unable to update the record in the database"}}';

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

    case "updateUserPassword":
      if (validateAuthorization($action) || $id == $_SESSION['user_id']) {
        
        //Test to verify userId and password both have a value
        if (!empty($id) && !empty($password)) {

          //Hash and salt password with bcrypt
          $passwd_hash = password_hash($password, PASSWORD_BCRYPT);
      
          $record_updated = updateUserPassword($id, $passwd_hash);
          
          if ($record_updated)
            $results = '{"status": "Ok", "status_code": 200, "metadata": {"status": "Record updated"}}';
          else 
            $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Unable to update the record in the database"}}';
          
        }
        else {
          $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Please type a password and try again"}}';
        }
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

  }
  
}
?>
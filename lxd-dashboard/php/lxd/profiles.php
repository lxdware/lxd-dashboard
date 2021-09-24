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

//Verify that user is logged in
if (isset($_SESSION['username'])) {

  //Declare and instantiate GET variables
  $action = (isset($_GET['action'])) ? filter_var(urldecode($_GET['action']), FILTER_SANITIZE_STRING) : "";
  $description = (isset($_GET['description'])) ? filter_var(urldecode($_GET['description']), FILTER_SANITIZE_STRING) : "";
  $name = (isset($_GET['name'])) ? filter_var(urldecode($_GET['name']), FILTER_SANITIZE_STRING) : "";
  $profile = (isset($_GET['profile'])) ? filter_var(urldecode($_GET['profile']), FILTER_SANITIZE_STRING) : "";
  $project = (isset($_GET['project'])) ? filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING) : "";
  $remote = (isset($_GET['remote'])) ? filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_NUMBER_INT) : "";
  $repo = (isset($_GET['repo'])) ? filter_var(urldecode($_GET['repo']), FILTER_SANITIZE_STRING) : "";

  //Declare and instantiate POST variables
  $json = (isset($_POST['json'])) ? $_POST['json'] : "";

  //Require code from lxd-dashboard/php/config/curl.php
  require_once('../config/curl.php');

  //Require code from lxd-dashboard/php/config/db.php
  require_once('../config/db.php');

  //Require code from lxd-dashboard/php/aaa/accounting.php
  require_once('../aaa/accounting.php');

  //Query database for remote host record
  $base_url = retrieveHostURL($remote);

  //Run the matching action
  switch ($action) {
    
    case "createProfileUsingForm":
      $url = $base_url . "/1.0/profiles?project=" . $project;
      $data = '{"description": "'.$description.'", "name": "'.$name.'"}';
      $results = sendCurlRequest($action, "POST", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $name;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "createProfileUsingJSON":
      $url = $base_url . "/1.0/profiles?project=" . $project;
      $data = $json;
      $results = sendCurlRequest($action, "POST", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = json_decode($data, true)['name'];
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "deleteProfile":
      $url = $base_url . "/1.0/profiles/" . $profile . "?project=" . $project;
      $results = sendCurlRequest($action, "DELETE", $url);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $profile;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "listProfiles":
      if (validateAuthorization($action)) {
        $url = $base_url . "/1.0/profiles?recursion=1&project=" . $project;
        $results = sendCurlRequest($action, "GET", $url);
        $results = json_decode($results, true);
        $profiles = (isset($results['metadata'])) ? $results['metadata'] : [];

        $i = 0;
        echo '{ "data": [';

        if ($results['status_code'] == "200"){

          foreach ($profiles as $profile){

            if ($profile['name'] == "")
            continue;
          
            if ($i > 0){
              echo ",";
            }
            $i++;

            echo "[ ";
            echo '"' . "<i class='fas fa-money-check' style='color:#4e73df'></i>" . '",';
            echo '"' . htmlentities($profile['name']) . '",';
            echo '"' . htmlentities($profile['description']) . '",';

            echo '"';
              $ii = 0;
              foreach($profile['devices'] as $device=>$value){
                if ($ii > 0)
                  echo ", ";
                echo htmlentities($device);
                $ii++;
              }
            echo '",';

            echo '"';
            echo "<a href='#' onclick=loadProfileJson('".$profile['name']."')><i class='fas fa-edit fa-lg' style='color:#ddd' title='Edit' aria-hidden='true'></i></a>";
            echo " &nbsp ";
            echo "<a href='#' onclick=loadRenameProfile('".$profile['name']."')><i class='fas fa-tag fa-lg' style='color:#ddd' title='Rename' aria-hidden='true'></i></a>";
            echo " &nbsp ";
            echo "<a href='#' onclick=deleteProfile('".$profile['name']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
            echo '"';

            echo " ]";

          }

        }

        echo " ]}";
      }
      else {
        echo '{ "data": [] }';
      }      
      break;
    
    case "listProfilesForSelectOption":
      $url = $base_url . "/1.0/profiles?recursion=1&project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $profiles = (isset($results['metadata'])) ? $results['metadata'] : [];
    
      foreach ($profiles as $profile){
        
        if ($profile['name'] == "")
        continue;
        
        if ($profile['name'] == "default"){
          echo '<option value="' . $profile['name'] . '" selected>' . htmlentities($profile['name']) . '</option>';
        }
        else {
          echo '<option value="' . $profile['name'] . '">' . htmlentities($profile['name']) . '</option>';
        }
      }
      break;

    case "loadProfile":
      $url = $base_url . "/1.0/profiles/" . $profile . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      echo $results;
      break;

    case "renameProfile":
      $url = $base_url . "/1.0/profiles/" . $profile . "?project=" . $project;
      $data = '{"name": "' . $name . '"}';
      $results = sendCurlRequest($action, "POST", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $profile;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "updateProfile":
      $url = $base_url . "/1.0/profiles/" . $profile . "?project=" . $project;
      $data = $json;
      $results = sendCurlRequest($action, "PUT", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $profile;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    default:
      $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"err": "Unable to execute action on remote host", "status_code": "400"}}';
      echo $results;

  }

}
else {
  echo '{"error": "not authenticated", "error_code": "401", "metadata": {"err": "not authenticated", "status_code": "401"}}';
}

?>
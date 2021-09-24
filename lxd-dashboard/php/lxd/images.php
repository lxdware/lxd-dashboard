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
  $fingerprint = (isset($_GET['fingerprint'])) ? filter_var(urldecode($_GET['fingerprint']), FILTER_SANITIZE_STRING) : "";
  $image = (isset($_GET['image'])) ? filter_var(urldecode($_GET['image']), FILTER_SANITIZE_STRING) : "";
  $image_type = (isset($_GET['image_type'])) ? filter_var(urldecode($_GET['image_type']), FILTER_SANITIZE_STRING) : "";
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
    case "deleteImage":
      $url = $base_url . "/1.0/images/" . $fingerprint . "?project=" . $project;
      $results = sendCurlRequest($action, "DELETE", $url);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $fingerprint;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "downloadImage":
      $url = $base_url . "/1.0/images?project=" . $project;
      $data = '{"source": {"type": "image", "protocol": "simplestreams", "server": "' . $repo . '", "alias": "' . $image . '","image_type": "' . $image_type . '"}}';
      $results = sendCurlRequest($action, "POST", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $image;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "listImages":
      if (validateAuthorization($action)) {
        $url = $base_url . "/1.0/images?recursion=1&project=" . $project;
        $results = sendCurlRequest($action, "GET", $url);
        $results = json_decode($results, true);
        $images = (isset($results['metadata'])) ? $results['metadata'] : [];
      
        $i = 0;
        echo '{ "data": [';

        if ($results['status_code'] == "200"){
      
          foreach ($images as $image){
      
            if ($image['fingerprint'] == "")
            continue;
          
            if ($i > 0){
              echo ",";
            }
            $i++;
      
            echo "[ ";
          
            echo '"' . "<i class='fas fa-box-open fa-lg' style='color:#4e73df'></i>" . '",';
            echo '"' . htmlentities($image['properties']['description']) . '",';
            echo '"' . htmlentities($image['fingerprint']) . '",';
            echo '"' . htmlentities($image['type']) . '",';
            echo '"' . htmlentities(number_format($image['size'] / 1048576, 2)) . ' MB",';
      
            echo '"';
            echo "<a href='#' onclick=refreshImage('".$image['fingerprint']."')><i class='fas fa-sync-alt fa-lg' style='color:#ddd' title='Refresh' aria-hidden='true'></i></a>";
            echo " &nbsp ";          
            echo "<a href='#' onclick=loadImageJson('".$image['fingerprint']."')><i class='fas fa-edit fa-lg' style='color:#ddd' title='Edit' aria-hidden='true'></i></a>";
            echo " &nbsp ";
            echo "<a href='#' onclick=deleteImage('".$image['fingerprint']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";  
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

    case "listImagesForSelectOption":
      $url = $base_url . "/1.0/images?recursion=1&project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $images = (isset($results['metadata'])) ? $results['metadata'] : [];
    
      echo '<option value="none">none</option>';
    
      foreach ($images as $image){
    
        if ($image['fingerprint'] == "" || $image['type'] != $image_type)
        continue;
    
        echo '<option value="' . $image['fingerprint'] . '">' . htmlentities($image['properties']['description']) . '</option>';
    
      }
      break;

    case "loadImage":
      $url = $base_url . "/1.0/images/" . $fingerprint . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      echo $results;
      break;

    case "refreshImage":
      $url = $base_url . "/1.0/images/" . $fingerprint . "/refresh?project=" . $project;
      $data = '{}';
      $results = sendCurlRequest($action, "POST", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $fingerprint;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "updateImage":
      $url = $base_url . "/1.0/images/" . $fingerprint . "?project=" . $project;
      $data = $json;
      $results = sendCurlRequest($action, "PUT", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $fingerprint;
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
  echo '{"error": "User is not authenticated", "error_code": "401", "metadata": {"err": "User is not authenticated", "status_code": "401"}}';
}

?>
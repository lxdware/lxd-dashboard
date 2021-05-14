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
  $content_type = (isset($_GET['content_type'])) ? filter_var(urldecode($_GET['content_type']), FILTER_SANITIZE_STRING) : "";
  $name = (isset($_GET['name'])) ? filter_var(urldecode($_GET['name']), FILTER_SANITIZE_STRING) : "";
  $pool = (isset($_GET['pool'])) ? filter_var(urldecode($_GET['pool']), FILTER_SANITIZE_STRING) : "";
  $project = (isset($_GET['project'])) ? filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING) : "";
  $remote = (isset($_GET['remote'])) ? filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_NUMBER_INT) : "";
  $size = (isset($_GET['size'])) ? filter_var(urldecode($_GET['size']), FILTER_SANITIZE_STRING) : "";
  $storage_pool = (isset($_GET['storage_pool'])) ? filter_var(urldecode($_GET['storage_pool']), FILTER_SANITIZE_STRING) : "";
  
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

    case "createStorageVolumeUsingForm":
      $url = $base_url . "/1.0/storage-pools/" . $storage_pool . "/volumes?project=" . $project;
      $data = '{"config": {"size": "'.$size.'GB"}, "name": "'.$name.'", "type": "custom", "content_type": "'.$content_type.'"}';
      $results = sendCurlRequest($action, "POST", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $storage_pool . " - " . $name;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "createStorageVolumeUsingJSON":
      $url = $base_url . "/1.0/storage-pools/" . $storage_pool . "/volumes?project=" . $project;
      $data = $json;
      $results = sendCurlRequest($action, "POST", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $storage_pool . " - " . json_decode($data, true)['name'];
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "deleteStorageVolume":
      $url = $base_url . "/1.0/storage-pools/" . $storage_pool . "/volumes/" . $name . "?project=" . $project;
      $results = sendCurlRequest($action, "DELETE", $url);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $storage_pool . " - " . $name;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "listStorageVolumes":
      if (validateAuthorization($action)) {
        $url = $base_url . "/1.0/storage-pools/" . $pool . "/volumes?recursion=1&project=" . $project;
        $results = sendCurlRequest($action, "GET", $url);
        $results = json_decode($results, true);
        $storage_volumes = (isset($results['metadata'])) ? $results['metadata'] : [];

        $i = 0;
        echo '{ "data": [';

        foreach ($storage_volumes as $storage_volume){
          
          if ($storage_volume['name'] == "")
          continue;

          if ($i > 0){
            echo ",";
          }
          $i++;

          echo "[ ";
          echo '"';
          echo "<i class='fas fa-hdd fa-lg' style='color:#4e73df'></i>";
          echo '",';
          echo '"' . htmlentities($storage_volume['name']) . '",';
          echo '"' . htmlentities($storage_volume['type']) . '",';
          echo '"' . htmlentities($storage_volume['location']) . '",';
          echo '"' . htmlentities($storage_volume['content_type']) . '",';

          echo '"';
          $ii = 0;
          foreach ($storage_volume['used_by'] as $item){
            if ($ii >= 1)
              echo ", ";
            $ii++;
            echo htmlentities($item);
          }
          echo '",';

          echo '"';
          echo "<a href='#' onclick=loadStorageVolumeJson('".$storage_volume['type']."/".$storage_volume['name']."')><i class='fas fa-edit fa-lg' style='color:#ddd' title='Edit' aria-hidden='true'></i></a>";
          echo " &nbsp ";       
          echo "<a href='#' onclick=deleteStorageVolume('".$storage_volume['type']."/".$storage_volume['name']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
          echo '"';

          echo " ]";

        }

        echo " ]}";
      }
      else {
        echo '{ "data": [] }';
      }      
      break;

    case "loadStorageVolume":
      $url = $base_url . "/1.0/storage-pools/" . $storage_pool . "/volumes/" . $name . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      echo $results;
      break;

    case "updateStorageVolume":
      $url = $base_url . "/1.0/storage-pools/" . $storage_pool . "/volumes/" . $name . "?project=" . $project;
      $data = $json;
      $results = sendCurlRequest($action, "PUT", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $storage_pool . " - " . $name;
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
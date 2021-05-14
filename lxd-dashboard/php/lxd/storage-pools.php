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
  $driver = (isset($_GET['driver'])) ? filter_var(urldecode($_GET['driver']), FILTER_SANITIZE_STRING) : "";
  $name = (isset($_GET['name'])) ? filter_var(urldecode($_GET['name']), FILTER_SANITIZE_STRING) : "";
  $project = (isset($_GET['project'])) ? filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING) : "";
  $remote = (isset($_GET['remote'])) ? filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_NUMBER_INT) : "";
  $repo = (isset($_GET['repo'])) ? filter_var(urldecode($_GET['repo']), FILTER_SANITIZE_STRING) : "";
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

    case "createStoragePoolUsingForm":
      //Check to see if host is part of a cluster. Clusted hosts need storage pool created first on each of the hosts
      $url = $base_url . "/1.0/cluster";
      $remote_data = sendCurlRequest($action, "GET", $url);
      $remote_data = json_decode($remote_data, true);
      $cluster_status = $remote_data['metadata'];

      if ($cluster_status['enabled'] == true){
        //Now setup storage pool on each cluster member, putting them in pending status
        $url = $base_url . "/1.0/cluster/members?recursion=1";
        $cluster_api_data = sendCurlRequest($action, "GET", $url);
        $cluster_api_data = json_decode($cluster_api_data, true);
        $cluster_api_data = $cluster_api_data['metadata'];

        foreach ($cluster_api_data as $cluster_data){
          if ($cluster_data['status'] == "Online"){
            $url = $base_url . "/1.0/storage-pools?target=".$cluster_data['server_name']."&project=" . $project;
            if ($driver == "dir" || $driver == "ceph")
              $data = '{"driver": "'.$driver.'","name": "'.$name.'","description": "'.$description.'"}';
            else
              $data = '{"config": {"size": "'.$size.'GB"},"driver": "'.$driver.'","name": "'.$name.'","description": "'.$description.'"}';
              $results = sendCurlRequest($action, "POST", $url, $data);
          }
        }

        //Now lets create the storage pool without config, moving the pending status to created
        $url = $base_url . "/1.0/storage-pools?project=" . $project;
        if ($driver == "dir" || $driver == "ceph")
          $data = '{"driver": "'.$driver.'","name": "'.$name.'","description": "'.$description.'"}';
        else
          $data = '{"config": {},"driver": "'.$driver.'","name": "'.$name.'","description": "'.$description.'"}';
        $results = sendCurlRequest($action, "POST", $url, $data);
      }
      else {
        //This is process of creating storage pool on a non-clustered host
        $url = $base_url . "/1.0/storage-pools?project=" . $project;
        if ($driver == "dir" || $driver == "ceph")
          $data = '{"driver": "'.$driver.'","name": "'.$name.'","description": "'.$description.'"}';
        else
          $data = '{"config": {"size": "'.$size.'GB"},"driver": "'.$driver.'","name": "'.$name.'","description": "'.$description.'"}';
        $results = sendCurlRequest($action, "POST", $url, $data);
      }
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

    case "createStoragePoolUsingJSON":
      $url = $base_url . "/1.0/storage-pools?project=" . $project;
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

    case "deleteStoragePool":
      $url = $base_url . "/1.0/storage-pools/" . $storage_pool . "?project=" . $project;
      $results = sendCurlRequest($action, "DELETE", $url);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $storage_pool;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "listStoragePools":
      if (validateAuthorization($action)) {
        $url = $base_url . "/1.0/storage-pools?recursion=1&project=" . $project;
        $results = sendCurlRequest($action, "GET", $url);
        $results = json_decode($results, true);
        $storage_pools = (isset($results['metadata'])) ? $results['metadata'] : [];
      
        $i = 0;
        echo '{ "data": [';
      
        foreach ($storage_pools as $storage_pool){
          
          if ($storage_pool['name'] == "")
          continue;
      
          if ($i > 0){
            echo ",";
          }
          $i++;
      
          echo "[ ";
          echo '"';
          echo "<a href='storage-volumes.html?pool=".$storage_pool['name']."&remote=".$remote."&project=".$project."'><i class='fas fa-hdd fa-lg' style='color:#4e73df'></i> </a>";
          echo '",';
      
          echo '"';
          echo "<a href='storage-volumes.html?pool=".$storage_pool['name']."&remote=".$remote."&project=".$project."'> ".htmlentities($storage_pool['name'])."</a>";
          echo '",';
      
          echo '"' . htmlentities($storage_pool['description']) . '",';
          echo '"' . htmlentities($storage_pool['driver']) . '",';
          echo '"' . htmlentities($storage_pool['status']) . '",';
          echo '"' . htmlentities($storage_pool['config']['source']) . '",';
          echo '"' . htmlentities($storage_pool['config']['size']) . '",';
      
          echo '"';
          echo "<a href='#' onclick=loadStoragePoolJson('".$storage_pool['name']."')><i class='fas fa-edit fa-lg' style='color:#ddd' title='Edit' aria-hidden='true'></i></a>";
          echo " &nbsp ";
          echo "<a href='#' onclick=deleteStoragePool('".$storage_pool['name']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
          echo '"';
      
          echo " ]";
      
        }
      
        echo " ]}";
      }
      else {
        echo '{ "data": [] }';
      }      
      break;

    case "loadStoragePool":
      $url = $base_url . "/1.0/storage-pools/" . $storage_pool . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      echo $results;
      break;

    case "updateStoragePool":
      $url = $base_url . "/1.0/storage-pools/" . $storage_pool . "?project=" . $project;
      $data = $json;
      $results = sendCurlRequest($action, "PUT", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $storage_pool;
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
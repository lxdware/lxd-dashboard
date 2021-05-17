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
  $force = (isset($_GET['force'])) ? filter_var(urldecode($_GET['force']), FILTER_SANITIZE_STRING) : "false";
  $include_none = (isset($_GET['include_none'])) ? filter_var(urldecode($_GET['include_none']), FILTER_SANITIZE_STRING) : "false";
  $name = (isset($_GET['name'])) ? filter_var(urldecode($_GET['name']), FILTER_SANITIZE_STRING) : "";
  $project = (isset($_GET['project'])) ? filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING) : "";
  $remote = (isset($_GET['remote'])) ? filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_NUMBER_INT) : "";

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

    case "deleteClusterMember":
      if ($force == "true"){
        $url = $base_url . "/1.0/cluster/members/" . $name . "?force=1";
      }
      else {
        $url = $base_url . "/1.0/cluster/members/" . $name;
      }
      $results = sendCurlRequest($action, "DELETE", $url);
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

    case "listClusterMembers":
      if (validateAuthorization($action)) {
        $url = $base_url . "/1.0/cluster";
        $results = sendCurlRequest($action, "GET", $url);
        $results = json_decode($results, true);
        $cluster_status = (isset($results['metadata'])) ? $results['metadata'] : [];

        echo '{ "data": [';

        //Check to see if the host is part of a cluster
        if ($cluster_status['enabled'] == true){
    
          $url = $base_url . "/1.0/cluster/members?recursion=1";
          $results = sendCurlRequest("listClusterMembers", "GET", $url);
          $results = json_decode($results, true);
          $members = (isset($results['metadata'])) ? $results['metadata'] : [];
    
          $i = 0;
      
          foreach ($members as $member){
    
            $database_status = ($member['database']) ? "true" : "false";
    
            if ($i > 0){
              echo ",";
            }
            $i++;
    
            echo "[ ";
            
            echo '"';
            echo "<i class='fas fa-layer-group fa-lg' style='color:#4e73df'></i>";
            echo '",';

            echo '"' . htmlentities($member['server_name']) . '",';
            echo '"' . htmlentities($member['url']) . '",';
            echo '"' . $database_status . '",';
            echo '"' . htmlentities($member['status']) . '",';
            echo '"' . htmlentities($member['message']) . '",';
        
            echo '"';
            echo "<a href='#' onclick=loadDeleteClusterMemberModal('".$member['server_name']."')> <i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i> </a>";
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

    case "listClusterMembersForSelectOption":
      //Instantiate URL variable for REST API
      $url = $base_url . "/1.0/cluster/members?recursion=1";
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $cluster_hosts = (isset($results['metadata'])) ? $results['metadata'] : [];

      //If there is one server and it's status == Offline the host should not be a cluster member, include none
      if (count($cluster_hosts) == 1 && $cluster_hosts[0]['status'] == "Offline"){
        $include_none = "true";
      }
      
      if ($include_none == "true"){
        echo '<option value="none">none</option>';
      }

      foreach ($cluster_hosts as $cluster_host){

        if (strtolower($cluster_host['message']) != "fully operational")
          continue;
      
        echo '<option value="' . $cluster_host['server_name'] . '">' . htmlentities($cluster_host['server_name']) . '</option>';
      }
      break;
      
    default:
      echo '{"status": "Bad Request", "status_code": 400, "metadata": {"err": "Unable to execute action on remote host", "status_code": "400"}}';

  }

}
else {
  echo '{"error": "User is not authenticated", "error_code": "401", "metadata": {"err": "User is not authenticated", "status_code": "401"}}';
}
  
?>
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
  $alias = (isset($_GET['alias'])) ? filter_var(urldecode($_GET['alias']), FILTER_SANITIZE_STRING) : "";
  $external_host = (isset($_GET['external_host'])) ? filter_var(urldecode($_GET['external_host']), FILTER_SANITIZE_STRING) : "";
  $external_port = (isset($_GET['external_port'])) ? filter_var(urldecode($_GET['external_port']), FILTER_SANITIZE_NUMBER_INT) : "";
  $host = (isset($_GET['host'])) ? filter_var(urldecode($_GET['host']), FILTER_SANITIZE_STRING) : "";
  $id = (isset($_GET['id'])) ? filter_var(urldecode($_GET['id']), FILTER_SANITIZE_NUMBER_INT) : "";
  $port = (isset($_GET['port'])) ? filter_var(urldecode($_GET['port']), FILTER_SANITIZE_NUMBER_INT) : "8443";
  $project = (isset($_GET['project'])) ? filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING) : "";
  $remote = (isset($_GET['remote'])) ? filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_NUMBER_INT) : "";
  

  //Require code from lxd-dashboard/backend/config/curl.php
  require_once('../config/curl.php');

  //Require code from lxd-dashboard/backend/config/db.php
  require_once('../config/db.php');

  //Require code from lxd-dashboard/backend/aaa/accounting.php
  require_once('../aaa/accounting.php');

  //Run the matching action
  switch ($action) {

    case "addRemote":
      if (validateAuthorization($action)) {

        if (filter_var($host, FILTER_VALIDATE_IP) || filter_var($host, FILTER_VALIDATE_DOMAIN))
          $valid_domain = true;

        if (filter_var($port, FILTER_VALIDATE_INT))
          $valid_port = true;

        if ($valid_domain && $valid_port){
          $url = "https://" . $host . ":" . $port . "/1.0";
          $results = sendCurlRequest($action, "GET", $url);
          
          $data = json_decode($results, true);
          $data_auth = (isset($data['metadata']['auth'])) ? $data['metadata']['auth'] : "";

          if ($data_auth == "trusted"){
            $record_added = addHost($host, $port, $alias, $external_host, $external_port);

            if ($record_added)
              $results = '{"status": "Ok", "status_code": 200, "metadata": {"status": "Record added"}}';
            else 
              $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Error adding record to database"}}';

          } 
          else {
            if ($data_auth == "untrusted"){
              $results = '{"status": "Unauthorized", "status_code": 401, "metadata": {"error": "Remote host connection is not trusted"}}';
            }
            else {
              $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Unable to connect to remote host"}}';
            } 
          }

        } 
        else {
          $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Invalid host or port"}}';
        }

      }
      else {
        $results = '{"status": "Forbidden", "status_code": 403, "metadata": {"error": "You are not authorized to execute this action"}}';
      }

      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $host . ":" . $port;
      logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      break;

    case "deleteRemote":
      if (validateAuthorization($action)) {
        $record_removed = deleteHost($id);

        if ($record_removed)
        $results =  '{"status": "Ok", "status_code": 200, "metadata": {"status": "Record removed"}}';
        else 
        $results =  '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Unable to remove record from database"}}';

      }
      else {
        $results =  '{"status": "Forbidden", "status_code": 403, "metadata": {"error": "You are not authorized to execute this action"}}';
      }

      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $id;
      logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      break;

    case "retrieveRemoteInfo":
      $results = retrieveHostInfo($id);
      $results = json_encode($results);
      echo $results;
      break;

    case "listRemotes":
      if (validateAuthorization($action)) {
        $rows = retrieveTableRows('lxd_hosts');

        $i = 0;
        echo '{ "data": [';

        foreach ($rows as $row){

          if ($i > 0){
            echo ",";
          }
          $i++;

          echo "[ ";

          echo '"';
            echo "<a href='remotes-single.php?remote=" . $row['id'] . "&project=default'> <i class='fas fa-server fa-lg' style='color:#4e73df'></i> </a>";
          echo '",';

          echo '"';
            echo "<a href='remotes-single.php?remote=" . $row['id'] . "&project=default'>".htmlentities($row['host'])."</a>";
          echo '",';
          
          echo '"' . htmlentities($row['port']) . '",';
          echo '"' . htmlentities($row['alias']) . '",';
          echo '"' . htmlentities($row['external_host']) . '",';

          // 0 is a valid interger value for the database but a reserved unusable port for TCP/UDP
          if ($row['external_port'] == 0) {
            echo '"",';
          }
          else {
            echo '"' . htmlentities($row['external_port']) . '",';
          }
         
          echo '"' . htmlentities($row['protocol']) . '",';

          echo '"';
          echo "<a href='#' onclick=editRemote('".$row['id']."')><i class='fas fa-edit fa-lg' style='color:#ddd' title='Edit' aria-hidden='true'></i></a>";
          echo " &nbsp ";
          echo "<a href='#' onclick=confirmDeleteRemote('".$row['id']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
          echo '"';

          echo " ]";

        }
        
        echo " ]}";
      }
      else {
        echo '{ "data": [] }';
      }      
      break;

    case "listRemotesForSelectOption":
      if (validateAuthorization($action)) {
        $alias = retrieveHostAlias($remote);
        $hostname = retrieveHostName($remote);

        if ($alias != "")
          $display_name = $alias;
        else
          $display_name = $hostname;
 
        //Query database for remote host records
        $rows = retrieveTableRows('lxd_hosts');

        foreach ($rows as $row){
          if ($row['alias'] != "")
            $display_name2 = $row['alias'];
          else
            $display_name2 = $row['host'];

          if ($row['id'] == $remote)
            echo '<option value="remotes-single.php?remote=' . $row['id'] . '&project=' .$project . '" selected>' . htmlentities($display_name2) . '</option>';
          else
            echo '<option value="remotes-single.php?remote=' . $row['id'] . '&project=' .$project . '">' . htmlentities($display_name2) . '</option>';
        }
      }
      break;
    
    case "loadRemote":
      if (validateAuthorization($action)) {
        $results = retrieveHostInfo($remote);
        $results = json_encode($results);
        echo $results;
      }
      break;

    case "updateRemote":
      if (validateAuthorization($action)) {

        if (filter_var($host, FILTER_VALIDATE_IP) || filter_var($host, FILTER_VALIDATE_DOMAIN))
          $valid_domain = true;

        if (filter_var($port, FILTER_VALIDATE_INT))
          $valid_port = true;

        if ($valid_domain && $valid_port){
          $url = "https://" . $host . ":" . $port . "/1.0";
          $results = sendCurlRequest($action, "GET", $url);
          
          $data = json_decode($results, true);
          $data_auth = (isset($data['metadata']['auth'])) ? $data['metadata']['auth'] : "";

          if ($data_auth == "trusted"){

            $record_updated = updateHost($remote, $host, $port, $alias, $external_host, $external_port);

            if ($record_updated)
              $results = '{"status": "Ok", "status_code": 200, "metadata": {"status": "Record added"}}';
            else 
              $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Error adding record to database"}}';

          } 
          else {
            if ($data_auth == "untrusted"){
              $results = '{"status": "Unauthorized", "status_code": 401, "metadata": {"error": "Remote host connection is not trusted"}}';
            }
            else {
              $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Unable to connect to remote host"}}';
            } 
          }

        } 
        else {
          $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Invalid host or port"}}';
        }

      }
      else {
        $results = '{"status": "Forbidden", "status_code": 403, "metadata": {"error": "You are not authorized to execute this action"}}';
      }

      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $host . ":" . $port;
      logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      break;

    default:
      echo '{"status": "Bad Request", "status_code": 400, "metadata": {"err": "Unable to execute action on remote host", "status_code": "400"}}';
  }

}
else {
  echo '{"status": "Unauthorized", "status_code": 401, "metadata": {"error": "Unauthenticated"}}';
}

?>
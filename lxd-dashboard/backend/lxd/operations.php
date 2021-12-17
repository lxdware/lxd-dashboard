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
  $operation = (isset($_GET['operation'])) ? filter_var(urldecode($_GET['operation']), FILTER_SANITIZE_STRING) : "";
  $project = (isset($_GET['project'])) ? filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING) : "";
  $remote = (isset($_GET['remote'])) ? filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_NUMBER_INT) : "";

  //Instantiate the POST variable
  $json = (isset($_POST['json'])) ? $_POST['json'] : "";

  //Require code from lxd-dashboard/backend/config/curl.php
  require_once('../config/curl.php');

  //Require code from lxd-dashboard/backend/config/db.php
  require_once('../config/db.php');

  //Require code from lxd-dashboard/backend/aaa/accounting.php
  require_once('../aaa/accounting.php');

  //Query database for remote host record
  $base_url = retrieveHostURL($remote);

  //Run the matching action
  switch ($action) {

    case "deleteOperation":
      $url = $base_url . "/1.0/operations/" . $operation;
      $results = sendCurlRequest($action, "DELETE", $url);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $operation;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;
    
    case "displayOperationStatus":
      $url = $base_url . "/1.0/operations?recursion=1&project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $operations_data = (isset($results['metadata'])) ? $results['metadata'] : "";

      $results = "";

      if (!empty($operations_data)){

        if (!empty($operations_data['running'])){
          foreach ($operations_data['running'] as $running_task){
            //This is annoyingly showing when using exec terminal, will look to build indicator for when someone is executing a command on instance page instead
            if ($running_task['description'] != "Executing command")
              $results = $running_task['description'];

            if (isset($running_task['resources']['instances'][0])) {
              $instance = basename($running_task['resources']['instances'][0]);
            } 
            else {
              if (isset($running_task['resources']['containers'][0])) {
                $instance = basename($running_task['resources']['containers'][0]);
              }
              else {
                $instance = "";
              }
            }

            switch($running_task['description']){
              case "Backing up container":
                $results .= " " . $instance; 
                break;
              case "Backing up instance":
                $results .= " " . $instance; 
                break;
              case "Creating container":
                $results .= " " . $instance; 
                break;
              case "Creating instance":
                $results .= " " . $instance; 
                break;
              case "Deleting container":
                $results .= " " . $instance; 
                break;
              case "Deleting instance":
                $results .= " " . $instance; 
                break;
              case "Downloading image":
                if (isset($running_task['metadata']['download_progress']))
                  $results .= " " . htmlentities($running_task['metadata']['download_progress']);
                break;
              case "Executing command":
                //if (isset($running_task['metadata']['command'][0]))
                  //$results = "Executing " . htmlentities($running_task['metadata']['command'][0]) . " command on " . htmlentities($instance);
                break;
              case "Freezing instance":
                $results .= " " . $instance;
                break;
              case "Migrating container":
                $results .= " " . $instance; 
                break;
              case "Restarting instance":
                $results .= " " . $instance;
                break;
              case "Restoring backup":
                $results .= " to instance " . $instance; 
                break;
              case "Showing console":
                $results = "Showing console of " . $instance; 
                break;
              case "Starting instance":
                $results .= " " . $instance; 
                break;
              case "Stopping instance":
                $results .= " " . $instance; 
                break;
              case "Updating instance":
                $results .= " " . $instance; 
                break;
            }
          }
        }

        if (!empty($operations_data['failure'])){
          foreach ($operations_data['failure'] as $failed_task){
            if ($failed_task['description'] != "Executing command") //This is to prevent error message when VM is starting up due to CPU and Mem stats
              $results =  $failed_task['description'] . " Error: " . $failed_task['err'];
          }
        }
      
      }
      
      echo $results;
      break;
    case "listOperations":
      if (validateAuthorization($action)) {
        $url = $base_url . "/1.0/operations?recursion=1&project=" . $project;
        $results = sendCurlRequest($action, "GET", $url);
        $results = json_decode($results, true);
        $operations_dict = (isset($results['metadata'])) ? $results['metadata'] : [];

        $i = 0;
        echo '{ "data": [';

        if ($results['status_code'] == "200"){

          foreach ($operations_dict as $operations){

            foreach ($operations as $operation){

              if ($i > 0){
                echo ",";
              }
              $i++;
          
              echo "[ ";
              echo '"';
              echo "<a href='#' onclick=loadOperationJson('".$operation['id']."')> <i class='fas fa-exchange-alt fa-lg' style='color:#4e73df'></i> </a>";    
              echo '",';

              echo '"';
              echo "<a href='#' onclick=loadOperationJson('".$operation['id']."')>".htmlentities($operation['id'])."</a>";
              echo '",';

              echo '"' . htmlentities($operation['class']) . '",';
              echo '"' . htmlentities($operation['description']) . '",';
              echo '"' . htmlentities($operation['status']) . '",';
              echo '"' . htmlentities($operation['created_at']) . '",';

              if($operation['may_cancel']){
                $may_cancel = "true";
                echo '"' . htmlentities($may_cancel) . '",';

                echo '"';
                  echo "<a href='#' onclick=deleteOperation('".$operation['id']."')> <i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i> </a>";
                echo '"';
              }
                
              else{
                $may_cancel = "false";
                echo '"' . htmlentities($may_cancel) . '",';
                echo '" ';
                echo ' "';
              }
              
              echo " ]";
          
            }
          
          }

        }
        
        echo " ]}";
      }
      else {
        echo '{ "data": [] }';
      }      
      break;

    case "loadOperation":
      $url = $base_url . "/1.0/operations/" . $operation;
      $results = sendCurlRequest($action, "GET", $url);
      echo $results;
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
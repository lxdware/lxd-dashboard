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
  $host = (isset($_GET['host'])) ? filter_var(urldecode($_GET['host']), FILTER_SANITIZE_STRING) : "";
  $id = (isset($_GET['id'])) ? filter_var(urldecode($_GET['id']), FILTER_SANITIZE_STRING) : "";
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

    case "addSimplestreams":
      if (validateAuthorization($action)) {
        if (filter_var($host, FILTER_VALIDATE_URL))
          $valid_url = true;

        if ($valid_url){
          $record_added = addSimplestreams($host, $alias);

          if ($record_added)
            $results = '{"status": "Ok", "status_code": 200, "metadata": {"status": "Record added"}}';
          else 
            $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Error adding record to database"}}';

        } 
        else {
          $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Invalid URL"}}';
        }

      }
      else {
        $results = '{"status": "Forbidden", "status_code": 403, "metadata": {"error": "You are not authorized to execute this action"}}';
      }

      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $host;
      logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      break;

    case "deleteSimplestreams":
      if (validateAuthorization($action)) {
        $record_removed = deleteSimplestreams($id);

        if ($record_removed)
          $results = '{"status": "Ok", "status_code": 200, "metadata": {"status": "Record removed"}}';
        else 
          $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Unable to remove record from database"}}';

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

    case "listSimplestreams":
      if (validateAuthorization($action)) {
        $rows = retrieveTableRows('lxd_simplestreams');

        $i = 0;
        echo '{ "data": [';

        foreach ($rows as $row){

          if ($i > 0){
            echo ",";
          }
          $i++;

          echo "[ ";
          echo '"';
          echo "<i class='fas fa-archive fa-lg' style='color:#4e73df'></i>";
          echo '",';
          echo '"' . htmlentities($row['host']) . '",';
          echo '"' . htmlentities($row['alias']) . '",';
          echo '"' . htmlentities($row['protocol']) . '",';

          echo '"';
          echo "<a href='#' onclick=deleteSimplestreams('".$row['id']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
          echo '"';

          echo " ]";

        }

        echo " ]}";
      }
      else {
        echo '{ "data": [] }';
      }      
      break;

    case "listSimplestreamsForSelectOption":
      if (validateAuthorization($action)) {
        $rows = retrieveTableRows('lxd_simplestreams');

        foreach ($rows as $row){
      
          if ($row['alias'] != "")
            $host_display = $row['alias'];
          else 
            $host_display = $row['host'];
      
          echo '<option value="' . $row['host'] . '">' . htmlentities($host_display) . '</option>';
      
        }

      }
      break;

    default:
      echo '{"status": "Bad Request", "status_code": 400, "metadata": {"err": "Unable to execute action on remote host", "status_code": "400"}}';
  
  }

}
else {
  echo "Error: Not Authenticated";
}

?>
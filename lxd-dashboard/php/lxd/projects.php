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
  $name = (isset($_GET['name'])) ? filter_var(urldecode($_GET['name']), FILTER_SANITIZE_STRING) : "";
  $project = (isset($_GET['project'])) ? filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING) : "";
  $remote = (isset($_GET['remote'])) ? filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_NUMBER_INT) : "";

  //Instantiate the POST variable
  $json = (isset($_POST['json'])) ? $_POST['json'] : "";

  //Set the url when switching projects from the dropdown menu
  $return_url = strtok($_SERVER["HTTP_REFERER"], '?');

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

    case "createProject":
      $url = $base_url . "/1.0/projects";
      $data = '{"name":"' . $name . '"}';
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

    case "deleteProject":
      $url = $base_url . "/1.0/projects/" . $name;
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
    
    case "listProjects":
      if (validateAuthorization($action)) {
        $url = $base_url . "/1.0/projects?recursion=1";
        $results = sendCurlRequest($action, "GET", $url);
        $results = json_decode($results, true);
        $projects = (isset($results['metadata'])) ? $results['metadata'] : [];
      
        $i = 0;
        echo '{ "data": [';
      
        foreach ($projects as $project_data){
      
          if ($i > 0){
            echo ",";
          }
          $i++;
      
          echo "[ ";
          echo '"';
          echo "<a href='remotes-single.html?remote=".$remote."&project=".$project_data['name'] ."'><i class='fas fa-chart-bar fa-lg' style='color:#4e73df'></i> </a>";
          echo '",';
      
          echo '"';
          echo "<a href='remotes-single.html?remote=".$remote."&project=".$project_data['name'] ."'> ".htmlentities($project_data['name']) ."</a>";
          echo '",';
      
          echo '"' . htmlentities($project_data['description']) . '",';
          echo '"' . htmlentities($project_data['config']['features.images']) . '",';
          echo '"' . htmlentities($project_data['config']['features.profiles']) . '",';
          echo '"' . htmlentities($project_data['config']['features.storage.volumes']) . '",';
      
          echo '"';
          echo "<a href='#' onclick=loadProjectJson('".$project_data['name']."')><i class='fas fa-edit fa-lg' style='color:#ddd' title='Edit' aria-hidden='true'></i></a>";
          echo " &nbsp ";
          echo "<a href='#' onclick=loadRenameProject('".$project_data['name']."')><i class='fas fa-tag fa-lg' style='color:#ddd' title='Rename' aria-hidden='true'></i></a>";
          echo " &nbsp ";
          echo "<a href='#' onclick=deleteProject('".$project_data['name']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
          echo '"';
      
          echo " ]";
      
        }
      
        echo " ]}";
      }
      else {
        echo '{ "data": [] }';
      }      
      break;

    case "listProjectsForTopNavigation":
      $url = $base_url . "/1.0/projects?recursion=1";
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $projects = (isset($results['metadata'])) ? $results['metadata'] : [];

      echo '<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
      echo '<i class="fas fa-chart-bar mr-2 text-gray-600"></i>';
      echo '<span class="mr-2 d-none d-lg-inline text-gray-600">Project: <font class="text-primary">'. htmlentities($project) . '</font></span>';
      echo '</a>';
      echo '<!-- Dropdown - User Information -->';
      echo '<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">';

      foreach ($projects as $project_data){
      
        if ($project_data['name'] == $project)
          echo '<a class="dropdown-item"  href="'.$return_url.'?remote=' . $remote . '&project=' . $project_data['name'] . '"><i class="fas fa-chart-bar fa-sm fa-fw mr-2 text-gray-900"></i><strong>' . htmlentities($project_data['name']) . '</strong></a>';
        else {
          if (basename($return_url) == "instance.html")
            echo '<a class="dropdown-item"  href="instances.html?remote=' . $remote . '&project=' . $project_data['name'] . '"><i class="fas fa-chart-bar fa-sm fa-fw mr-2 text-gray-600"></i>' . htmlentities($project_data['name']) . '</a>';
          else
            echo '<a class="dropdown-item"  href="'.$return_url.'?remote=' . $remote . '&project=' . $project_data['name'] . '"><i class="fas fa-chart-bar fa-sm fa-fw mr-2 text-gray-600"></i>' . htmlentities($project_data['name']) . '</a>';
        }
      }

      echo '</div>';
      break;

    case "loadProject":
      $url = $base_url . "/1.0/projects/" . $name;
      $results = sendCurlRequest($action, "GET", $url);
      echo $results;
      break;

    case "renameProject":
      $url = $base_url . "/1.0/projects/" . $project;
      $data = '{"name": "' . $name . '"}';
      $results = sendCurlRequest($action, "POST", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $project . " - " . $name;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;
        
    case "updateProject":
      $url = $base_url . "/1.0/projects/" . $project;
      $data = $json;
      $results = sendCurlRequest($action, "PUT", $url, $data);
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

    default:
      $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"err": "Unable to execute action on remote host", "status_code": "400"}}';
      echo $results;

  }

}
else {
  echo '{"error": "not authenticated", "error_code": "401", "metadata": {"err": "not authenticated", "status_code": "401"}}';
}

?>
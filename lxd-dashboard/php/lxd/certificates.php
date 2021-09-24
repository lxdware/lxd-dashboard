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
  $name = (isset($_GET['name'])) ? filter_var(urldecode($_GET['name']), FILTER_SANITIZE_STRING) : "";
  $project = (isset($_GET['project'])) ? filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING) : "";
  $remote = (isset($_GET['remote'])) ? filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_NUMBER_INT) : "";

  //Declare and instantiate POST variables
  $certificate = (isset($_POST['certificate'])) ? $_POST['certificate'] : "";
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

    case "addCertificateUsingForm":
      $url = $base_url . "/1.0/certificates?project=" . $project;
      $certificate = str_replace('-----BEGIN CERTIFICATE-----\n', "", $certificate);
      $certificate = str_replace('-----END CERTIFICATE-----\n', "", $certificate);
    
      $data = '{"name": "'.$name.'", "type": "client", "certificate": "'.$certificate.'"}';
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

    case "addCertificateUsingJSON":
      $url = $base_url . "/1.0/certificates?project=" . $project;
      $data = $json;
      $data = str_replace('-----BEGIN CERTIFICATE-----\n', "", $data);
      $data = str_replace('-----END CERTIFICATE-----\n', "", $data);
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

    case "deleteCertificate":
      $url = $base_url . "/1.0/certificates/" . $fingerprint . "?project=" . $project;
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
    
    case "listCertificates":
      if (validateAuthorization($action)) {
        $url = $base_url . "/1.0/certificates?recursion=1&project=" . $project;
        $results = sendCurlRequest($action, "GET", $url);
        $results = json_decode($results, true);
        $certificates = (isset($results['metadata'])) ? $results['metadata'] : [];
        $i = 0;
        
        echo '{ "data": [';
        
        if ($results['status_code'] == "200"){

          foreach ($certificates as $certificate){
            if ($i > 0){
              echo ",";
            }
            $i++;
          
            echo "[ ";
  
            echo '"';
              echo "<i class='fas fa-wallet fa-lg' style='color:#4e73df'></i>";    
            echo '",';
  
            echo '"';
              echo htmlentities($certificate['name']);
            echo '",';
  
            echo '"' . htmlentities($certificate['type']) . '",';
            echo '"' . htmlentities($certificate['fingerprint']) . '",';
  
            echo '"';
            echo "<a href='#' onclick=loadCertificateJson('".$certificate['fingerprint']."')><i class='fas fa-edit fa-lg' style='color:#ddd' title='Edit' aria-hidden='true'></i></a>";
            echo " &nbsp ";
            echo "<a href='#' onclick=deleteCertificate('".$certificate['fingerprint']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
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

    case "loadCertificate":
      $url = $base_url . "/1.0/certificates/" . $fingerprint . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      echo $results;
      break;

    case "updateCertificate":
      $url = $base_url . "/1.0/certificates/" . $fingerprint . "?project=" . $project;
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
      echo '{"status": "Bad Request", "status_code": 400, "metadata": {"err": "Unknown action was attempted", "status_code": "400"}}';
  }
}
else {
  echo '{"error": "User is not authenticated", "error_code": "401", "metadata": {"err": "User is not authenticated", "status_code": "401"}}';
}

?>
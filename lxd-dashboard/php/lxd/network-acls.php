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
  $destination = (isset($_GET['destination'])) ? filter_var(urldecode($_GET['destination']), FILTER_SANITIZE_STRING) : "";
  $destination_port = (isset($_GET['destination_port'])) ? filter_var(urldecode($_GET['destination_port']), FILTER_SANITIZE_STRING) : "";
  $icmp_code = (isset($_GET['icmp_code'])) ? filter_var(urldecode($_GET['icmp_code']), FILTER_SANITIZE_STRING) : "";
  $icmp_type = (isset($_GET['icmp_type'])) ? filter_var(urldecode($_GET['icmp_type']), FILTER_SANITIZE_STRING) : "";
  $name = (isset($_GET['name'])) ? filter_var(urldecode($_GET['name']), FILTER_SANITIZE_STRING) : "";
  $network_acl = (isset($_GET['network_acl'])) ? filter_var(urldecode($_GET['network_acl']), FILTER_SANITIZE_STRING) : "";
  $project = (isset($_GET['project'])) ? filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING) : "";
  $protocol = (isset($_GET['protocol'])) ? filter_var(urldecode($_GET['protocol']), FILTER_SANITIZE_STRING) : "";
  $remote = (isset($_GET['remote'])) ? filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_NUMBER_INT) : "";
  $repo = (isset($_GET['repo'])) ? filter_var(urldecode($_GET['repo']), FILTER_SANITIZE_STRING) : "";
  $rule = (isset($_GET['rule'])) ? filter_var(urldecode($_GET['rule']), FILTER_SANITIZE_NUMBER_INT) : "";
  $state = (isset($_GET['state'])) ? filter_var(urldecode($_GET['state']), FILTER_SANITIZE_STRING) : "";
  $source = (isset($_GET['source'])) ? filter_var(urldecode($_GET['source']), FILTER_SANITIZE_STRING) : "";
  $source_port = (isset($_GET['source_port'])) ? filter_var(urldecode($_GET['source_port']), FILTER_SANITIZE_STRING) : "";
  $traffic_action = (isset($_GET['traffic_action'])) ? filter_var(urldecode($_GET['traffic_action']), FILTER_SANITIZE_STRING) : "";
  $type = (isset($_GET['type'])) ? filter_var(urldecode($_GET['type']), FILTER_SANITIZE_STRING) : "";
 
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

    case "addTrafficRule":
      $url = $base_url . "/1.0/network-acls/" . $network_acl . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $data = json_decode($results, true);
      $data = $data['metadata'];

      if (empty($data['config'])){
        unset($data['config']);
      }
          
      if ($type == "egress"){
        $count = count($data['egress']);
        $data['egress'][$count]['action'] = $traffic_action;
        $data['egress'][$count]['state'] = $state;
        $data['egress'][$count]['description'] = $description;
        $data['egress'][$count]['source'] = $source;
        $data['egress'][$count]['destination'] = $destination;
        $data['egress'][$count]['protocol'] = $protocol;
        $data['egress'][$count]['source_port'] = $source_port;
        $data['egress'][$count]['destination_port'] = $destination_port;
        $data['egress'][$count]['icmp_type'] = $icmp_type;
        $data['egress'][$count]['icmp_code'] = $icmp_code;
      }
      elseif ($type == "ingress"){
        $count = count($data['ingress']);
        $data['ingress'][$count]['action'] = $traffic_action;
        $data['ingress'][$count]['state'] = $state;
        $data['ingress'][$count]['description'] = $description;
        $data['ingress'][$count]['source'] = $source;
        $data['ingress'][$count]['destination'] = $destination;
        $data['ingress'][$count]['protocol'] = $protocol;
        $data['ingress'][$count]['source_port'] = $source_port;
        $data['ingress'][$count]['destination_port'] = $destination_port;
        $data['ingress'][$count]['icmp_type'] = $icmp_type;
        $data['ingress'][$count]['icmp_code'] = $icmp_code;
      }
      else {
        $data = "";
      }
      
      $data = json_encode($data);
      $results = sendCurlRequest($action, "PUT", $url, $data);
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

    case "createNetworkAclUsingForm":
      $url = $base_url . "/1.0/network-acls?project=" . $project;
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

    case "createNetworkAclUsingJSON":
      $url = $base_url . "/1.0/network-acls?project=" . $project;
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

    case "deleteEgressRule":
      $url = $base_url . "/1.0/network-acls/" . $network_acl . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $data = json_decode($results, true);
      $data = $data['metadata'];

      //Remove rule from Egress array
      unset($data['egress'][$rule]);

      //Remove array indexes so that JSON encode works properly
      $data['egress'] = array_values($data['egress']);
      $data['ingress'] = array_values($data['ingress']);

      if (empty($data['config'])){
        unset($data['config']);
      }

      //Encode the data back to JSON
      $data = json_encode($data);
      
      $results = sendCurlRequest($action, "PUT", $url, $data);
      echo $data;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $network_acl;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "deleteIngressRule":
      $url = $base_url . "/1.0/network-acls/" . $network_acl . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $data = json_decode($results, true);
      $data = $data['metadata'];

      //Remove rule from Ingress array
      unset($data['ingress'][$rule]);

      //Remove array indexes so that JSON encode works properly
      $data['egress'] = array_values($data['egress']);
      $data['ingress'] = array_values($data['ingress']);

      if (empty($data['config'])){
        unset($data['config']);
      }

      //Encode the data back to JSON
      $data = json_encode($data);
      
      $results = sendCurlRequest($action, "PUT", $url, $data);
      echo $data;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $network_acl;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "deleteNetworkAcl":
      $url = $base_url . "/1.0/network-acls/" . $network_acl . "?project=" . $project;
      $results = sendCurlRequest($action, "DELETE", $url);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $network_acl;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    
    case "listEgressRules":
      if (validateAuthorization($action)) {
        $url = $base_url . "/1.0/network-acls/" . $network_acl . "?project=" . $project;
        $results = sendCurlRequest($action, "GET", $url);
        $results = json_decode($results, true);
        $egress_rules = (isset($results['metadata']['egress'])) ? $results['metadata']['egress'] : [];

        $i = 0;
        echo '{ "data": [';

        foreach ($egress_rules as $egress_rule){
          
          $egress_rule_action = (isset($egress_rule['action'])) ? htmlentities($egress_rule['action']) : "";
          $egress_rule_state = (isset($egress_rule['state'])) ? htmlentities($egress_rule['state']) : "";
          $egress_rule_description = (isset($egress_rule['description'])) ? htmlentities($egress_rule['description']) : "";
          $egress_rule_source = (isset($egress_rule['source'])) ? htmlentities($egress_rule['source']) : "";
          $egress_rule_destination = (isset($egress_rule['destination'])) ? htmlentities($egress_rule['destination']) : "";
          $egress_rule_protocol = (isset($egress_rule['protocol'])) ? htmlentities($egress_rule['protocol']) : "";
          $egress_rule_source_port = (isset($egress_rule['source_port'])) ? htmlentities($egress_rule['source_port']) : "";
          $egress_rule_destination_port = (isset($egress_rule['destination_port'])) ? htmlentities($egress_rule['destination_port']) : "";
          $egress_rule_icmp_type = (isset($egress_rule['icmp_type'])) ? htmlentities($egress_rule['icmp_type']) : "";
          $egress_rule_icmp_code = (isset($egress_rule['icmp_code'])) ? htmlentities($egress_rule['icmp_code']) : "";

          if ($i > 0){
            echo ",";
          }
          
          echo "[ ";
  
          echo '"' . "<i class='fas fa-shield-alt fa-lg' style='color:#4e73df'></i>" . '",';
          echo '"' . $egress_rule_action . '",';
          echo '"' . $egress_rule_state . '",';
          echo '"' . $egress_rule_description . '",';
          echo '"' . $egress_rule_source . '",';
          echo '"' . $egress_rule_destination . '",';
          echo '"' . $egress_rule_protocol . '",';
          echo '"' . $egress_rule_source_port . '",';
          echo '"' . $egress_rule_destination_port . '",';
          echo '"' . $egress_rule_icmp_type . '",';
          echo '"' . $egress_rule_icmp_code . '",';

          echo '"';
          echo "<a href='#' onclick=deleteEgressRule('".$i."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
          echo '"';

          echo " ]";
          $i++;
        }

        echo " ]}";
      }
      else {
        echo '{ "data": [] }';
      }      
      break;

    case "listIngressRules":
      if (validateAuthorization($action)) {
        $url = $base_url . "/1.0/network-acls/" . $network_acl . "?project=" . $project;
        $results = sendCurlRequest($action, "GET", $url);
        $results = json_decode($results, true);
        $ingress_rules = (isset($results['metadata']['ingress'])) ? $results['metadata']['ingress'] : [];

        $i = 0;
        echo '{ "data": [';

        foreach ($ingress_rules as $ingress_rule){
          
          $ingress_rule_action = (isset($ingress_rule['action'])) ? htmlentities($ingress_rule['action']) : "";
          $ingress_rule_state = (isset($ingress_rule['state'])) ? htmlentities($ingress_rule['state']) : "";
          $ingress_rule_description = (isset($ingress_rule['description'])) ? htmlentities($ingress_rule['description']) : "";
          $ingress_rule_source = (isset($ingress_rule['source'])) ? htmlentities($ingress_rule['source']) : "";
          $ingress_rule_destination = (isset($ingress_rule['destination'])) ? htmlentities($ingress_rule['destination']) : "";
          $ingress_rule_protocol = (isset($ingress_rule['protocol'])) ? htmlentities($ingress_rule['protocol']) : "";
          $ingress_rule_source_port = (isset($ingress_rule['source_port'])) ? htmlentities($ingress_rule['source_port']) : "";
          $ingress_rule_destination_port = (isset($ingress_rule['destination_port'])) ? htmlentities($ingress_rule['destination_port']) : "";
          $ingress_rule_icmp_type = (isset($ingress_rule['icmp_type'])) ? htmlentities($ingress_rule['icmp_type']) : "";
          $ingress_rule_icmp_code = (isset($ingress_rule['icmp_code'])) ? htmlentities($ingress_rule['icmp_code']) : "";

          if ($i > 0){
            echo ",";
          }
          
          echo "[ ";
  
          echo '"' . "<i class='fas fa-shield-alt fa-lg' style='color:#4e73df'></i>" . '",';
          echo '"' . $ingress_rule_action . '",';
          echo '"' . $ingress_rule_state . '",';
          echo '"' . $ingress_rule_description . '",';
          echo '"' . $ingress_rule_source . '",';
          echo '"' . $ingress_rule_destination . '",';
          echo '"' . $ingress_rule_protocol . '",';
          echo '"' . $ingress_rule_source_port . '",';
          echo '"' . $ingress_rule_destination_port . '",';
          echo '"' . $ingress_rule_icmp_type . '",';
          echo '"' . $ingress_rule_icmp_code . '",';

          echo '"';
          echo "<a href='#' onclick=deleteIngressRule('".$i."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
          echo '"';

          echo " ]";
          $i++;
        }

        echo " ]}";
      }
      else {
        echo '{ "data": [] }';
      }      
      break;

    case "listNetworkAcls":
      if (validateAuthorization($action)) {
        $url = $base_url . "/1.0/network-acls?recursion=1&project=" . $project;
        $results = sendCurlRequest($action, "GET", $url);
        $results = json_decode($results, true);
        $network_acls = (isset($results['metadata'])) ? $results['metadata'] : [];

        $i = 0;
        echo '{ "data": [';

        if ($results['status_code'] == "200"){

          foreach ($network_acls as $network_acl){
            $network_acl_name = (isset($network_acl['name'])) ? htmlentities($network_acl['name']) : "";
            
            if ($network_acl_name == "")
              continue;

            if ($i > 0){
              echo ",";
            }
            $i++;

            echo "[ ";
  
            echo '"';
            echo "<i class='fas fa-shield-alt fa-lg' style='color:#4e73df'></i>";
            echo '",';

            echo '"';
            echo $network_acl_name;
            echo '",';

            echo '"' . htmlentities($network_acl['description']) . '",';

            echo '"';
            echo "<a href='network-acls-ingress.html?network_acl=".$network_acl['name']."&remote=".$remote."&project=".$project."'>".count($network_acl['ingress'])."</a>";
            echo '",';
      
            echo '"';
            echo "<a href='network-acls-egress.html?network_acl=".$network_acl['name']."&remote=".$remote."&project=".$project."'>".count($network_acl['egress'])."</a>";
            echo '",';
            
            $used_by = "";
            $ii = 0;
            foreach($network_acl['used_by'] as $network){
              if ($ii > 0){
                $used_by .= ", ";
              }
              $ii++;
              $used_by .= $network;
            }

            echo '"' . htmlentities($used_by) . '",';

            echo '"';
            echo "<a href='#' onclick=loadNetworkAclJson('".$network_acl['name']."')><i class='fas fa-edit fa-lg' style='color:#ddd' title='Edit' aria-hidden='true'></i></a>";
            echo " &nbsp ";
            echo "<a href='#' onclick=loadRenameNetworkAcl('".$network_acl['name']."')><i class='fas fa-tag fa-lg' style='color:#ddd' title='Rename' aria-hidden='true'></i></a>";
            echo " &nbsp ";
            echo "<a href='#' onclick=deleteNetworkAcl('".$network_acl['name']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
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

    case "loadNetworkAcl":
      $url = $base_url . "/1.0/network-acls/" . $network_acl . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      echo $results;
      break;

    case "renameNetworkAcl":
      $url = $base_url . "/1.0/network-acls/" . $network_acl . "?project=" . $project;
      $data = '{"name": "' . $name . '"}';
      $results = sendCurlRequest($action, "POST", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $network_acl . " - " . $name;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "updateNetworkAcl":
      $url = $base_url . "/1.0/network-acls/" . $network_acl . "?project=" . $project;
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
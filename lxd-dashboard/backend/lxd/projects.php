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
  $features_images = (isset($_GET['features_images'])) ? filter_var(urldecode($_GET['features_images']), FILTER_SANITIZE_STRING) : "";
  $features_networks = (isset($_GET['features_networks'])) ? filter_var(urldecode($_GET['features_networks']), FILTER_SANITIZE_STRING) : "";
  $features_profiles = (isset($_GET['features_profiles'])) ? filter_var(urldecode($_GET['features_profiles']), FILTER_SANITIZE_STRING) : "";
  $features_storage_volumes = (isset($_GET['features_storage_volumes'])) ? filter_var(urldecode($_GET['features_storage_volumes']), FILTER_SANITIZE_STRING) : "";
  $backups_compression_algorithm = (isset($_GET['backups_compression_algorithm'])) ? filter_var(urldecode($_GET['backups_compression_algorithm']), FILTER_SANITIZE_STRING) : "";
  $images_auto_update_cached = (isset($_GET['images_auto_update_cached'])) ? filter_var(urldecode($_GET['images_auto_update_cached']), FILTER_SANITIZE_STRING) : "";
  $images_auto_update_interval = (isset($_GET['images_auto_update_interval'])) ? filter_var(urldecode($_GET['images_auto_update_interval']), FILTER_SANITIZE_STRING) : "";
  $images_compression_algorithm = (isset($_GET['images_compression_algorithm'])) ? filter_var(urldecode($_GET['images_compression_algorithm']), FILTER_SANITIZE_STRING) : "";
  $images_default_architecture = (isset($_GET['images_default_architecture'])) ? filter_var(urldecode($_GET['images_default_architecture']), FILTER_SANITIZE_STRING) : "";
  $images_remote_cache_expiry = (isset($_GET['images_remote_cache_expiry'])) ? filter_var(urldecode($_GET['images_remote_cache_expiry']), FILTER_SANITIZE_STRING) : "";
  $limits_containers = (isset($_GET['limits_containers'])) ? filter_var(urldecode($_GET['limits_containers']), FILTER_SANITIZE_STRING) : "";
  $limits_cpu = (isset($_GET['limits_cpu'])) ? filter_var(urldecode($_GET['limits_cpu']), FILTER_SANITIZE_STRING) : "";
  $limits_disk = (isset($_GET['limits_disk'])) ? filter_var(urldecode($_GET['limits_disk']), FILTER_SANITIZE_STRING) : "";
  $limits_instances = (isset($_GET['limits_instances'])) ? filter_var(urldecode($_GET['limits_instances']), FILTER_SANITIZE_STRING) : "";
  $limits_memory = (isset($_GET['limits_memory'])) ? filter_var(urldecode($_GET['limits_memory']), FILTER_SANITIZE_STRING) : "";
  $limits_networks = (isset($_GET['limits_networks'])) ? filter_var(urldecode($_GET['limits_networks']), FILTER_SANITIZE_STRING) : "";
  $limits_processes = (isset($_GET['limits_processes'])) ? filter_var(urldecode($_GET['limits_processes']), FILTER_SANITIZE_STRING) : "";
  $limits_virtual_machines = (isset($_GET['limits_virtual_machines'])) ? filter_var(urldecode($_GET['limits_virtual_machines']), FILTER_SANITIZE_STRING) : "";
  $name = (isset($_GET['name'])) ? filter_var(urldecode($_GET['name']), FILTER_SANITIZE_STRING) : "";
  $project = (isset($_GET['project'])) ? filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING) : "";
  $remote = (isset($_GET['remote'])) ? filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_NUMBER_INT) : "";
  $restricted = (isset($_GET['restricted'])) ? filter_var(urldecode($_GET['restricted']), FILTER_SANITIZE_STRING) : "";
  $restricted_backups = (isset($_GET['restricted_backups'])) ? filter_var(urldecode($_GET['restricted_backups']), FILTER_SANITIZE_STRING) : "";
  $restricted_cluster_target = (isset($_GET['restricted_cluster_target'])) ? filter_var(urldecode($_GET['restricted_cluster_target']), FILTER_SANITIZE_STRING) : "";
  $restricted_containers_lowlevel = (isset($_GET['restricted_containers_lowlevel'])) ? filter_var(urldecode($_GET['restricted_containers_lowlevel']), FILTER_SANITIZE_STRING) : "";
  $restricted_containers_nesting = (isset($_GET['restricted_containers_nesting'])) ? filter_var(urldecode($_GET['restricted_containers_nesting']), FILTER_SANITIZE_STRING) : "";
  $restricted_containers_privilege = (isset($_GET['restricted_containers_privilege'])) ? filter_var(urldecode($_GET['restricted_containers_privilege']), FILTER_SANITIZE_STRING) : "";
  $restricted_devices_disk = (isset($_GET['restricted_devices_disk'])) ? filter_var(urldecode($_GET['restricted_devices_disk']), FILTER_SANITIZE_STRING) : "";
  $restricted_devices_gpu = (isset($_GET['restricted_devices_gpu'])) ? filter_var(urldecode($_GET['restricted_devices_gpu']), FILTER_SANITIZE_STRING) : "";
  $restricted_devices_infiniband = (isset($_GET['restricted_devices_infiniband'])) ? filter_var(urldecode($_GET['restricted_devices_infiniband']), FILTER_SANITIZE_STRING) : "";
  $restricted_devices_nic = (isset($_GET['restricted_devices_nic'])) ? filter_var(urldecode($_GET['restricted_devices_nic']), FILTER_SANITIZE_STRING) : "";
  $restricted_devices_pci = (isset($_GET['restricted_devices_pci'])) ? filter_var(urldecode($_GET['restricted_devices_pci']), FILTER_SANITIZE_STRING) : "";
  $restricted_devices_proxy = (isset($_GET['restricted_devices_proxy'])) ? filter_var(urldecode($_GET['restricted_devices_proxy']), FILTER_SANITIZE_STRING) : "";
  $restricted_devices_unix_block = (isset($_GET['restricted_devices_unix_block'])) ? filter_var(urldecode($_GET['restricted_devices_unix_block']), FILTER_SANITIZE_STRING) : "";
  $restricted_devices_unix_char = (isset($_GET['restricted_devices_unix_char'])) ? filter_var(urldecode($_GET['restricted_devices_unix_char']), FILTER_SANITIZE_STRING) : "";
  $restricted_devices_unix_hotplug = (isset($_GET['restricted_devices_unix_hotplug'])) ? filter_var(urldecode($_GET['restricted_devices_unix_hotplug']), FILTER_SANITIZE_STRING) : "";
  $restricted_devices_usb = (isset($_GET['restricted_devices_usb'])) ? filter_var(urldecode($_GET['restricted_devices_usb']), FILTER_SANITIZE_STRING) : "";
  $restricted_networks_subnets = (isset($_GET['restricted_networks_subnets'])) ? filter_var(urldecode($_GET['restricted_networks_subnets']), FILTER_SANITIZE_STRING) : "";
  $restricted_networks_uplinks = (isset($_GET['restricted_networks_uplinks'])) ? filter_var(urldecode($_GET['restricted_networks_uplinks']), FILTER_SANITIZE_STRING) : "";
  $restricted_snapshots = (isset($_GET['restricted_snapshots'])) ? filter_var(urldecode($_GET['restricted_snapshots']), FILTER_SANITIZE_STRING) : "";
  $restricted_virtual_machines_lowlevel = (isset($_GET['restricted_virtual_machines_lowlevel'])) ? filter_var(urldecode($_GET['restricted_virtual_machines_lowlevel']), FILTER_SANITIZE_STRING) : "";

  //Instantiate the POST variable
  $json = (isset($_POST['json'])) ? $_POST['json'] : "";

  //Set the url when switching projects from the dropdown menu
  $return_url = strtok($_SERVER["HTTP_REFERER"], '?');

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

    case "createProjectUsingForm":
      $url = $base_url . "/1.0/projects";

      $device_array = array();
      $device_array['name'] = $name;
      $device_array['description'] = $description;
      if (!empty($features_images)){ $device_array['config']['features.images'] = $features_images;}
      if (!empty($features_networks)){ $device_array['config']['features.networks'] = $features_networks;}
      if (!empty($features_profiles)){ $device_array['config']['features.profiles'] = $features_profiles;}
      if (!empty($features_storage_volumes)){ $device_array['config']['features.storage.volumes'] = $features_storage_volumes;}
      if (!empty($backups_compression_algorithm)){ $device_array['config']['backups.compression_algorithm'] = $backups_compression_algorithm;}
      if (!empty($images_auto_update_cached)){ $device_array['config']['images.auto_update_cached'] = $images_auto_update_cached;}
      if (!empty($images_auto_update_interval)){ $device_array['config']['images.auto_update_interval'] = $images_auto_update_interval;}
      if (!empty($images_compression_algorithm)){ $device_array['config']['images.compression_algorithm'] = $images_compression_algorithm;}
      if (!empty($images_default_architecture)){ $device_array['config']['images.default_architecture'] = $images_default_architecture;}
      if (!empty($images_remote_cache_expiry)){ $device_array['config']['images.remote_cache_expiry'] = $images_remote_cache_expiry;}
      if (!empty($limits_containers)){ $device_array['config']['limits.containers'] = $limits_containers;}
      if (!empty($limits_cpu)){ $device_array['config']['limits.cpu'] = $limits_cpu;}
      if (!empty($limits_disk)){ $device_array['config']['limits.disk'] = $limits_disk;}
      if (!empty($limits_instances)){ $device_array['config']['limits.instances'] = $limits_instances;}
      if (!empty($limits_memory)){ $device_array['config']['limits.memory'] = $limits_memory;}
      if (!empty($limits_networks)){ $device_array['config']['limits.networks'] = $limits_networks;}
      if (!empty($limits_processes)){ $device_array['config']['limits.processes'] = $limits_processes;}
      if (!empty($limits_virtual_machines)){ $device_array['config']['limits.virtual-machines'] = $limits_virtual_machines;}
      if (!empty($restricted)){ $device_array['config']['restricted'] = $restricted;}
     
      if ($restricted == "true"){
        if (!empty($restricted_backups)){ $device_array['config']['restricted.backups'] = $restricted_backups;}
        if (!empty($restricted_cluster_target)){ $device_array['config']['restricted.cluster.target'] = $restricted_cluster_target;}
        if (!empty($restricted_containers_lowlevel)){ $device_array['config']['restricted.containers.lowlevel'] = $restricted_containers_lowlevel;}
        if (!empty($restricted_containers_nesting)){ $device_array['config']['restricted.containers.nesting'] = $restricted_containers_nesting;}
        if (!empty($restricted_containers_privilege)){ $device_array['config']['restricted.containers.privilege'] = $restricted_containers_privilege;}
        if (!empty($restricted_devices_disk)){ $device_array['config']['restricted.devices.disk'] = $restricted_devices_disk;}
        if (!empty($restricted_devices_gpu)){ $device_array['config']['restricted.devices.gpu'] = $restricted_devices_gpu;}
        if (!empty($restricted_devices_infiniband)){ $device_array['config']['restricted.devices.infiniband'] = $restricted_devices_infiniband;}
        if (!empty($restricted_devices_nic)){ $device_array['config']['restricted.devices.nic'] = $restricted_devices_nic;}
        if (!empty($restricted_devices_pci)){ $device_array['config']['restricted.devices.pci'] = $restricted_devices_pci;}
        if (!empty($restricted_devices_proxy)){ $device_array['config']['restricted.devices.proxy'] = $restricted_devices_proxy;}
        if (!empty($restricted_devices_unix_block)){ $device_array['config']['restricted.devices.unix-block'] = $restricted_devices_unix_block;}
        if (!empty($restricted_devices_unix_char)){ $device_array['config']['restricted.devices.unix-char'] = $restricted_devices_unix_char;}
        if (!empty($restricted_devices_unix_hotplug)){ $device_array['config']['restricted.devices.unix-hotplug'] = $restricted_devices_unix_hotplug;}
        if (!empty($restricted_devices_usb)){ $device_array['config']['restricted.devices.usb'] = $restricted_devices_usb;}
        if (!empty($restricted_networks_subnets)){ $device_array['config']['restricted.networks.subnets'] = $restricted_networks_subnets;}
        if (!empty($restricted_networks_uplinks)){ $device_array['config']['restricted.networks.uplinks'] = $restricted_networks_uplinks;}
        if (!empty($restricted_snapshots)){ $device_array['config']['restricted.snapshots'] = $restricted_snapshots;}
        if (!empty($restricted_virtual_machines_lowlevel)){ $device_array['config']['restricted.virtual-machines.lowlevel'] = $restricted_virtual_machines_lowlevel;}
      }

      $data = json_encode($device_array);
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

    case "createProjectUsingJSON":
      $url = $base_url . "/1.0/projects";
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
      
        if ($results['status_code'] == "200"){

          foreach ($projects as $project_data){

            $features_images = (isset($project_data['config']['features.images'])) ? htmlentities($project_data['config']['features.images']) : "true";
            $features_networks = (isset($project_data['config']['features.networks'])) ? htmlentities($project_data['config']['features.networks']) : "false";
            $features_profiles = (isset($project_data['config']['features.profiles'])) ? htmlentities($project_data['config']['features.profiles']) : "true";
            $features_storage_volumes = (isset($project_data['config']['features.storage.volumes'])) ? htmlentities($project_data['config']['features.storage.volumes']) : "true";
        
            if ($i > 0){
              echo ",";
            }
            $i++;
        
            echo "[ ";
            echo '"';
            echo "<a href='remotes-single.php?remote=".$remote."&project=".$project_data['name'] ."'><i class='fas fa-chart-bar fa-lg' style='color:#4e73df'></i> </a>";
            echo '",';
        
            echo '"';
            echo "<a href='remotes-single.php?remote=".$remote."&project=".$project_data['name'] ."'> ".htmlentities($project_data['name']) ."</a>";
            echo '",';
        
            echo '"' . htmlentities($project_data['description']) . '",';
            echo '"' . $features_images . '",';
            echo '"' . $features_networks . '",';
            echo '"' . $features_profiles . '",';
            echo '"' . $features_storage_volumes . '",';
        
            echo '"';
            echo "<a href='#' onclick=loadProjectJson('".$project_data['name']."')><i class='fas fa-edit fa-lg' style='color:#ddd' title='Edit' aria-hidden='true'></i></a>";
            echo " &nbsp ";
            echo "<a href='#' onclick=loadRenameProject('".$project_data['name']."')><i class='fas fa-tag fa-lg' style='color:#ddd' title='Rename' aria-hidden='true'></i></a>";
            echo " &nbsp ";
            echo "<a href='#' onclick=deleteProject('".$project_data['name']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
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

    case "listProjectsForSelectOption":
      $url = $base_url . "/1.0/projects?recursion=1";
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $projects = (isset($results['metadata'])) ? $results['metadata'] : [];

      foreach ($projects as $project_data){
      
        if ($project_data['name'] == $project)
          echo '<option value="' . $return_url . '?remote=' . $remote . '&project=' . $project_data['name'] . '" selected>' . htmlentities($project_data['name']) . '</option>';
        else {
          if (basename($return_url) == "virtual-machines-single.php")
            echo '<option value="virtual-machines.php?remote=' . $remote . '&project=' . $project_data['name'] . '" >' . htmlentities($project_data['name']) . '</option>';
          elseif (basename($return_url) == "containers-single.php")
            echo '<option value="containers.php?remote=' . $remote . '&project=' . $project_data['name'] . '" >' . htmlentities($project_data['name']) . '</option>';
          elseif (basename($return_url) == "network-acls-egress.php" || basename($return_url) == "network-acls-ingress.php")
            echo '<option value="network-acls.php?remote=' . $remote . '&project=' . $project_data['name'] . '" >' . htmlentities($project_data['name']) . '</option>';
          elseif (basename($return_url) == "storage-volumes.php")
            echo '<option value="storage-pools.php?remote=' . $remote . '&project=' . $project_data['name'] . '" >' . htmlentities($project_data['name']) . '</option>';
          else
            echo '<option value="'.$return_url.'?remote=' . $remote . '&project=' . $project_data['name'] . '" >' . htmlentities($project_data['name']) . '</option>';
        }
      }
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
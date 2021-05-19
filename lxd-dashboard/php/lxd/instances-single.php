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
  $instance = (isset($_GET['instance'])) ? filter_var(urldecode($_GET['instance']), FILTER_SANITIZE_STRING) : "";
  $project = (isset($_GET['project'])) ? filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING) : "";
  $remote = (isset($_GET['remote'])) ? filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_NUMBER_INT) : "";

  //Declare and instantiate POST variables
  $boot_autostart = (isset($_POST['boot_autostart'])) ? filter_var(urldecode($_POST['boot_autostart']), FILTER_SANITIZE_STRING) : "";
  $boot_autostart_delay = (isset($_POST['boot_autostart_delay'])) ? filter_var(urldecode($_POST['boot_autostart_delay']), FILTER_SANITIZE_STRING) : "";
  $boot_autostart_priority = (isset($_POST['boot_autostart_priority'])) ? filter_var(urldecode($_POST['boot_autostart_priority']), FILTER_SANITIZE_STRING) : "";
  $boot_host_shutdown_timeout = (isset($_POST['boot_host_shutdown_timeout'])) ? filter_var(urldecode($_POST['boot_host_shutdown_timeout']), FILTER_SANITIZE_STRING) : "";
  $boot_stop_priority = (isset($_POST['boot_stop_priority'])) ? filter_var(urldecode($_POST['boot_stop_priority']), FILTER_SANITIZE_STRING) : "";

  $limits_cpu = (isset($_POST['limits_cpu'])) ? filter_var(urldecode($_POST['limits_cpu']), FILTER_SANITIZE_STRING) : "";
  $limits_cpu_allowance = (isset($_POST['limits_cpu_allowance'])) ? filter_var(urldecode($_POST['limits_cpu_allowance']), FILTER_SANITIZE_STRING) : "";
  $limits_cpu_priority = (isset($_POST['limits_cpu_priority'])) ? filter_var(urldecode($_POST['limits_cpu_priority']), FILTER_SANITIZE_STRING) : "";

  $limits_memory = (isset($_POST['limits_memory'])) ? filter_var(urldecode($_POST['limits_memory']), FILTER_SANITIZE_STRING) : "";
  $limits_memory_enforce = (isset($_POST['limits_memory_enforce'])) ? filter_var(urldecode($_POST['limits_memory_enforce']), FILTER_SANITIZE_STRING) : "";
  $limits_memory_hugepages = (isset($_POST['limits_memory_hugepages'])) ? filter_var(urldecode($_POST['limits_memory_hugepages']), FILTER_SANITIZE_STRING) : "";
  $limits_memory_swap = (isset($_POST['limits_memory_swap'])) ? filter_var(urldecode($_POST['limits_memory_swap']), FILTER_SANITIZE_STRING) : "";
  $limits_memory_swap_priority = (isset($_POST['limits_memory_swap_priority'])) ? filter_var(urldecode($_POST['limits_memory_swap_priority']), FILTER_SANITIZE_STRING) : "";

  $security_nesting = (isset($_POST['security_nesting'])) ? filter_var(urldecode($_POST['security_nesting']), FILTER_SANITIZE_STRING) : "";
  $security_privileged = (isset($_POST['security_privileged'])) ? filter_var(urldecode($_POST['security_privileged']), FILTER_SANITIZE_STRING) : "";
  $security_protection_delete = (isset($_POST['security_protection_delete'])) ? filter_var(urldecode($_POST['security_protection_delete']), FILTER_SANITIZE_STRING) : "";

  $snapshots_schedule = (isset($_POST['snapshots_schedule'])) ? filter_var(urldecode($_POST['snapshots_schedule']), FILTER_SANITIZE_STRING) : "";
  $snapshots_schedule_stopped = (isset($_POST['snapshots_schedule_stopped'])) ? filter_var(urldecode($_POST['snapshots_schedule_stopped']), FILTER_SANITIZE_STRING) : "";
  $snapshots_pattern = (isset($_POST['snapshots_pattern'])) ? filter_var(urldecode($_POST['snapshots_pattern']), FILTER_SANITIZE_STRING) : "";
  $snapshots_expiry = (isset($_POST['snapshots_expiry'])) ? filter_var(urldecode($_POST['snapshots_expiry']), FILTER_SANITIZE_STRING) : "";

  //Require code from lxd-dashboard/php/config/curl.php
  require_once('../config/curl.php');

  //Require code from lxd-dashboard/php/config/db.php
  require_once('../config/db.php');

  //Require code from lxd-dashboard/php/aaa/accounting.php
  require_once('../aaa/accounting.php');

  //Query database for remote host record
  $base_url = retrieveHostURL($remote);

  switch ($action) {
    case "displayInstanceInfo":
      $url = $base_url . "/1.0/instances/".$instance."?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $instance_data = (isset($results['metadata'])) ? $results['metadata'] : [];
      
      $name = (isset($instance_data['name'])) ? $instance_data['name'] : "";
      $description = (isset($instance_data['description'])) ? $instance_data['description'] : "N/A";
      $type = (isset($instance_data['type'])) ? $instance_data['type'] : "N/A";
      $status = $instance_data['status']?: "N/A";
      $image = (isset($instance_data['config']['image.description'])) ? $instance_data['config']['image.description'] : "N/A";
      $location = (isset($instance_data['location'])) ? $instance_data['location'] : "Unknown";
      $created = (isset($instance_data['created_at'])) ? $instance_data['created_at'] : "Unknown";

      $boot_autostart = (isset($instance_data['expanded_config']['boot.autostart'])) ? $instance_data['expanded_config']['boot.autostart'] : "";
      $boot_autostart = (isset($instance_data['config']['boot.autostart'])) ? $instance_data['config']['boot.autostart'] : $boot_autostart;

      $boot_autostart_delay = (isset($instance_data['expanded_config']['boot.autostart.delay'])) ? $instance_data['expanded_config']['boot.autostart.delay'] : "";
      $boot_autostart_delay = (isset($instance_data['config']['boot.autostart.delay'])) ? $instance_data['config']['boot.autostart.delay'] : $boot_autostart_delay;

      $boot_autostart_priority = (isset($instance_data['expanded_config']['boot.autostart.priority'])) ? $instance_data['expanded_config']['boot.autostart.priority'] : "";
      $boot_autostart_priority = (isset($instance_data['config']['boot.autostart.priority'])) ? $instance_data['config']['boot.autostart.priority'] : $boot_autostart_priority;

      $boot_host_shutdown_timeout = (isset($instance_data['expanded_config']['boot.host_shutdown_timeout'])) ? $instance_data['expanded_config']['boot.host_shutdown_timeout'] : "";
      $boot_host_shutdown_timeout = (isset($instance_data['config']['boot.host_shutdown_timeout'])) ? $instance_data['config']['boot.host_shutdown_timeout'] : $boot_host_shutdown_timeout;

      $boot_stop_priority = (isset($instance_data['expanded_config']['boot.stop.priority'])) ? $instance_data['expanded_config']['boot.stop.priority'] : "";
      $boot_stop_priority = (isset($instance_data['config']['boot.stop.priority'])) ? $instance_data['config']['boot.stop.priority'] : $boot_stop_priority;
      
      $limits_memory = (isset($instance_data['expanded_config']['limits.memory'])) ? $instance_data['expanded_config']['limits.memory'] : "";
      $limits_memory = (isset($instance_data['config']['limits.memory'])) ? $instance_data['config']['limits.memory'] : $limits_memory;

      $limits_memory_enforce = (isset($instance_data['expanded_config']['limits.memory.enforce'])) ? $instance_data['expanded_config']['limits.memory.enforce'] : "";
      $limits_memory_enforce = (isset($instance_data['config']['limits.memory.enforce'])) ? $instance_data['config']['limits.memory.enforce'] : $limits_memory_enforce;

      $limits_memory_hugepages = (isset($instance_data['expanded_config']['limits.memory.hugepages'])) ? $instance_data['expanded_config']['limits.memory.hugepages'] : "";
      $limits_memory_hugepages = (isset($instance_data['config']['limits.memory.hugepages'])) ? $instance_data['config']['limits.memory.hugepages'] : $limits_memory_hugepages;

      $limits_memory_swap = (isset($instance_data['expanded_config']['limits.memory.swap'])) ? $instance_data['expanded_config']['limits.memory.swap'] : "";
      $limits_memory_swap = (isset($instance_data['config']['limits.memory.swap'])) ? $instance_data['config']['limits.memory.swap'] : $limits_memory_swap;

      $limits_memory_swap_priority = (isset($instance_data['expanded_config']['limits.memory.swap.priority'])) ? $instance_data['expanded_config']['limits.memory.swap.priority'] : "";
      $limits_memory_swap_priority = (isset($instance_data['config']['limits.memory.swap.priority'])) ? $instance_data['config']['limits.memory.swap.priority'] : $limits_memory_swap_priority;

      $security_nesting = (isset($instance_data['expanded_config']['security.nesting'])) ? $instance_data['expanded_config']['security.nesting'] : "";
      $security_nesting = (isset($instance_data['config']['security.nesting'])) ? $instance_data['config']['security.nesting'] : $security_nesting;

      $security_privileged = (isset($instance_data['expanded_config']['security.privileged'])) ? $instance_data['expanded_config']['security.privileged'] : "";
      $security_privileged = (isset($instance_data['config']['security.privileged'])) ? $instance_data['config']['security.privileged'] : $security_privileged;

      $security_protection_delete = (isset($instance_data['expanded_config']['security.protection.delete'])) ? $instance_data['expanded_config']['security.protection.delete'] : "";
      $security_protection_delete = (isset($instance_data['config']['security.protection.delete'])) ? $instance_data['config']['security.protection.delete'] : $security_protection_delete;

      $limits_cpu = (isset($instance_data['expanded_config']['limits.cpu'])) ? $instance_data['expanded_config']['limits.cpu'] : "";
      $limits_cpu = (isset($instance_data['config']['limits.cpu'])) ? $instance_data['config']['limits.cpu'] : $limits_cpu;

      $limits_cpu_allowance = (isset($instance_data['expanded_config']['limits.cpu.allowance'])) ? $instance_data['expanded_config']['limits.cpu.allowance'] : "";
      $limits_cpu_allowance = (isset($instance_data['config']['limits.cpu.allowance'])) ? $instance_data['config']['limits.cpu.allowance'] : $limits_cpu_allowance;

      $limits_cpu_priority = (isset($instance_data['expanded_config']['limits.cpu.priority'])) ? $instance_data['expanded_config']['limits.cpu.priority'] : "";
      $limits_cpu_priority = (isset($instance_data['config']['limits.cpu.priority'])) ? $instance_data['config']['limits.cpu.priority'] : $limits_cpu_priority;

      $snapshots_schedule = (isset($instance_data['expanded_config']['snapshots.schedule'])) ? $instance_data['expanded_config']['snapshots.schedule'] : "";
      $snapshots_schedule = (isset($instance_data['config']['snapshots.schedule'])) ? $instance_data['config']['snapshots.schedule'] : $snapshots_schedule;

      $snapshots_schedule_stopped = (isset($instance_data['expanded_config']['snapshots.schedule.stopped'])) ? $instance_data['expanded_config']['snapshots.schedule.stopped'] : "";
      $snapshots_schedule_stopped = (isset($instance_data['config']['snapshots.schedule.stopped'])) ? $instance_data['config']['snapshots.schedule.stopped'] : $snapshots_schedule_stopped;

      $snapshots_pattern = (isset($instance_data['expanded_config']['snapshots.pattern'])) ? $instance_data['expanded_config']['snapshots.pattern'] : "";
      $snapshots_pattern = (isset($instance_data['config']['snapshots.pattern'])) ? $instance_data['config']['snapshots.pattern'] : $snapshots_pattern;

      $snapshots_expiry = (isset($instance_data['expanded_config']['snapshots.expiry'])) ? $instance_data['expanded_config']['snapshots.expiry'] : "";
      $snapshots_expiry = (isset($instance_data['config']['snapshots.expiry'])) ? $instance_data['config']['snapshots.expiry'] : $snapshots_expiry;
    
      $results = "{";
      $results .= "\"name\": \"".htmlentities($name)."\",";
      $results .= "\"description\": \"".htmlentities($description)."\",";
      $results .= "\"type\": \"".htmlentities($type)."\",";
      $results .= "\"status\": \"".htmlentities($status)."\",";
      $results .= "\"image\": \"".htmlentities($image)."\",";
      $results .= "\"location\": \"".htmlentities($location)."\",";
      $results .= "\"created\": \"".htmlentities($created)."\",";

      $results .= "\"bootAutostart\": \"".htmlentities($boot_autostart)."\",";
      $results .= "\"bootAutostartDelay\": \"".htmlentities($boot_autostart_delay )."\",";
      $results .= "\"bootAutostartPriority\": \"".htmlentities($boot_autostart_priority)."\",";
      $results .= "\"bootHostShutdownTimeout\": \"".htmlentities($boot_host_shutdown_timeout)."\",";
      $results .= "\"bootStopPriority\": \"".htmlentities($boot_stop_priority)."\",";

      $results .= "\"limitsMemory\": \"".htmlentities($limits_memory)."\",";
      $results .= "\"limitsMemoryEnforce\": \"".htmlentities($limits_memory_enforce)."\",";
      $results .= "\"limitsMemoryHugepages\": \"".htmlentities($limits_memory_hugepages)."\",";
      $results .= "\"limitsMemorySwap\": \"".htmlentities($limits_memory_swap)."\",";
      $results .= "\"limitsMemorySwapPriority\": \"".htmlentities($limits_memory_swap_priority)."\",";

      $results .= "\"securityNesting\": \"".htmlentities($security_nesting)."\",";
      $results .= "\"securityPrivileged\": \"".htmlentities($security_privileged)."\",";
      $results .= "\"securityProtectionDelete\": \"".htmlentities($security_protection_delete)."\",";

      $results .= "\"limitsCpu\": \"".htmlentities($limits_cpu)."\",";
      $results .= "\"limitsCpuAllowance\": \"".htmlentities($limits_cpu_allowance)."\",";
      $results .= "\"limitsCpuPriority\": \"".htmlentities($limits_cpu_priority)."\",";

      $results .= "\"snapshotsSchedule\": \"".htmlentities($snapshots_schedule)."\",";
      $results .= "\"snapshotsScheduleStopped\": \"".htmlentities($snapshots_schedule_stopped)."\",";
      $results .= "\"snapshotsPattern\": \"".htmlentities($snapshots_pattern)."\",";
      $results .= "\"snapshotsExpiry\": \"".htmlentities($snapshots_expiry)."\"";
      $results .= "}";

      echo $results;

      break;

    case "displayInstanceStateInfo":
      $url = $base_url . "/1.0/instances/".$instance."/state?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $instance_state = (isset($results['metadata'])) ? $results['metadata'] : [];

      $pid = (isset($instance_state['pid'])) ? $instance_state['pid'] : "Unknown"; //process ID on the host
      $processes = (isset($instance_state['processes'])) ? $instance_state['processes'] : "Unknown"; //number of process running in container
      $cpu = (isset($instance_state['cpu']['usage'])) ? $instance_state['cpu']['usage'] : "Unknown"; //cpu usage in nanoseconds
      $memory = (isset($instance_state['memory']['usage'])) ? $instance_state['memory']['usage'] : 0;
      $swap = (isset($instance_state['memory']['swap_usage'])) ? $instance_state['memory']['swap_usage'] : 0;
      $network_interfaces = (isset($instance_state['network'])) ? $instance_state['network'] : []; //array of networks

      //Format memory output
      if ($memory < 1073741824){
        $memory = number_format($memory/1024/1024, 2); //total amount of memory used in MB
        $memory_unit = "MB";
      }
      else {
        $memory = number_format($memory/1024/1024/1024, 2); //total amount of memory used in GB
        $memory_unit = "GB";
      }

      //Format swap memory output
      if ($swap < 1073741824){
        $swap = number_format($swap/1024/1024, 2); //total amount of swap memory used in MB
        $swap_unit = "MB";
      }
      else {
        $swap = number_format($swap/1024/1024/1024, 2); //total amount of swap memory used in GB
        $swap_unit = "GB";
      }


      $i = 0;
      $ipv4_addresses = "";
      foreach ($network_interfaces as $network_interface){
        foreach ($network_interface['addresses'] as $address){
          if ($address['family'] == "inet" && $address['scope'] == "global"){
            if ($i > 0)
              $ipv4_addresses .=  ", ";
            
            $ipv4_addresses .= $address['address'] . "/" . $address['netmask'];
            $i++;
          }
        }
      }

      $i = 0;
      $ipv6_addresses = "";
      foreach ($network_interfaces as $network_interface){
        foreach ($network_interface['addresses'] as $address){
          if ($address['family'] == "inet6" && $address['scope'] == "global"){
            if ($i > 0)
              $ipv6_addresses .=  ", ";

            $ipv6_addresses .= $address['address'];
            $i++;
          }
        }
      }

      $results = "{";
      $results .= "\"memory\": \"".htmlentities($memory). " " . $memory_unit . "\",";
      $results .= "\"swap\": \"".htmlentities($swap). " " . $swap_unit . "\",";
      $results .= "\"pid\": \"".htmlentities($pid)."\",";
      $results .= "\"processes\": \"".htmlentities($processes)."\",";
      $results .= "\"ipv4Addresses\": \"".htmlentities($ipv4_addresses)."\",";
      $results .= "\"ipv6Addresses\": \"".htmlentities($ipv6_addresses)."\"";
      $results .= "}";

      echo $results;

      break;

    case "establishInstanceWebSocketConsoleConnection":
      $url = $base_url . "/1.0/instances/".$instance."/console?project=" . $project;
      //$data = '{ "command": ["/bin/bash"], "wait-for-websocket": true, "record-output": false, "interactive": true, "width": 80, "height": 25, "user": 0, "group": 0, "cwd": "/~" }';
      $data = '{ "type": "console", "width": 80, "height": 25 }';
      $results = sendCurlRequest($action, "POST", $url, $data);

      $exec_api_data = json_decode($results, true);
      $operation = $exec_api_data['operation']; //$operation = "/1.0/operations/d77f70b9-ae8d-4a47-9935-4d49d707f0aa";
      $secret = $exec_api_data['metadata']['metadata']['fds']["0"]; //$secret = "64f5592ee1bc64b8b699e232371dd1286465bafa4a9e688ea7a9cc48f785e98e";

      $results = '{"operation": "'.$operation.'", "secret": "'.$secret.'"}';
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance;
      logEvent($action, $remote, $project, $object, '200', 'Ok');

      break;
      
    case "listInstanceBackups":
      $url = $base_url . "/1.0/instances/" . $instance . "/backups?recursion=1&project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $instance_backups = (isset($results['metadata'])) ? $results['metadata'] : [];

      //Get array of backup operations
      $url = $base_url . "/1.0/operations?recursion=1&project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $operations_data = (isset($results['metadata'])) ? $results['metadata'] : "";
      $current_backups = [];
      if (!empty($operations_data)){
        if (!empty($operations_data['running'])){
          foreach ($operations_data['running'] as $running_task){
            if (isset($running_task['resources']['backups'][0])) {
              array_push($current_backups, basename($running_task['resources']['backups'][0]));
            }
          }
        }
      }

      $i = 0;
      echo '{ "data": [';

      foreach ($instance_backups as $instance_backup){

        $instance_only = ($instance_backup['instance_only'])?"true":"false";
        $container_only = ($instance_backup['container_only'])?"true":"false";
        $optimized_storage = ($instance_backup['optimized_storage'])?"true":"false";
        $hostname = retrieveHostName($remote);
        $file = '/var/lxdware/backups/' . $hostname . '/' . $project . '/' . $instance . '/' . $instance_backup['name'];
        $file_exists = false;

        if ($i > 0){
          echo ",";
        }
        $i++;

        echo "[ ";

        echo '"' . "<i class='fas fa-save fa-lg' style='color:#4e73df'></i>" . '",';

        if (file_exists($file)){
          $file_exists = true;
          $file_size = filesize($file);
          $unit_size = "bytes";
          if ($file_size >= 1024){
            $file_size = $file_size / 1024;
            $unit_size = "KB";
          }
          if ($file_size >= 1024){
            $file_size = $file_size / 1024;
            $unit_size = "MB";
          }
          if ($file_size >= 1024){
            $file_size = $file_size / 1024;
            $unit_size = "GB";
          }
          if ($file_size >= 1024){
            $file_size = $file_size / 1024;
            $unit_size = "TB";
          }
          //echo '"' . "<a href='./php/lxd/instances.php?remote=".$remote."&project=".$project."&instance=".$instance."&name=".$instance_backup['name']."&action=downloadInstanceExportFile'>".htmlentities(basename($file))."</a> (".number_format($file_size,1)." ".$unit_size.")" . '",';
          echo '"' . "<a href='./php/lxd/instances.php?remote=".$remote."&project=".$project."&instance=".$instance."&name=".$instance_backup['name']."&action=downloadInstanceExportFile'>".htmlentities(basename($file))."</a>" . '",';
        }
        else{
          echo '"' . htmlentities($instance_backup['name']) . '", ';
        }

      
        //LXD version of backup datetime: 2021-04-28T09:26:50-04:00
        $dt = new DateTime($instance_backup['created_at']);
        echo '"' . htmlentities($dt->format('Y-m-d H:i:s')) . '",';
 
 
        //LXD version of backup datetime for no expiration: 0000-12-31T18:27:49-05:32
        if ($instance_backup['expires_at'] == "0000-12-31T18:27:49-05:32"){
          echo '"Never",';
        }
        else {
          $dt = new DateTime($instance_backup['expires_at']);
          echo '"' . htmlentities($dt->format('Y-m-d H:i:s')) . '",';
        }

        //echo '"' . htmlentities($instance_backup['created_at']) . '",';
        //echo '"' . htmlentities($instance_backup['expires_at']) . '",';
        echo '"' . htmlentities($instance_only) . '",';
        echo '"' . htmlentities($optimized_storage) . '",';

        echo '"';
          //check to see if file does not exist and also make sure backup operation isn't running for export action
          if (!$file_exists && !in_array($instance_backup['name'], $current_backups)){
            echo "<a href='#' onclick=exportInstanceBackup('".$instance_backup['name']."')><i class='fas fa-file-export fa-lg' style='color:#ddd' title='Export to local file' aria-hidden='true'></i></a>";
            echo " &nbsp ";
          }
        
          echo "<a href='#' onclick=deleteInstanceBackup('".$instance_backup['name']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
          
        echo '"';

        echo " ]";
        
      }

      echo " ]}";
      break;

    case "listInstanceDiskDevices":
      $url = $base_url . "/1.0/instances/" . $instance . "/state?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $disk_names = (isset($results['metadata']['disk'])) ? $results['metadata']['disk'] : [];

      //Retrieve Expanded Device information to get a list of disks
      $url = $base_url . "/1.0/instances/" . $instance . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $device_names = (isset($results['metadata']['expanded_devices'])) ? $results['metadata']['expanded_devices'] : [];

      $i = 0;
      echo '{ "data": [';

      //Loop through the expanded devices
      foreach ($device_names as $device_name => $device_data){
        $disk_path = (isset($device_data['path'])) ? $device_data['path'] : "";
        $disk_type = $device_data['type'];
        $disk_usage = "";
        $disk_unit = "";
        
        //Proceed only if a disk device
        if ($disk_type == "disk"){

          //Determine if there is usage data available for disk device
          foreach ($disk_names as $disk_name => $disk_data){
            if ($device_name == $disk_name){
              $disk_usage = $disk_data['usage']/1024/1024;
              $disk_unit = "MB";
              if ($disk_usage >= 1024){
                $disk_usage = $disk_usage/1024;
                $disk_unit = "GB";
              }
              if ($disk_usage >= 1024){
                $disk_usage = $disk_usage/1024;
                $disk_unit = "TB";
              }
              $disk_usage = number_format($disk_usage,2);
            }
          }
          
          if ($i > 0){
            echo ",";
          }
          $i++;
  
          echo "[ ";
  
          echo '"';
            echo "<i class='fas fa-hdd fa-lg' style='color:#4e73df'></i>";
          echo '",';
  
          echo '"' . htmlentities($device_name) . '",';
          echo '"' . htmlentities($disk_path) . '",';
          echo '"' . htmlentities($disk_usage) . " " . $disk_unit . '",';
          echo '"' . htmlentities($disk_type) . '"';

          echo " ]";

        }

      }

      echo " ]}";
      break;

    case "listInstanceLogs":
      $url = $base_url . "/1.0/instances/" . $instance . "/logs?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $instance_logs = (isset($results['metadata'])) ? $results['metadata'] : [];

      $i = 0;
      echo '{ "data": [';

      foreach ($instance_logs as $instance_log){

        if ($i > 0){
          echo ",";
        }
        $i++;

        echo "[ ";

        echo '"' . "<i class='fas fa-history fa-lg' style='color:#4e73df'></i>" . '",';

        echo '"' . htmlentities($instance_log) . '",';

        echo '"';
       
          echo "<a href='#' onclick=loadInstanceLog('".$instance_log."')><i class='fas fa-file fa-lg' style='color:#ddd' title='Display' aria-hidden='true'></i></a>";
          echo " &nbsp ";
        
          echo "<a href='#' onclick=deleteInstanceLog('".$instance_log."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
        
        echo '"';

        echo " ]";

      }
      
      echo " ]}";
      break;

    case "listInstanceNetworkDevices":
      $url = $base_url . "/1.0/instances/" . $instance . "/state?recursion=1&project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $networks = (isset($results['metadata']['network'])) ? $results['metadata']['network'] : [];

      $i = 0;
      echo '{ "data": [';

      foreach ($networks as $network => $network_data){

        if ($i > 0){
          echo ",";
        }
        $i++;

        echo "[ ";

        echo '"';
          if ($network_data['state'] == "up")
            echo "<i class='fas fa-network-wired fa-lg' style='color:#4e73df'></i>";
          else
            echo "<i class='fas fa-network-wired fa-lg' style='color:#ddd'></i>";
        echo '",';

        echo '"' . htmlentities($network) . '",';
        echo '"' . htmlentities($network_data['hwaddr']) . '",';

        echo '"';
          $ii = 0;
          foreach ($network_data['addresses'] as $address){
            if ($address['family'] == "inet"){
              if ($ii > 0)
                echo "<br />";
              echo htmlentities($address['address']) . "/" . htmlentities($address['netmask']);
              $ii++;
            }
          }
        echo '",';

        echo '"';
          $ii = 0;
          foreach ($network_data['addresses'] as $address){
            if ($address['family'] == "inet6"){
              if ($ii > 0)
                echo "<br />";
              echo htmlentities($address['address']);
              $ii++;
            }
          }
        echo '",';

        echo '"' . htmlentities($network_data['state']) . '"';

        echo " ]";

      }

      echo " ]}";
  
      break;

    case "listInstanceProfiles":
      $url = $base_url . "/1.0/instances/" . $instance . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $profile_names = (isset($results['metadata']['profiles'])) ? $results['metadata']['profiles'] : [];

      $i = 0;
      echo '{ "data": [';
        
      foreach ($profile_names as $profile_name){
        $url = $base_url . "/1.0/profiles/" . $profile_name . "?project=" . $project;
        $results = sendCurlRequest($action, "GET", $url);
        $results = json_decode($results, true);
        $profile_data = (isset($results['metadata'])) ? $results['metadata'] : [];

        if ($profile_data['name'] == "")
        continue;

        if ($i > 0){
          echo ",";
        }
        $i++;

        echo "[ ";

        echo '"';
          echo "<i class='fas fa-address-card fa-lg' style='color:#4e73df'></i>";
        echo '",';

        echo '"';
          echo htmlentities($profile_data['name']);
        echo '",';

        echo '"';
          echo htmlentities($profile_data['description']);
        echo '",';

        echo '"';
          echo "<a href='#' onclick=detachInstanceProfile('".$profile_data['name']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Detach' aria-hidden='true'></i></a>";
        echo '"';

        echo " ]";

      }

      echo " ]}";
      break;
      
    case "listInstanceProxyDevices":
      $url = $base_url . "/1.0/instances/" . $instance . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $device_names = (isset($results['metadata']['expanded_devices'])) ? $results['metadata']['expanded_devices'] : [];
    
      $i = 0;
      echo '{ "data": [';
    
      foreach ($device_names as $device_name => $device_data){
        if ($device_data['type'] == "proxy"){

          if ($i > 0){
            echo ",";
          }
          $i++;

          echo "[ ";

          echo '"' . "<i class='fas fa-exchange-alt fa-lg' style='color:#4e73df'></i>" . '",';

          echo '"' . htmlentities($device_name) . '",';
          echo '"' . htmlentities($device_data['connect']) . '",';
          echo '"' . htmlentities($device_data['listen']) . '",';
          echo '"' . htmlentities($device_data['type']) . '"';

          echo " ]";
    
        }

      }
      
      echo " ]}";
      break;

    case "listInstanceSnapshots":
      $url = $base_url . "/1.0/instances/" . $instance . "/snapshots?recursion=1&project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $snapshots = (isset($results['metadata'])) ? $results['metadata'] : [];

      $i = 0;
      echo '{ "data": [';

      foreach ($snapshots as $snapshot){

        if ($snapshot['name'] == "")
        continue;

        if ($snapshot['stateful'])
          $state = "stateful";
        else
          $state = "stateless";

        if ($i > 0){
          echo ",";
        }
        $i++;

        echo "[ ";

        echo '"' . "<i class='fas fa-clone fa-lg' style='color:#4e73df'></i>" . '",';

        echo '"' . htmlentities($snapshot['name']) . '",';
        echo '"' . htmlentities($state) . '",';
        echo '"' . htmlentities(number_format($snapshot['size']/1024/1024,2)) . "MB" . '",';

        //PHP can't convert milliseconds in ISO8601 format, remove them.
         //LXD version of datetime: 2021-04-28T08:44:22.271358535-04:00
        $date_time_without_milliseconds = substr($snapshot['created_at'], 0, 19);
        $date_time_offset = substr(-6, 6);
        $date_time = $date_time_without_milliseconds . $date_time_offset;
        $dt = new DateTime($date_time);
        echo '"' . htmlentities($dt->format('Y-m-d H:i:s')) . '",';

        //LXD version of datetime for no expiration: 0001-01-01T00:00:00Z
        if ($snapshot['expires_at'] == "0001-01-01T00:00:00Z"){
          echo '"Never",';
        }
        else {
          $date_time_without_milliseconds = substr($snapshot['expires_at'], 0, 19);
          $date_time_offset = substr(-6, 6);
          $date_time = $date_time_without_milliseconds . $date_time_offset;
          $dt = new DateTime($date_time);
          echo '"' . htmlentities($dt->format('Y-m-d H:i:s')) . '",';
        }

        echo '"';
       
          echo "<a href='#' onclick=restoreInstanceSnapshot('".$snapshot['name']."')><i class='fas fa-window-restore fa-lg' style='color:#ddd' title='Restore Snapshot' aria-hidden='true'></i></a>";
          echo " &nbsp ";
        
          echo "<a href='#' onclick=loadCreateInstanceFromSnapshotModal('".$snapshot['name']."')><i class='fas fa-cube fa-lg' style='color:#ddd' title='Create Instance' aria-hidden='true'></i></a>";
          echo " &nbsp ";
        
          echo "<a href='#' onclick=loadPublishImageFromSnapshotModal('".$snapshot['name']."')><i class='fas fa-box-open fa-lg' style='color:#ddd' title='Publish Image' aria-hidden='true'></i></a>";
          echo " &nbsp ";
        
          echo "<a href='#' onclick=deleteInstanceSnapshot('".$snapshot['name']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
        
        echo '"';

        echo " ]";

      }
      
      echo " ]}";
      break;

    case "retrieveInstanceState":
      $url = $base_url . "/1.0/instances/" . $instance . "/state?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      echo $results;
      break;

    case "retrieveHostAndPort":
      $host = retrieveHostName($remote);
      $port = retrieveHostPort($remote);
      $results =  '{"host": "'.$host.'", "port": "'.$port.'"}';
      echo $results;
      break;

    case "updateInstanceBootConfiguration":
      $url = $base_url . "/1.0/instances/" . $instance . "?project=" . $project;
      $data = '{"config": {"boot.autostart":"'.$boot_autostart.'", "boot.autostart.delay":"'.$boot_autostart_delay.'", "boot.autostart.priority":"'.$boot_autostart_priority.'", "boot.host_shutdown_timeout":"'.$boot_host_shutdown_timeout.'", "boot.stop.priority":"'.$boot_stop_priority.'"}}';
      $results = sendCurlRequest($action, "PATCH", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "updateInstanceCpuLimits":
      $url = $base_url . "/1.0/instances/" . $instance . "?project=" . $project;
      $data = '{"config": {"limits.cpu":"'.$limits_cpu.'", "limits.cpu.allowance":"'.$limits_cpu_allowance.'", "limits.cpu.priority":"'.$limits_cpu_priority.'"}}';
      $results = sendCurlRequest($action, "PATCH", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "updateInstanceMemoryLimits":
      $url = $base_url . "/1.0/instances/" . $instance . "?project=" . $project;
      $data = '{"config": {"limits.memory":"'.$limits_memory.'", "limits.memory.enforce":"'.$limits_memory_enforce.'", "limits.memory.hugepages":"'.$limits_memory_hugepages.'", "limits.memory.swap":"'.$limits_memory_swap.'", "limits.memory.swap.priority": "'.$limits_memory_swap_priority.'"}}';
      $results = sendCurlRequest($action, "PATCH", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "updateInstanceSecurityConfiguration":
      $url = $base_url . "/1.0/instances/" . $instance . "?project=" . $project;
      $data = '{"config": {"security.nesting":"'.$security_nesting.'", "security.privileged":"'.$security_privileged.'", "security.protection.delete":"'.$security_protection_delete.'"}}';
      $results = sendCurlRequest($action, "PATCH", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "updateInstanceSnapshotConfiguration":
      $url = $base_url . "/1.0/instances/" . $instance . "?project=" . $project;
      $data = '{"config": {"snapshots.schedule":"'.$snapshots_schedule.'", "snapshots.schedule.stopped":"'.$snapshots_schedule_stopped.'", "snapshots.pattern":"'.$snapshots_pattern.'", "snapshots.expiry":"'.$snapshots_expiry.'"}}';
      $results = sendCurlRequest($action, "PATCH", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;
    
  }
    
}
?>
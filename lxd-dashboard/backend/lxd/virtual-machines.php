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
  $remote = (isset($_GET['remote'])) ? filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_NUMBER_INT) : "";
  $project = (isset($_GET['project'])) ? filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING) : "";
  $instance = (isset($_GET['instance'])) ? filter_var(urldecode($_GET['instance']), FILTER_SANITIZE_STRING) : "";
  $action = (isset($_GET['action'])) ? filter_var(urldecode($_GET['action']), FILTER_SANITIZE_STRING) : "";
  $name = (isset($_GET['name'])) ? filter_var(urldecode($_GET['name']), FILTER_SANITIZE_STRING) : "";
  $profile = (isset($_GET['profile'])) ? filter_var(urldecode($_GET['profile']), FILTER_SANITIZE_STRING) : "default";
  $fingerprint = (isset($_GET['fingerprint'])) ? filter_var(urldecode($_GET['fingerprint']), FILTER_SANITIZE_STRING) : "none";
  $type = (isset($_GET['type'])) ? filter_var(urldecode($_GET['type']), FILTER_SANITIZE_STRING) : "";
  $instance_type = (isset($_GET['instance_type'])) ? filter_var(urldecode($_GET['instance_type']), FILTER_SANITIZE_STRING) : "";
  $description = (isset($_GET['description'])) ? filter_var(urldecode($_GET['description']), FILTER_SANITIZE_STRING) : "";
  $public = (isset($_GET['public'])) ? filter_var(urldecode($_GET['public']), FILTER_SANITIZE_STRING) : "";
  $path = (isset($_GET['path'])) ? filter_var(urldecode($_GET['path']), FILTER_SANITIZE_STRING) : "";
  $location = (isset($_GET['location'])) ? filter_var(urldecode($_GET['location']), FILTER_SANITIZE_STRING) : "none";
  $stateful = (isset($_GET['stateful'])) ? filter_var(urldecode($_GET['stateful']), FILTER_SANITIZE_STRING) : "";
  $os = (isset($_GET['os'])) ? filter_var(urldecode($_GET['os']), FILTER_SANITIZE_STRING) : "";
  $release = (isset($_GET['release'])) ? filter_var(urldecode($_GET['release']), FILTER_SANITIZE_STRING) : "";
  $snapshot = (isset($_GET['snapshot'])) ? filter_var(urldecode($_GET['snapshot']), FILTER_SANITIZE_STRING) : "";
  $instance_only = (isset($_GET['instance_only'])) ? filter_var(urldecode($_GET['instance_only']), FILTER_SANITIZE_STRING) : "";
  $optimized_storage = (isset($_GET['optimized_storage'])) ? filter_var(urldecode($_GET['optimized_storage']), FILTER_SANITIZE_STRING) : "";
  $compression_algorithm = (isset($_GET['compression_algorithm'])) ? filter_var(urldecode($_GET['compression_algorithm']), FILTER_SANITIZE_STRING) : "";

  $boot_autostart = (isset($_GET['boot_autostart'])) ? filter_var(urldecode($_GET['boot_autostart']), FILTER_SANITIZE_STRING) : "";
  $boot_autostart_delay = (isset($_GET['boot_autostart_delay'])) ? filter_var(urldecode($_GET['boot_autostart_delay']), FILTER_SANITIZE_STRING) : "";
  $boot_autostart_priority = (isset($_GET['boot_autostart_priority'])) ? filter_var(urldecode($_GET['boot_autostart_priority']), FILTER_SANITIZE_STRING) : "";
  $boot_host_shutdown_timeout = (isset($_GET['boot_host_shutdown_timeout'])) ? filter_var(urldecode($_GET['boot_host_shutdown_timeout']), FILTER_SANITIZE_STRING) : "";
  $boot_stop_priority = (isset($_GET['boot_stop_priority'])) ? filter_var(urldecode($_GET['boot_stop_priority']), FILTER_SANITIZE_STRING) : "";
  $cluster_evacuate = (isset($_GET['cluster_evacuate'])) ? filter_var(urldecode($_GET['cluster_evacuate']), FILTER_SANITIZE_STRING) : "";
  $limits_cpu = (isset($_GET['limits_cpu'])) ? filter_var(urldecode($_GET['limits_cpu']), FILTER_SANITIZE_STRING) : "";
  $limits_disk_priority = (isset($_GET['limits_disk_priority'])) ? filter_var(urldecode($_GET['limits_disk_priority']), FILTER_SANITIZE_STRING) : "";
  $limits_memory = (isset($_GET['limits_memory'])) ? filter_var(urldecode($_GET['limits_memory']), FILTER_SANITIZE_STRING) : "";
  $limits_memory_hugepages = (isset($_GET['limits_memory_hugepages'])) ? filter_var(urldecode($_GET['limits_memory_hugepages']), FILTER_SANITIZE_STRING) : "";
  $limits_network_priority = (isset($_GET['limits_network_priority'])) ? filter_var(urldecode($_GET['limits_network_priority']), FILTER_SANITIZE_STRING) : "";
  $migration_stateful = (isset($_GET['migration_stateful'])) ? filter_var(urldecode($_GET['migration_stateful']), FILTER_SANITIZE_STRING) : "";
  $raw_apparmor = (isset($_GET['raw_apparmor'])) ? filter_var(urldecode($_GET['raw_apparmor']), FILTER_SANITIZE_STRING) : "";
  $raw_qemu = (isset($_GET['raw_qemu'])) ? filter_var(urldecode($_GET['raw_qemu']), FILTER_SANITIZE_STRING) : "";
  $security_devlxd = (isset($_GET['security_devlxd'])) ? filter_var(urldecode($_GET['security_devlxd']), FILTER_SANITIZE_STRING) : "";
  $security_protection_delete = (isset($_GET['security_protection_delete'])) ? filter_var(urldecode($_GET['security_protection_delete']), FILTER_SANITIZE_STRING) : "";
  $security_secureboot = (isset($_GET['security_secureboot'])) ? filter_var(urldecode($_GET['security_secureboot']), FILTER_SANITIZE_STRING) : "";
  $snapshots_schedule = (isset($_GET['snapshots_schedule'])) ? filter_var(urldecode($_GET['snapshots_schedule']), FILTER_SANITIZE_STRING) : "";
  $snapshots_schedule_stopped = (isset($_GET['snapshots_schedule_stopped'])) ? filter_var(urldecode($_GET['snapshots_schedule_stopped']), FILTER_SANITIZE_STRING) : "";
  $snapshots_pattern = (isset($_GET['snapshots_pattern'])) ? filter_var(urldecode($_GET['snapshots_pattern']), FILTER_SANITIZE_STRING) : "";
  $snapshots_expiry = (isset($_GET['snapshots_expiry'])) ? filter_var(urldecode($_GET['snapshots_expiry']), FILTER_SANITIZE_STRING) : "";

  
  //Declare and instantiate POST variables
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

    case "attachInstanceProfile":
      $url = $base_url . "/1.0/instances/" . $instance . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $data = json_decode($results, true);
      $description = $data['metadata']['description'];
      $data = $data['metadata']['profiles'];
      array_push($data, $name);
      $data = '{"description":"'.$description.'", "profiles":' . json_encode($data) . '}';
      $results = sendCurlRequest($action, "PATCH", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance . " - " . $profile;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "copyInstance":
      //Copying on clustered hosts requires target location. Determine location of instance being copied.
      $url = $base_url . "/1.0/instances/" . $instance . "?project=" . $project;
      $instance_api_data = sendCurlRequest($action, "GET", $url);       
      $instance_api_data = json_decode($instance_api_data, true);
      $instance_data = $instance_api_data['metadata'];
      $location = $instance_data['location']; //Returns "none" for instances on non-clusted hosts
        
      //Set url with location variable
      $url = $base_url . "/1.0/instances?target=" . $location . "&project=" . $project;
        
      //If creating a instance from snapshot, add snapshot to instance name and use instance_only for copy
      if(!empty($snapshot)){
        $instance = $instance . "/" . $snapshot;
        $data = '{"name": "'. $name . '", "source":{"type": "copy", "instance_only": true, "source": "' . $instance . '", "project": "' . $project . '"}}';
      } 
      else {
        $data = '{"name": "'. $name . '", "source":{"type": "copy", "source": "' . $instance . '", "project": "' . $project . '"}}';
      }

      $results = sendCurlRequest($action, "POST", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance . " - " . $name;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "createInstanceBackup":
      //Determine file extension for backup file
      switch ($compression_algorithm) {
        case "bzip2":
          $file_extension = ".tar.bz2";
          break;
        case "gzip":
          $file_extension = ".tar.gz";
          break;
        case "lzma":
          $file_extension = ".tar.lzma";
          break;
        case "xz":
          $file_extension = ".tar.xz";
          break;
        case "zstd":
          $file_extension = ".tar.zst";
          break;
        default:
          $file_extension = ".tar";
      }
      $url = $base_url . "/1.0/instances/" . $instance . "/backups?project=" . $project;
      $data = '{"name": "'. $name . $file_extension . '", "instance_only": '.$instance_only.', "optimized_storage": '.$optimized_storage.', "compression_algorithm": "'.$compression_algorithm.'"}';
      $results = sendCurlRequest($action, "POST", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance . " - " . $name . $file_extension;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "createInstanceFromSnapshot":
      //Copying on clustered hosts requires target location. Determine location of instance being copied.
      $url = $base_url . "/1.0/instances/" . $instance . "?project=" . $project;
      $instance_api_data = sendCurlRequest($action, "GET", $url);       
      $instance_api_data = json_decode($instance_api_data, true);
      $instance_data = $instance_api_data['metadata'];
      $location = $instance_data['location']; //Returns "none" for instances on non-clusted hosts
        
      //Set url with location variable
      $url = $base_url . "/1.0/instances?target=" . $location . "&project=" . $project;
        
      //If creating a instance from snapshot, add snapshot to instance name and use instance_only for copy
      if(!empty($snapshot)){
        $instance = $instance . "/" . $snapshot;
        $data = '{"name": "'. $name . '", "source":{"type": "copy", "instance_only": true, "source": "' . $instance . '", "project": "' . $project . '"}}';
      } 
      else {
        $data = '{"name": "'. $name . '", "source":{"type": "copy", "source": "' . $instance . '", "project": "' . $project . '"}}';
      }

      $results = sendCurlRequest($action, "POST", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance . " - " . $name;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "createInstanceUsingForm":
      //If location == none let LXD determine where the instance is created        
      if ($location == "none"){
        $url = $base_url . "/1.0/instances?project=" . $project; 
      }
      else {
        $url = $base_url . "/1.0/instances?target=" . $location . "&project=" . $project;
      }

      $instance_array = array();

      $instance_array['name'] = $name;
      $instance_array['description'] = $description;
      $instance_array['profiles'] = array();
      array_push($instance_array['profiles'], $profile);
      $instance_array['type'] = "virtual-machine";
      $instance_array['instance_type'] = $instance_type;

      if ($fingerprint == "none"){
        $instance_array['source']['type'] = "none";
      }
      else {
        $instance_array['source']['type'] = "image";
        $instance_array['source']['fingerprint'] = $fingerprint;
      }

      $instance_array['config'] = new ArrayObject();

      if (!empty($boot_autostart)){ $instance_array['config']['boot.autostart'] = $boot_autostart;}
      if (!empty($boot_autostart_delay)){ $instance_array['config']['boot.autostart.delay'] = $boot_autostart_delay;}
      if (!empty($boot_autostart_priority)){ $instance_array['config']['boot.autostart.priority'] = $boot_autostart_priority;}
      if (!empty($boot_host_shutdown_timeout)){ $instance_array['config']['boot.host_shutdown_timeout'] = $boot_host_shutdown_timeout;}
      if (!empty($boot_stop_priority)){ $instance_array['config']['boot.stop.priority'] = $boot_stop_priority;}
      if (!empty($cluster_evacuate)){ $instance_array['config']['cluster.evacuate'] = $cluster_evacuate;}
      if (!empty($limits_cpu)){ $instance_array['config']['limits.cpu'] = $limits_cpu;}
      if (!empty($limits_disk_priority)){ $instance_array['config']['limits.disk.priority'] = $limits_disk_priority;}
      if (!empty($limits_memory)){ $instance_array['config']['limits.memory'] = $limits_memory;}
      if (!empty($limits_memory_hugepages)){ $instance_array['config']['limits.memory.hugepages'] = $limits_memory_hugepages;}
      if (!empty($limits_network_priority)){ $instance_array['config']['limits.network.priority'] = $limits_network_priority;}
      if (!empty($migration_stateful)){ $instance_array['config']['migration.stateful'] = $migration_stateful;}
      if (!empty($raw_apparmor)){ $instance_array['config']['raw.apparmor'] = $raw_apparmor;}
      if (!empty($raw_qemu)){ $instance_array['config']['raw.qemu'] = $raw_qemu;}
      if (!empty($security_devlxd)){ $instance_array['config']['security.devlxd'] = $security_devlxd;}
      if (!empty($security_protection_delete)){ $instance_array['config']['security.protection.delete'] = $security_protection_delete;}
      if (!empty($security_secureboot)){ $instance_array['config']['security.secureboot'] = $security_secureboot;}
      if (!empty($snapshots_schedule)){ $instance_array['config']['snapshots.schedule'] = $snapshots_schedule;}
      if (!empty($snapshots_schedule_stopped)){ $instance_array['config']['snapshots.schedule.stopped'] = $snapshots_schedule_stopped;}
      if (!empty($snapshots_pattern)){ $instance_array['config']['snapshots.pattern'] = $snapshots_pattern;}
      if (!empty($snapshots_expiry)){ $instance_array['config']['snapshots.expiry'] = $snapshots_expiry;}

      $data = json_encode($instance_array);
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

    case "createInstanceUsingJSON":
      $url = $base_url . "/1.0/instances?project=" . $project;
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

    case "deleteInstance":  
      $url = $base_url . "/1.0/instances/" . $instance . "?project=" . $project;
      $results = sendCurlRequest($action, "DELETE", $url);
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

    case "deleteInstanceBackup":
      $hostname = retrieveHostName($remote); 
      $file = '/var/lxdware/backups/' . $hostname . '/' . $project . '/' . $instance . '/' . $name;
      unlink($file);
      $url = $base_url . "/1.0/instances/" . $instance . "/backups/" . $name . "?project=" . $project;
      $results = sendCurlRequest($action, "DELETE", $url);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance . " - " . $name;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "deleteInstanceLog":
      $url = $base_url . $path . "?project=" . $project;
      $results = sendCurlRequest($action, "DELETE", $url);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $path;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "deleteInstanceSnapshot":
      $url = $base_url . "/1.0/instances/" . $instance . "/snapshots/" . $name . "?project=" . $project;
      $results = sendCurlRequest($action, "DELETE", $url);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance . " - " . $name;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "detachInstanceProfile":
      $url = $base_url . "/1.0/instances/" . $instance . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $data = json_decode($results, true);
      $description = $data['metadata']['description'];
      $data = $data['metadata']['profiles'];
      $i = 0;
      foreach ($data as $element){
        if ($element == $name){
          unset($data[$i]);
        }
        $i++;
      }
      $data = '{"description":"'.$description.'", "profiles":' . json_encode($data) . '}';
      $results = sendCurlRequest($action, "PATCH", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance . " - " . $name;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "downloadInstanceExportFile": 
      $hostname = retrieveHostName($remote);   
      $file = '/var/lxdware/backups/' . $hostname . '/' . $project . '/' . $instance . '/' . $name;
      $file_name = basename($file);
      $file_size = filesize($file);

      if (validateAuthorization($action)) {  
        if (file_exists($file)) {
          header('Content-Description: File Transfer');
          header('Content-Type: application/octet-stream');
          header('Content-Disposition: attachment; filename="'.$file_name.'"');
          header('Expires: 0');
          header('Cache-Control: must-revalidate');
          header('Pragma: public');
          header('Content-Length: ' . $file_size);
          readfile($file);
          exit;
        }
      }
      else {
        $results = '{"status": "Forbidden", "status_code": 403, "metadata": {"err": "You are not authorized to execute this action", "status_code": "403"}}';
      }
      echo $results;

      //Send event to accounting
      if ($results){
        $event = json_decode($results, true);
        $object = $file_name;
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        $object = $file_name;
        logEvent($action, $remote, $project, $object, '200', 'Success');
      }
      break;

    case "exportInstanceBackup":
      if (validateAuthorization($action)) {
        $cert = "/var/lxdware/data/lxd/client.crt";
        $key = "/var/lxdware/data/lxd/client.key";
        $hostname = retrieveHostName($remote); 
        $file = '/var/lxdware/backups/' . $hostname . '/' . $project . '/' . $instance . '/' . $name;
        if (!file_exists($file)){
          //If there is no directory yet for the host to store backups, create it
          if (!file_exists('/var/lxdware/backups/' . $hostname . '/' . $project . '/' . $instance)){
            mkdir('/var/lxdware/backups/'.$hostname . '/' . $project . '/' . $instance, 0777, true);
          }
          
          $url = $base_url . "/1.0/instances/" . $instance . "/backups/" . $name . "/export?project=" . $project;

          //Calling a script to execute the export. This will run in a seperate process so that it doesn't block other PHP requests from completing
          $results = exec("php ./scripts/curl-export-file.php $file $url $cert $key > /dev/null &");

          if ($results == false){
            $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"err": "Unable to execute action on remote host", "status_code": "400"}}';
          }
          else {
            $results = '{"status": "Ok", "status_code": 200, "metadata": "{}"}';
          }
          
        }
      }
      else {
        $results = '{"status": "Forbidden", "status_code": 403, "metadata": {"err": "You are not authorized to execute this action", "status_code": "403"}}';
      }
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance . " - " . $name;
      logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      break;

    case "freezeInstance":
      $url = $base_url . "/1.0/instances/" . $instance . "/state?project=" . $project;
      $data = '{"action": "freeze"}';
      $results = sendCurlRequest($action, "PUT", $url, $data);
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

    case "listInstances":
      if (validateAuthorization($action)) {
        $url = $base_url . "/1.0/virtual-machines?recursion=2&project=" . $project;
        $results = sendCurlRequest($action, "GET", $url);
        $results = json_decode($results, true);
        $instance_api_data = (isset($results['metadata'])) ? $results['metadata'] : [];

        $i = 0;
        echo '{ "data": [';

        if ($results['status_code'] == "200"){

          foreach ($instance_api_data as $instance_data){

            if ($instance_data['name'] == "")
              continue;

            if ($i > 0){
              echo ",";
            }
            $i++;

            echo "[ ";
            if ($instance_data['status'] == "Running"){
              echo '"';
              echo "<a href='virtual-machines-single.php?instance=".$instance_data['name']."&remote=".$remote."&project=".$project."'><i class='fas fa-cube fa-lg' style='color:#4e73df'></i> </a>";
              echo '",';

              echo '"';
              echo "<a href='virtual-machines-single.php?instance=".$instance_data['name']."&remote=".$remote."&project=".$project."'> ".htmlentities($instance_data['name'])."</a>";
              echo '",';
            }
            else {
              echo '"';
              echo "<a href='virtual-machines-single.php?instance=".$instance_data['name']."&remote=".$remote."&project=".$project."'><i class='fas fa-cube fa-lg' style='color:#ddd'></i> </a>";
              echo '",';

              echo '"';
              echo "<a href='virtual-machines-single.php?instance=".$instance_data['name']."&remote=".$remote."&project=".$project."'> ".htmlentities($instance_data['name'])."</a>";
              echo '",';
            }
          
            echo '"';
            if (isset($instance_data['config']['image.os']))
              echo htmlentities($instance_data['config']['image.os']);
            else 
              echo "";
            echo '",';

            echo '"' . htmlentities($instance_data['location']) . '",';

            //IPv4
            echo '"';
            if (isset($instance_data['state']['network'])){
              foreach ($instance_data['state']['network'] as $nic => $nic_properties){
                foreach ($nic_properties['addresses'] as $nic_address){
                  if ($nic_address['family'] == "inet" && $nic_address['scope'] == "global"){
                    echo htmlentities($nic_address['address']) . " (" . htmlentities($nic) . ")<br />";
                  }
                }
              }
            }
            echo '",';

            //IPv6
            echo '"';
            if (isset($instance_data['state']['network'])){
              foreach ($instance_data['state']['network'] as $nic => $nic_properties){
                foreach ($nic_properties['addresses'] as $nic_address){
                  if ($nic_address['family'] == "inet6" && $nic_address['scope'] == "global"){
                    echo htmlentities($nic_address['address']) . " (" . htmlentities($nic) . ")<br />";
                  }
                }
              }
            }
            echo '",';

            //Convert the memory usage to an appropriate unit
            if ($instance_data['state']['memory']['usage'] < 1073741824){
              $memory = number_format($instance_data['state']['memory']['usage']/1024/1024, 2);
              $memory_unit = "MiB";
            }
            else {
              $memory = number_format($instance_data['state']['memory']['usage']/1024/1024/1024, 2);
              $memory_unit = "GiB";
            }

            echo '"' . htmlentities($memory) . " " . $memory_unit . '",';

            //When first created, the root disk usage is not set for brief second causing a PHP Notice in error log for Undefined index: root
            if (isset($instance_data['state']['disk']['root']['usage'])){
              //Convert the storage usage to an approprate unit
              if ($instance_data['state']['disk']['root']['usage']  < 1073741824){
                $disk_total = number_format($instance_data['state']['disk']['root']['usage']/1024/1024,2);
                $disk_unit = "MiB";
              }
              if ($instance_data['state']['disk']['root']['usage']  >= 1073741824 && $instance_data['state']['disk']['root']['usage'] < 1099511627776) {
                $disk_total = number_format($instance_data['state']['disk']['root']['usage']/1024/1024/1024,2);
                $disk_unit = "GiB";
              }
              if ($instance_data['state']['disk']['root']['usage'] >= 1099511627776){
                $disk_total = number_format($instance_data['state']['disk']['root']['usage']/1024/1024/1024/1024,2);
                $disk_unit = "TiB";
              }
            }
            else {
              $disk_total = "N/A";
              $disk_unit = "";
            }

            echo '"' . htmlentities($disk_total) . " " . $disk_unit . '",';
            echo '"' . htmlentities($instance_data['status']) . '",';

            switch ($instance_data['status']) {
              case "Running":
                echo '"';
                echo "<a href='#' onclick=stopInstance('".$instance_data['name']."')> <i class='fas fa-stop fa-lg' style='color:#cdcdcd' title='Stop' aria-hidden='true'></i> </a>";
                echo " &nbsp ";
                echo "<a href='#'><i class='fas fa-trash-alt fa-lg' style='color:#ededed' title='Delete (disabled)' aria-hidden='true'></i></a>";
                echo '"';
                break;
              case "Frozen":
                echo '"';
                echo "<a href='#' onclick=unfreezeInstance('".$instance_data['name']."')> <i class='fas fa-pause fa-lg' style='color:#cdcdcd' title='Unfreeze' aria-hidden='true'></i> </a>";
                echo " &nbsp ";
                echo "<a href='#'><i class='fas fa-trash-alt fa-lg' style='color:#ededed' title='Delete (disabled)' aria-hidden='true'></i></a>";
                echo '"';
                break;
              case "Stopped":
                echo '"';
                echo "<a href='#' onclick=startInstance('".$instance_data['name']."')> <i class='fas fa-play fa-lg' style='color:#cdcdcd' title='Start' aria-hidden='true'></i> </a>";
                echo " &nbsp ";
                echo "<a href='#' onclick=confirmDeleteInstance('".$instance_data['name']."')><i class='fas fa-trash-alt fa-lg' style='color:#cdcdcd' title='Delete' aria-hidden='true'></i></a>";
                echo '"';
                break;
              default:
                echo '" "';
            }
            
            echo " ]";

          }
        
        }

        echo " ]}";
      }
      else {
        echo '{ "data": [] }';
      }      
      break;

    case "listInstancesForSelectOption":
      $url = $base_url . "/1.0/virtual-machines?recursion=1&project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $instance_api_data = (isset($results['metadata'])) ? $results['metadata'] : [];

      foreach ($instance_api_data as $instance_data){
        
        if ($instance_data['name'] == "")
        continue;

        echo '<option value="' . $instance_data['name'] . '">' . htmlentities($instance_data['name']) . '</option>';

      }
      break;

    case "loadInstanceInformation":
      $url = $base_url . "/1.0/instances/" . $instance . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      echo $results;
      break;

    case "loadInstanceLog":
      $url = $base_url . $path . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      echo $results;
      break;

    case "migrateInstance":
      $url = $base_url . "/1.0/instances/" . $instance . "?target=" . $location . "&project=" . $project;
      $data = '{"name": "'. $instance . '", "migration": true, "live": false}';
      $results = sendCurlRequest($action, "POST", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance . " - " . $location;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "publishInstance":
      $url = $base_url . "/1.0/images?project=" . $project;
      $data = '{"properties":{"description": "'. $description . '", "os": "' . $os . '", "release": "' . $release . '"}, "public": '. $public . ', "source":{"type": "instance", "name": "'. $instance . '"}}';
      $results = sendCurlRequest($action, "POST", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance . " - " . $release;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;
      
    case "publishInstanceSnapshot":
      $url = $base_url . "/1.0/images?project=" . $project;
      $data = '{"properties":{"description": "'. $description . '", "os": "' . $os . '", "release": "' . $release . '"}, "public": '. $public . ', "source":{"type": "snapshot", "name": "'. $instance . '"}}';
      $results = sendCurlRequest($action, "POST", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance . " - " . $os . " " . $release;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "renameInstance":
      $url = $base_url . "/1.0/instances/" . $instance . "?project=" . $project;
      $data = '{"name": "' . $name . '"}';
      $results = sendCurlRequest($action, "POST", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance . " - " . $name;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "restartInstance":
      $url = $base_url . "/1.0/instances/" . $instance . "/state?project=" . $project;
      $data = '{"action": "restart"}';
      $results = sendCurlRequest($action, "PUT", $url, $data);
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

    case "restoreInstanceSnapshot":
      $url = $base_url . "/1.0/instances/" . $instance . "?project=" . $project;
      $data = '{"restore":"' . $name . '"}';
      $results = sendCurlRequest($action, "PUT", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance . " - " . $name;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "snapshotInstance":
      $url = $base_url . "/1.0/instances/" . $instance . "/snapshots?project=" . $project;
      if ($stateful != "true"){
        $stateful = "false";
      }
      $data = '{"name": "' . $name . '", "stateful": ' . $stateful . '}';
      $results = sendCurlRequest($action, "POST", $url, $data);
      echo $results;


      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance . " - " . $name;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "startInstance":
      $url = $base_url . "/1.0/instances/" . $instance . "/state?project=" . $project;
      $data = '{"action": "start"}';
      $results = sendCurlRequest($action, "PUT", $url, $data);
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

    case "stopInstance":
      $url = $base_url . "/1.0/instances/" . $instance . "/state?project=" . $project;
      $data = '{"action": "stop"}';
      $results = sendCurlRequest($action, "PUT", $url, $data);
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

    case "stopInstanceForcefully":
      $url = $base_url . "/1.0/instances/" . $instance . "/state?project=" . $project;
      $data = '{"action": "stop","force":true}';
      $results = sendCurlRequest($action, "PUT", $url, $data);
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

    case "unfreezeInstance":
      $url = $base_url . "/1.0/instances/" . $instance . "/state?project=" . $project;
      $data = '{"action": "unfreeze"}';
      $results = sendCurlRequest($action, "PUT", $url, $data);
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

    case "updateInstanceInformation":
      $url = $base_url . "/1.0/instances/" . $instance . "?project=" . $project;
      $data = $json;
      $results = sendCurlRequest($action, "PUT", $url, $data);
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

    case "updateInstanceUsingForm":

      $url = $base_url . "/1.0/instances/" . $instance . "?project=" . $project;
    
      //Retrieve existing instance config settings
      $results = sendCurlRequest($action, "GET", $url);
      $existing_array = json_decode($results, true);
      $existing_array = $existing_array['metadata'];

      //Create array of new config settings
      $instance_array = array();
      $instance_array['description'] = $description;
      $instance_array['config'] = new ArrayObject();

      $instance_array['config']['boot.autostart'] = $boot_autostart;
      $instance_array['config']['boot.autostart.delay'] = $boot_autostart_delay;
      $instance_array['config']['boot.autostart.priority'] = $boot_autostart_priority;
      $instance_array['config']['boot.host_shutdown_timeout'] = $boot_host_shutdown_timeout;
      $instance_array['config']['boot.stop.priority'] = $boot_stop_priority;
      $instance_array['config']['cluster.evacuate'] = $cluster_evacuate;
      $instance_array['config']['limits.cpu'] = $limits_cpu;
      $instance_array['config']['limits.disk.priority'] = $limits_disk_priority;
      $instance_array['config']['limits.memory'] = $limits_memory;
      $instance_array['config']['limits.memory.hugepages'] = $limits_memory_hugepages;
      $instance_array['config']['limits.network.priority'] = $limits_network_priority;
      $instance_array['config']['migration.stateful'] = $migration_stateful;
      $instance_array['config']['raw.apparmor'] = $raw_apparmor;
      $instance_array['config']['raw.qemu'] = $raw_qemu;
      $instance_array['config']['security.devlxd'] = $security_devlxd;
      $instance_array['config']['security.protection.delete'] = $security_protection_delete;
      $instance_array['config']['security.secureboot'] = $security_secureboot;
      $instance_array['config']['snapshots.schedule'] = $snapshots_schedule;
      $instance_array['config']['snapshots.schedule.stopped'] = $snapshots_schedule_stopped;
      $instance_array['config']['snapshots.pattern'] = $snapshots_pattern;
      $instance_array['config']['snapshots.expiry'] = $snapshots_expiry;

      //Create new array based on changes between existing and new configs
      $new_array = array();
      $new_array['description'] = $description;
      $new_array['config'] = new ArrayObject();

      foreach ($instance_array['config'] as $key => $val) {
        if (!isset($existing_array['config'][$key])){
          $existing_array['config'][$key] = "";
        }
        if ($instance_array['config'][$key] != $existing_array['config'][$key]){
          $new_array['config'][$key] = $instance_array['config'][$key];
        }
      }

      $data = json_encode($new_array);
      $results = sendCurlRequest($action, "PATCH", $url, $data);

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

    default:
      $results = '{"status": "Bad Request", "status_code": 400, "metadata": {"err": "Unable to execute action on remote host", "status_code": "400"}}';
      echo $results;

    }

}
else {
  echo '{"error": "Unauthorized", "error_code": "401", "metadata": {"err": "You are not authenticated", "status_code": "401"}}';
}

?>


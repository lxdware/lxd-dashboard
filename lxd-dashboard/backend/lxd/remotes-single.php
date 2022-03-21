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
  $project = (isset($_GET['project'])) ? filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING) : "";
  $remote = (isset($_GET['remote'])) ? filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_NUMBER_INT) : "";

  //Require code from lxd-dashboard/backend/config/curl.php
  require_once('../config/curl.php');

  //Require code from lxd-dashboard/backend/config/db.php
  require_once('../config/db.php');

  //Query database for remote host record
  $base_url = retrieveHostURL($remote);

  //Run the matching action
  switch ($action) {

    case "displayClusterInfo":
      $arr = array();

      //Cluster Member Stats
      //First determine if part of a cluster
      $url = $base_url . "/1.0/cluster";
      $cluster_api_data = sendCurlRequest($action, "GET", $url);
      $cluster_api_data = json_decode($cluster_api_data, true);
      $cluster_data = (isset($cluster_api_data['metadata'])) ? $cluster_api_data['metadata'] : [];

      $cluster_status = (isset($cluster_data['enabled'])) ? $cluster_data['enabled'] : false;

      if ($cluster_status == false){
        //Host is not part of a cluster
        $online_members = 0;
        $total_members = 0;
      }
      else {
        //Retrieve cluster member status
        $url = $base_url . "/1.0/cluster/members?recursion=1";
        $cluster_api_data = sendCurlRequest($action, "GET", $url);
        $cluster_api_data = json_decode($cluster_api_data, true);
        $cluster_members = (isset($cluster_api_data['metadata'])) ? $cluster_api_data['metadata'] : [];

        $online_members = 0;
        $total_members = 0;

        foreach ($cluster_members as $cluster_member){
          if ($cluster_member['status'] == "Online"){
            $online_members++;
          }
          $total_members++;
        }
      }

      $arr['onlineClusterMembers'] = $online_members;
      $arr['totalClusterMembers'] = $total_members;

      echo json_encode($arr);
      break;

    case "displayContainerInfo":
      $arr = array();

      //Instance Stats
      $url = $base_url. "/1.0/containers?recursion=2&project=" . $project;
      $instance_api_data = sendCurlRequest($action, "GET", $url);
      $instance_api_data = json_decode($instance_api_data, true);
      $instances = (isset($instance_api_data['metadata'])) ? $instance_api_data['metadata'] : [];

      $running_instances = 0;
      $total_instances = 0;

      foreach ($instances as $instance){
        if ($instance['state']['status'] == "Running"){
          $running_instances++;
        }
        $total_instances++;
      }

      $arr['runningContainers'] = $running_instances;
      $arr['totalContainers'] = $total_instances;

      echo json_encode($arr);
      break;

    case "displayImageInfo":
      $arr = array();

      //Image Stats
      $url = $base_url . "/1.0/images?project=" . $project;
      $image_api_data = sendCurlRequest($action, "GET", $url);
      $image_api_data = json_decode($image_api_data, true);
      $image_urls = (isset($image_api_data['metadata'])) ? $image_api_data['metadata'] : [];

      $arr['totalImages'] = count($image_urls);

      echo json_encode($arr);
      break;

    case "displayInstanceInfo":
      $arr = array();

      //Instance Stats
      $url = $base_url. "/1.0/instances?recursion=2&project=" . $project;
      $instance_api_data = sendCurlRequest($action, "GET", $url);
      $instance_api_data = json_decode($instance_api_data, true);
      $instances = (isset($instance_api_data['metadata'])) ? $instance_api_data['metadata'] : [];

      $running_instances = 0;
      $total_instances = 0;

      foreach ($instances as $instance){
        if ($instance['state']['status'] == "Running"){
          $running_instances++;
        }
        $total_instances++;
      }

      $arr['runningInstances'] = $running_instances;
      $arr['totalInstances'] = $total_instances;

      echo json_encode($arr);
      break;

    case "displayLxdInfo":
      $arr = array();
      $url = $base_url . "/1.0?project=" . $project;
      $api_data = sendCurlRequest($action, "GET", $url);
      $api_data = json_decode($api_data, true);
      $data = (isset($api_data['metadata'])) ? $api_data['metadata'] : "";

      $arr['addresses'] = (isset($data['environment']['addresses'])) ? $data['environment']['addresses'] : []; //array of ip addresses
      $arr['driver'] = (isset($data['environment']['driver'])) ? $data['environment']['driver'] : "Unknown"; //example: qemu | lxc
      $arr['driverVersion'] = (isset($data['environment']['driver_version'])) ? $data['environment']['driver_version'] : "Unknown"; //example: 5.2.0 | 4.0.5
      $arr['firewall'] = (isset($data['environment']['firewall'])) ? $data['environment']['firewall'] : "Unknown"; //example: xtables
      $arr['kernel'] = (isset($data['environment']['kernel'])) ? $data['environment']['kernel'] : "Unknown"; //example: Linux
      $arr['kernelArchitecture'] = (isset($data['environment']['kernel_architecture'])) ? $data['environment']['kernel_architecture'] : "Unknown"; //example: x86_64
      $arr['kernelVersion'] = (isset($data['environment']['kernel_version'])) ? $data['environment']['kernel_version'] : "Unknown"; //example: 5.8.0-36-generic
      $arr['osName'] = (isset($data['environment']['os_name'])) ? $data['environment']['os_name'] : "Unknown"; //example: Ubuntu
      $arr['osVersion'] = (isset($data['environment']['os_version'])) ? $data['environment']['os_version'] : "Unknown"; //example: 20.04
      $arr['server'] = (isset($data['environment']['server'])) ? $data['environment']['server'] : "Unknown"; //example: lxd
      $arr['serverVersion'] = (isset($data['environment']['server_version'])) ? $data['environment']['server_version'] : "Unknown"; //example: 4.10
      $arr['serverClustered'] = (isset($data['environment']['server_clustered'])) ? $data['environment']['server_clustered'] : "Unknown"; //example: true
      $arr['serverName'] = (isset($data['environment']['server_name'])) ? $data['environment']['server_name'] : "Unknown"; //hostname
      $arr['storage'] = (isset($data['environment']['storage'])) ? $data['environment']['storage'] : "Unknown"; //example: zfs
      $arr['storageVersion'] = (isset($data['environment']['storage_version'])) ? $data['environment']['storage_version'] : "Unknown"; //example: 0.8.4-1ubuntu11

      echo json_encode($arr);
      break;

    case "displayNetworkInfo":
      $arr = array();

      //Network Stats
      $url = $base_url . "/1.0/networks?project=" . $project;
      $network_api_data = sendCurlRequest($action, "GET", $url);
      $network_api_data = json_decode($network_api_data, true);
      $network_urls = (isset($network_api_data['metadata'])) ? $network_api_data['metadata'] : [];

      $arr['totalNetworks'] = count($network_urls);

      echo json_encode($arr);
      break;

    case "displayNetworkAclInfo":
      $arr = array();

      //Network ACL Stats
      $url = $base_url . "/1.0/network-acls?project=" . $project;
      $network_acl_api_data = sendCurlRequest($action, "GET", $url);
      $network_acl_api_data = json_decode($network_acl_api_data, true);
      $network_acl_urls = (isset($network_acl_api_data['metadata'])) ? $network_acl_api_data['metadata'] : [];

      $arr['totalNetworkAcls'] = count($network_acl_urls);

      echo json_encode($arr);
      break;

    case "displayProfileInfo":
      $arr = array();

      //Profile Stats
      $url = $base_url . "/1.0/profiles?project=" . $project;
      $profile_api_data = sendCurlRequest($action, "GET", $url);
      $profile_api_data = json_decode($profile_api_data, true);
      $profile_urls = (isset($profile_api_data['metadata'])) ? $profile_api_data['metadata'] : [];

      $arr['totalProfiles'] = count($profile_urls);

      echo json_encode($arr);
      break;

    case "displayProjectInfo":
      $arr = array();

      //Project Stats
      $url = $base_url . "/1.0/projects?project=" . $project;
      $project_api_data = sendCurlRequest($action, "GET", $url);
      $project_api_data = json_decode($project_api_data, true);
      $project_urls = (isset($project_api_data['metadata'])) ? $project_api_data['metadata'] : [];

      $arr['totalProjects'] = count($project_urls);

      echo json_encode($arr);
      break;

    case "displayStorageInfo":
      $arr = array();

      //Storage Pool Stats
      $url = $base_url . "/1.0/storage-pools?project=" . $project;
      $storage_pool_api_data = sendCurlRequest($action, "GET", $url);
      $storage_pool_api_data = json_decode($storage_pool_api_data, true);
      $storage_pool_urls = (isset($storage_pool_api_data['metadata'])) ? $storage_pool_api_data['metadata'] : [];

      $arr['totalStoragePools'] = count($storage_pool_urls);

      echo json_encode($arr);
      break;

    case "displaySysInfo":
      $arr = array();

      //Resource Stats
      $url = $base_url . "/1.0/resources?project=" . $project;
      $resource_api_data = sendCurlRequest($action, "GET", $url);
      $resource_api_data = json_decode($resource_api_data, true); 
      $resource_data = (isset($resource_api_data['metadata'])) ? $resource_api_data['metadata'] : "";

      $arr['systemVendor'] = (isset($resource_data['system']['vendor'])) ? $resource_data['system']['vendor'] : "Unknown"; //example: DigitalOcean, Dell, Etc
      $arr['systemProduct'] = (isset($resource_data['system']['product'])) ? $resource_data['system']['product'] : "Unknown"; //example: Droplet, R810, Etc
      $arr['architecture'] = (isset($resource_data['cpu']['architecture'])) ? $resource_data['cpu']['architecture'] : "Unknown"; //example: x86_64
      $arr['cpus'] = (isset($resource_data['cpu']['total'])) ? $resource_data['cpu']['total'] : "Unknown"; //example: 8
      $arr['sockets'] = (isset($resource_data['cpu']['sockets'])) ? $resource_data['cpu']['sockets'] : []; //array of cpu info per socket
      $arr['storageDisks'] = (isset($resource_data['storage']['disks'])) ? $resource_data['storage']['disks'] : []; //array of storage devices
      $memory_total = (isset($resource_data['memory']['total'])) ? (float)$resource_data['memory']['total'] : 0; //memory in bytes
      $memory_used = (isset($resource_data['memory']['used'])) ? (float)$resource_data['memory']['used'] : 0; //memory in bytes
      if ($memory_total == 0)
        $arr['memoryPercentage'] = 0;
      else
        $arr['memoryPercentage'] = number_format($memory_used / $memory_total* 100, 2);

      //Format memory values
      if ($memory_total < 1073741824) {
        $memory_total = number_format($memory_total/1024/1024, 2); //total amount of memory available in MiB
        $memory_used = number_format($memory_used/1024/1024, 2); //current amount of memory used in MiB
        $memory_unit = "MiB";
      }
      else {
        $memory_total = number_format($memory_total/1024/1024/1024, 2); //total amount of memory available in GiB
        $memory_used = number_format($memory_used/1024/1024/1024, 2); //current amount of memory used in GiB
        $memory_unit = "GiB";
      }
      
      $arr['memoryTotal'] = $memory_total;
      $arr['memoryUnit'] = $memory_unit;

      echo json_encode($arr);
      break;

    case "displayVirtualMachineInfo":
      $arr = array();

      //Instance Stats
      $url = $base_url. "/1.0/virtual-machines?recursion=2&project=" . $project;
      $instance_api_data = sendCurlRequest($action, "GET", $url);
      $instance_api_data = json_decode($instance_api_data, true);
      $instances = (isset($instance_api_data['metadata'])) ? $instance_api_data['metadata'] : [];

      $running_instances = 0;
      $total_instances = 0;

      foreach ($instances as $instance){
        if ($instance['state']['status'] == "Running"){
          $running_instances++;
        }
        $total_instances++;
      }

      $arr['runningVirtualMachines'] = $running_instances;
      $arr['totalVirtualMachines'] = $total_instances;

      echo json_encode($arr);
      break;

    case "validateRemoteConnection":
      $url = $base_url. "/1.0";
      $results = sendCurlRequest($action, "GET", $url);
      echo $results;
      break;
      
  }

}
else {
  echo '{"error": "not authenticated", "error_code": "401", "metadata": {"err": "not authenticated", "status_code": "401"}}';
}
?>

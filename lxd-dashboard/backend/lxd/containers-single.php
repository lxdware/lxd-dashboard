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
  $bind = (isset($_GET['bind'])) ? filter_var(urldecode($_GET['bind']), FILTER_SANITIZE_STRING) : "";
  $boot_priority = (isset($_GET['boot_priority'])) ? filter_var(urldecode($_GET['boot_priority']), FILTER_SANITIZE_NUMBER_INT) : "";
  $ceph_cluster_name = (isset($_GET['ceph_cluster_name'])) ? filter_var(urldecode($_GET['ceph_cluster_name']), FILTER_SANITIZE_STRING) : "";
  $ceph_user_name = (isset($_GET['ceph_user_name'])) ? filter_var(urldecode($_GET['ceph_user_name']), FILTER_SANITIZE_STRING) : "";
  $connect = (isset($_GET['connect'])) ? filter_var(urldecode($_GET['connect']), FILTER_SANITIZE_STRING) : "";
  $gid = (isset($_GET['gid'])) ? filter_var(urldecode($_GET['gid']), FILTER_SANITIZE_NUMBER_INT) : "";
  $gvrp = (isset($_GET['gvrp'])) ? filter_var(urldecode($_GET['gvrp']), FILTER_SANITIZE_STRING) : "";
  $hwaddr = (isset($_GET['hwaddr'])) ? filter_var(urldecode($_GET['hwaddr']), FILTER_SANITIZE_STRING) : "";
  $id = (isset($_GET['id'])) ? filter_var(urldecode($_GET['id']), FILTER_SANITIZE_STRING) : "";
  $instance = (isset($_GET['instance'])) ? filter_var(urldecode($_GET['instance']), FILTER_SANITIZE_STRING) : "";
  $interface_name = (isset($_GET['interface_name'])) ? filter_var(urldecode($_GET['interface_name']), FILTER_SANITIZE_STRING) : "";
  $ipv4_address = (isset($_GET['ipv4_address'])) ? filter_var(urldecode($_GET['ipv4_address']), FILTER_SANITIZE_STRING) : "";
  $ipv4_gateway = (isset($_GET['ipv4_gateway'])) ? filter_var(urldecode($_GET['ipv4_gateway']), FILTER_SANITIZE_STRING) : "";
  $ipv4_host_address = (isset($_GET['ipv4_host_address'])) ? filter_var(urldecode($_GET['ipv4_host_address']), FILTER_SANITIZE_STRING) : "";
  $ipv4_host_table = (isset($_GET['ipv4_host_table'])) ? filter_var(urldecode($_GET['ipv4_host_table']), FILTER_SANITIZE_NUMBER_INT) : "";
  $ipv4_routes = (isset($_GET['ipv4_routes'])) ? filter_var(urldecode($_GET['ipv4_routes']), FILTER_SANITIZE_STRING) : "";
  $ipv4_routes_external = (isset($_GET['ipv4_routes_external'])) ? filter_var(urldecode($_GET['ipv4_routes_external']), FILTER_SANITIZE_STRING) : "";
  $ipv6_address = (isset($_GET['ipv6_address'])) ? filter_var(urldecode($_GET['ipv6_address']), FILTER_SANITIZE_STRING) : "";
  $ipv6_gateway = (isset($_GET['ipv6_gateway'])) ? filter_var(urldecode($_GET['ipv6_gateway']), FILTER_SANITIZE_STRING) : "";
  $ipv6_host_address = (isset($_GET['ipv6_host_address'])) ? filter_var(urldecode($_GET['ipv6_host_address']), FILTER_SANITIZE_STRING) : "";
  $ipv6_host_table = (isset($_GET['ipv6_host_table'])) ? filter_var(urldecode($_GET['ipv6_host_table']), FILTER_SANITIZE_NUMBER_INT) : "";
  $ipv6_routes = (isset($_GET['ipv6_routes'])) ? filter_var(urldecode($_GET['ipv6_routes']), FILTER_SANITIZE_STRING) : "";
  $ipv6_routes_external = (isset($_GET['ipv6_routes_external'])) ? filter_var(urldecode($_GET['ipv6_routes_external']), FILTER_SANITIZE_STRING) : "";
  $limits_ingress = (isset($_GET['limits_ingress'])) ? filter_var(urldecode($_GET['limits_ingress']), FILTER_SANITIZE_STRING) : "";
  $limits_egress = (isset($_GET['limits_egress'])) ? filter_var(urldecode($_GET['limits_egress']), FILTER_SANITIZE_STRING) : "";
  $limits_max = (isset($_GET['limits_max'])) ? filter_var(urldecode($_GET['limits_max']), FILTER_SANITIZE_STRING) : "";
  $limits_read = (isset($_GET['limits_read'])) ? filter_var(urldecode($_GET['limits_read']), FILTER_SANITIZE_STRING) : "";
  $limits_write = (isset($_GET['limits_write'])) ? filter_var(urldecode($_GET['limits_write']), FILTER_SANITIZE_STRING) : "";
  $listen = (isset($_GET['listen'])) ? filter_var(urldecode($_GET['listen']), FILTER_SANITIZE_STRING) : "";
  $maas_subnet_ipv4 = (isset($_GET['maas_subnet_ipv4'])) ? filter_var(urldecode($_GET['maas_subnet_ipv4']), FILTER_SANITIZE_STRING) : "";
  $maas_subnet_ipv6 = (isset($_GET['maas_subnet_ipv6'])) ? filter_var(urldecode($_GET['maas_subnet_ipv6']), FILTER_SANITIZE_STRING) : "";
  $major = (isset($_GET['major'])) ? filter_var(urldecode($_GET['major']), FILTER_SANITIZE_NUMBER_INT) : "";
  $migCi = (isset($_GET['mig_ci'])) ? filter_var(urldecode($_GET['mig_ci']), FILTER_SANITIZE_NUMBER_INT) : "";
  $migGi = (isset($_GET['mig_gi'])) ? filter_var(urldecode($_GET['mig_gi']), FILTER_SANITIZE_NUMBER_INT) : "";
  $minor = (isset($_GET['minor'])) ? filter_var(urldecode($_GET['minor']), FILTER_SANITIZE_NUMBER_INT) : "";
  $mode = (isset($_GET['mode'])) ? filter_var(urldecode($_GET['mode']), FILTER_SANITIZE_NUMBER_INT) : "";
  $mtu = (isset($_GET['mtu'])) ? filter_var(urldecode($_GET['mtu']), FILTER_SANITIZE_NUMBER_INT) : "";
  $name = (isset($_GET['name'])) ? filter_var(urldecode($_GET['name']), FILTER_SANITIZE_STRING) : "";
  $nat = (isset($_GET['nat'])) ? filter_var(urldecode($_GET['nat']), FILTER_SANITIZE_STRING) : "";
  $network = (isset($_GET['network'])) ? filter_var(urldecode($_GET['network']), FILTER_SANITIZE_STRING) : "";
  $nictype = (isset($_GET['nictype'])) ? filter_var(urldecode($_GET['nictype']), FILTER_SANITIZE_STRING) : "";
  $project = (isset($_GET['project'])) ? filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING) : "";
  $remote = (isset($_GET['remote'])) ? filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_NUMBER_INT) : "";
  $pci = (isset($_GET['pci'])) ? filter_var(urldecode($_GET['pci']), FILTER_SANITIZE_STRING) : "";
  $pool = (isset($_GET['pool'])) ? filter_var(urldecode($_GET['pool']), FILTER_SANITIZE_STRING) : "";
  $source = (isset($_GET['source'])) ? filter_var(urldecode($_GET['source']), FILTER_SANITIZE_STRING) : "";
  $parent = (isset($_GET['parent'])) ? filter_var(urldecode($_GET['parent']), FILTER_SANITIZE_STRING) : "";
  $parent_type = (isset($_GET['parent_type'])) ? filter_var(urldecode($_GET['parent_type']), FILTER_SANITIZE_STRING) : "";
  $path = (isset($_GET['path'])) ? filter_var(urldecode($_GET['path']), FILTER_SANITIZE_STRING) : "";
  $productid = (isset($_GET['productid'])) ? filter_var(urldecode($_GET['productid']), FILTER_SANITIZE_STRING) : "";
  $propagation = (isset($_GET['propagation'])) ? filter_var(urldecode($_GET['propagation']), FILTER_SANITIZE_STRING) : "";
  $property_set = (isset($_GET['property_set'])) ? filter_var(urldecode($_GET['property_set']), FILTER_SANITIZE_STRING) : "";
  $proxy_protocol = (isset($_GET['proxy_protocol'])) ? filter_var(urldecode($_GET['proxy_protocol']), FILTER_SANITIZE_STRING) : "";
  $required = (isset($_GET['required'])) ? filter_var(urldecode($_GET['required']), FILTER_SANITIZE_STRING) : "";
  $read_only = (isset($_GET['read_only'])) ? filter_var(urldecode($_GET['read_only']), FILTER_SANITIZE_STRING) : "";
  $size = (isset($_GET['size'])) ? filter_var(urldecode($_GET['size']), FILTER_SANITIZE_STRING) : "";
  $size_state = (isset($_GET['size_state'])) ? filter_var(urldecode($_GET['size_state']), FILTER_SANITIZE_STRING) : "";
  $source = (isset($_GET['source'])) ? filter_var(urldecode($_GET['source']), FILTER_SANITIZE_STRING) : "";
  $raw_mount_options = (isset($_GET['raw_mount_options'])) ? filter_var(urldecode($_GET['raw_mount_options']), FILTER_SANITIZE_STRING) : "";
  $recursive = (isset($_GET['recursive'])) ? filter_var(urldecode($_GET['recursive']), FILTER_SANITIZE_STRING) : "";
  $security_acls = (isset($_GET['security_acls'])) ? filter_var(urldecode($_GET['security_acls']), FILTER_SANITIZE_STRING) : "";
  $security_acls_default_egress_action = (isset($_GET['security_acls_default_egress_action'])) ? filter_var(urldecode($_GET['security_acls_default_egress_action']), FILTER_SANITIZE_STRING) : "";
  $security_acls_default_egress_logged = (isset($_GET['security_acls_default_egress_logged'])) ? filter_var(urldecode($_GET['security_acls_default_egress_logged']), FILTER_SANITIZE_STRING) : "";
  $security_acls_default_ingress_action = (isset($_GET['security_acls_default_ingress_action'])) ? filter_var(urldecode($_GET['security_acls_default_ingress_action']), FILTER_SANITIZE_STRING) : "";
  $security_acls_default_ingress_logged = (isset($_GET['security_acls_default_ingress_logged'])) ? filter_var(urldecode($_GET['security_acls_default_ingress_logged']), FILTER_SANITIZE_STRING) : "";
  $security_gid = (isset($_GET['security_gid'])) ? filter_var(urldecode($_GET['security_gid']), FILTER_SANITIZE_NUMBER_INT) : "";
  $security_ipv4_filtering = (isset($_GET['security_ipv4_filtering'])) ? filter_var(urldecode($_GET['security_ipv4_filtering']), FILTER_SANITIZE_STRING) : "";
  $security_ipv6_filtering = (isset($_GET['security_ipv6_filtering'])) ? filter_var(urldecode($_GET['security_ipv6_filtering']), FILTER_SANITIZE_STRING) : "";
  $security_mac_filtering = (isset($_GET['security_mac_filtering'])) ? filter_var(urldecode($_GET['security_mac_filtering']), FILTER_SANITIZE_STRING) : "";
  $security_port_isolation = (isset($_GET['security_port_isolation'])) ? filter_var(urldecode($_GET['security_port_isolation']), FILTER_SANITIZE_STRING) : "";
  $security_uid = (isset($_GET['security_uid'])) ? filter_var(urldecode($_GET['security_uid']), FILTER_SANITIZE_NUMBER_INT) : "";
  $shell = (isset($_GET['shell'])) ? filter_var(urldecode($_GET['shell']), FILTER_SANITIZE_STRING) : "";
  $shift = (isset($_GET['shift'])) ? filter_var(urldecode($_GET['shift']), FILTER_SANITIZE_STRING) : "";
  $type = (isset($_GET['type'])) ? filter_var(urldecode($_GET['type']), FILTER_SANITIZE_STRING) : "";
  $uid = (isset($_GET['uid'])) ? filter_var(urldecode($_GET['uid']), FILTER_SANITIZE_NUMBER_INT) : "";
  $vendorid = (isset($_GET['vendorid'])) ? filter_var(urldecode($_GET['vendorid']), FILTER_SANITIZE_STRING) : "";
  $vlan = (isset($_GET['vlan'])) ? filter_var(urldecode($_GET['vlan']), FILTER_SANITIZE_NUMBER_INT) : "";
  $vlan_tagged = (isset($_GET['vlan_tagged'])) ? filter_var(urldecode($_GET['vlan_tagged']), FILTER_SANITIZE_NUMBER_INT) : "";

  //Require code from lxd-dashboard/backend/config/curl.php
  require_once('../config/curl.php');

  //Require code from lxd-dashboard/backend/config/db.php
  require_once('../config/db.php');

  //Require code from lxd-dashboard/backend/aaa/accounting.php
  require_once('../aaa/accounting.php');

  //Query database for remote host record
  $base_url = retrieveHostURL($remote);

  switch ($action) {
    case "addInstanceDiskDevice":
      $url = $base_url . "/1.0/containers/" . $instance . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $data = json_decode($results, true);
      $data = $data['metadata'];
      $description = $data['description'];

      //Before applying PATCH, check to make sure device does not already exists.
      if (isset($data['devices'][$name])){
        echo '{"type": "error","error": "Unable to add new device. Device name already exists","error_code": 409,"metadata": {"error": "Unable to add new device. Device name already exists"}}';
      }
      else {
        $url = $base_url . "/1.0/containers/" . $instance . "?project=" . $project;
        $device_array = array();
        $device_array['type'] = "disk";
        $device_array['path'] = $path;
        $device_array['source'] = $source;
      
        if (!empty($pool)){ $device_array['pool'] = $pool;}
        if (!empty($limits_read)){ $device_array['limits.read'] = $limits_read;}
        if (!empty($limits_write)){ $device_array['limits.write'] = $limits_write;}
        if (!empty($limits_max)){ $device_array['limits.max'] = $limits_max;}
        if (!empty($required)){ $device_array['required'] = $required;}
        if (!empty($read_only)){ $device_array['readonly'] = $read_only;}
        if (!empty($size)){ $device_array['size'] = $size;}
        if (!empty($size_state)){ $device_array['size.state'] = $size_state;}
        if (!empty($recursive)){ $device_array['recursive'] = $recursive;}
        if (!empty($propagation)){ $device_array['propagation'] = $propagation;}
        if (!empty($shift)){ $device_array['shift'] = $shift;}
        if (!empty($raw_mount_options)){ $device_array['raw.mount.options'] = $raw_mount_options;}
        if (!empty($ceph_user_name)){ $device_array['ceph.user_name'] = $ceph_user_name;}
        if (!empty($ceph_cluster_name)){ $device_array['ceph.cluster_name'] = $ceph_cluster_name;}
        if (!empty($boot_priority)){ $device_array['boot.priority'] = $boot_priority;}

        $device_json = json_encode($device_array);
        $data = '{"description":"'.$description.'", "devices": {"'.$name.'": '.$device_json.'}}';
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

      }
    
      break;

    case "addInstanceGPUDevice":
      $url = $base_url . "/1.0/containers/" . $instance . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $data = json_decode($results, true);
      $data = $data['metadata'];
      $description = $data['description'];

      //Before applying PATCH, check to make sure device does not already exists.
      if (isset($data['devices'][$name])){
        echo '{"type": "error","error": "Unable to add new device. Device name already exists","error_code": 409,"metadata": {"error": "Unable to add new device. Device name already exists"}}';
      }
      else {
        $url = $base_url . "/1.0/containers/" . $instance . "?project=" . $project;
        $device_array = array();
        $device_array['type'] = "gpu";
      
        if (!empty($type)){ $device_array['gputype'] = $type;}
        if (!empty($vendorid)){ $device_array['vendorid'] = $vendorid;}
        if (!empty($productid)){ $device_array['productid'] = $productid;}
        if (!empty($id)){ $device_array['id'] = $id;}
        if (!empty($pci)){ $device_array['pci'] = $pci;}
        if (!empty($uid)){ $device_array['uid'] = $uid;}
        if (!empty($gid)){ $device_array['gid'] = $gid;}
        if (!empty($mode)){ $device_array['mode'] = $mode;}
        if (!empty($migCi)){ $device_array['mig.ci'] = $migCi;}
        if (!empty($migGi)){ $device_array['mig.gi'] = $migGi;}
  
        $device_json = json_encode($device_array);
        $data = '{"description":"'.$description.'", "devices": {"'.$name.'": '.$device_json.'}}';
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
      }
      
      break;

    case "addInstanceNetworkDevice":
      $url = $base_url . "/1.0/containers/" . $instance . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $data = json_decode($results, true);
      $data = $data['metadata'];
      $description = $data['description'];

      //Before applying PATCH, check to make sure device does not already exists.
      if (isset($data['devices'][$name])){
        echo '{"type": "error","error": "Unable to add new device. Device name already exists","error_code": 409,"metadata": {"error": "Unable to add new device. Device name already exists"}}';
      }
      else {
        $url = $base_url . "/1.0/containers/" . $instance . "?project=" . $project;
        $device_array = array();
        $device_array['type'] = "nic";

        if ($property_set == "network"){

          if ($parent_type == "bridge"){
            $device_array['network'] = $network;
            if (!empty($interface_name)){ $device_array['name'] = $interface_name;}
            if (!empty($hwaddr)){ $device_array['hwaddr'] = $hwaddr;}
            if (!empty($host_name)){ $device_array['host_name'] = $host_name;}
            if (!empty($limits_ingress)){ $device_array['limits.ingress'] = $limits_ingress;}
            if (!empty($limits_egress)){ $device_array['limits.egress'] = $limits_egress;}
            if (!empty($limits_max)){ $device_array['limits.max'] = $limits_max;}
            if (!empty($ipv4_address)){ $device_array['ipv4.address'] = $ipv4_address;}
            if (!empty($ipv4_routes)){ $device_array['ipv4.routes'] = $ipv4_routes;}
            if (!empty($ipv6_address)){ $device_array['ipv6.address'] = $ipv6_address;}
            if (!empty($ipv6_routes)){ $device_array['ipv6.routes'] = $ipv6_routes;}
            if (!empty($security_mac_filtering)){ $device_array['security.mac_filtering'] = $security_mac_filtering;}
            if (!empty($security_ipv4_filtering)){ $device_array['security.ipv4_filtering'] = $security_ipv4_filtering;}
            if (!empty($security_ipv6_filtering)){ $device_array['security.ipv6_filtering'] = $security_ipv6_filtering;}
            if (!empty($boot_priority)){ $device_array['boot.priority'] = $boot_priority;}
            if (!empty($vlan)){ $device_array['vlan'] = $vlan;}
            if (!empty($vlan_tagged)){ $device_array['vlan.tagged'] = $vlan_tagged;}
            if (!empty($security_port_isolation)){ $device_array['security.port_isolation'] = $security_port_isolation;}
          }
          if ($parent_type == "macvlan"){
            $device_array['network'] = $network;
            if (!empty($interface_name)){ $device_array['name'] = $interface_name;}
            if (!empty($hwaddr)){ $device_array['hwaddr'] = $hwaddr;}
            if (!empty($boot_priority)){ $device_array['boot.priority'] = $boot_priority;}
            if (!empty($vlan)){ $device_array['vlan'] = $vlan;}
            if (!empty($gvrp)){ $device_array['gvrp'] = $gvrp;}
          }
          if ($parent_type == "ovn"){
            $device_array['network'] = $network;
            if (!empty($interface_name)){ $device_array['name'] = $interface_name;}
            if (!empty($host_name)){ $device_array['host_name'] = $host_name;}
            if (!empty($hwaddr)){ $device_array['hwaddr'] = $hwaddr;}
            if (!empty($ipv4_address)){ $device_array['ipv4.address'] = $ipv4_address;}
            if (!empty($ipv6_address)){ $device_array['ipv6.address'] = $ipv6_address;}
            if (!empty($ipv4_routes)){ $device_array['ipv4.routes'] = $ipv4_routes;}
            if (!empty($ipv4_routes_external)){ $device_array['ipv4.routes.external'] = $ipv4_routes_external;}
            if (!empty($ipv6_routes)){ $device_array['ipv6.routes'] = $ipv6_routes;}
            if (!empty($ipv6_routes_external)){ $device_array['ipv6.routes.external'] = $ipv6_routes_external;}
            if (!empty($boot_priority)){ $device_array['boot.priority'] = $boot_priority;}
            if (!empty($security_acls)){ $device_array['security.acls'] = $security_acls;}
            if (!empty($security_acls_default_ingress_action)){ $device_array['security.acls.default.ingress.action'] = $security_acls_default_ingress_action;}
            if (!empty($security_acls_default_egress_action)){ $device_array['security.acls.default.egress.action'] = $security_acls_default_egress_action;}
            if (!empty($security_acls_default_ingress_logged)){ $device_array['security.acls.default.ingress.logged'] = $security_acls_default_ingress_logged;}
            if (!empty($security_acls_default_egress_logged)){ $device_array['security.acls.default.egress.logged'] = $security_acls_default_egress_logged;}
          }
          if ($parent_type == "sriov"){
            $device_array['network'] = $network;
            if (!empty($interface_name)){ $device_array['name'] = $interface_name;}
            if (!empty($hwaddr)){ $device_array['hwaddr'] = $hwaddr;}
            if (!empty($boot_priority)){ $device_array['boot.priority'] = $boot_priority;}
            if (!empty($vlan)){ $device_array['vlan'] = $vlan;}
            if (!empty($security_mac_filtering)){ $device_array['security.mac_filtering'] = $security_mac_filtering;}
          }
        }

        if ($property_set == "nictype"){
          $device_array['nictype'] = $nictype;

          if ($nictype == "bridged"){
            $device_array['parent'] = $parent;
            if (!empty($interface_name)){ $device_array['name'] = $interface_name;}
            if (!empty($mtu)){ $device_array['mtu'] = $mtu;}
            if (!empty($hwaddr)){ $device_array['hwaddr'] = $hwaddr;}
            if (!empty($host_name)){ $device_array['host_name'] = $host_name;}
            if (!empty($limits_ingress)){ $device_array['limits.ingress'] = $limits_ingress;}
            if (!empty($limits_egress)){ $device_array['limits.egress'] = $limits_egress;}
            if (!empty($limits_max)){ $device_array['limits.max'] = $limits_max;}
            if (!empty($ipv4_address)){ $device_array['ipv4.address'] = $ipv4_address;}
            if (!empty($ipv4_routes)){ $device_array['ipv4.routes'] = $ipv4_routes;}
            if (!empty($ipv6_address)){ $device_array['ipv6.address'] = $ipv6_address;}
            if (!empty($ipv6_routes)){ $device_array['ipv6.routes'] = $ipv6_routes;}
            if (!empty($security_mac_filtering)){ $device_array['security.mac_filtering'] = $security_mac_filtering;}
            if (!empty($security_ipv4_filtering)){ $device_array['security.ipv4_filtering'] = $security_ipv4_filtering;}
            if (!empty($security_ipv6_filtering)){ $device_array['security.ipv6_filtering'] = $security_ipv6_filtering;}
            if (!empty($maas_subnet_ipv4)){ $device_array['maas.subnet.ipv4'] = $maas_subnet_ipv4;}
            if (!empty($maas_subnet_ipv6)){ $device_array['maas.subnet.ipv6'] = $maas_subnet_ipv6;}
            if (!empty($boot_priority)){ $device_array['boot.priority'] = $boot_priority;}
            if (!empty($vlan)){ $device_array['vlan'] = $vlan;}
            if (!empty($vlan_tagged)){ $device_array['vlan.tagged'] = $vlan_tagged;}
            if (!empty($security_port_isolation)){ $device_array['security.port_isolation'] = $security_port_isolation;}
          }
          if ($nictype == "ipvlan"){
            $device_array['parent'] = $parent;
            if (!empty($interface_name)){ $device_array['name'] = $interface_name;}
            if (!empty($mtu)){ $device_array['mtu'] = $mtu;}
            if (!empty($mode)){ $device_array['mode'] = $mode;}
            if (!empty($hwaddr)){ $device_array['hwaddr'] = $hwaddr;}
            if (!empty($ipv4_address)){ $device_array['ipv4.address'] = $ipv4_address;}
            if (!empty($ipv4_gateway)){ $device_array['ipv4.gateway'] = $ipv4_gateway;}
            if (!empty($ipv4_host_table)){ $device_array['ipv4.host_table'] = $ipv4_host_table;}
            if (!empty($ipv6_address)){ $device_array['ipv6.address'] = $ipv6_address;}
            if (!empty($ipv6_gateway)){ $device_array['ipv6.gateway'] = $ipv6_gateway;}
            if (!empty($ipv6_host_table)){ $device_array['ipv6.host_table'] = $ipv6_host_table;}
            if (!empty($vlan)){ $device_array['vlan'] = $vlan;}
            if (!empty($gvrp)){ $device_array['gvrp'] = $gvrp;}
          }
          if ($nictype == "macvlan"){
            $device_array['parent'] = $parent;
            if (!empty($interface_name)){ $device_array['name'] = $interface_name;}
            if (!empty($mtu)){ $device_array['mtu'] = $mtu;}
            if (!empty($hwaddr)){ $device_array['hwaddr'] = $hwaddr;}
            if (!empty($maas_subnet_ipv4)){ $device_array['maas.subnet.ipv4'] = $maas_subnet_ipv4;}
            if (!empty($maas_subnet_ipv6)){ $device_array['maas.subnet.ipv6'] = $maas_subnet_ipv6;}
            if (!empty($boot_priority)){ $device_array['boot.priority'] = $boot_priority;}
            if (!empty($vlan)){ $device_array['vlan'] = $vlan;}
            if (!empty($gvrp)){ $device_array['gvrp'] = $gvrp;}
          }
          if ($nictype == "p2p"){
            if (!empty($interface_name)){ $device_array['name'] = $interface_name;}
            if (!empty($mtu)){ $device_array['mtu'] = $mtu;}
            if (!empty($hwaddr)){ $device_array['hwaddr'] = $hwaddr;}
            if (!empty($host_name)){ $device_array['host_name'] = $host_name;}
            if (!empty($limits_ingress)){ $device_array['limits.ingress'] = $limits_ingress;}
            if (!empty($limits_egress)){ $device_array['limits.egress'] = $limits_egress;}
            if (!empty($limits_max)){ $device_array['limits.max'] = $limits_max;}
            if (!empty($ipv4_routes)){ $device_array['ipv4.routes'] = $ipv4_routes;}
            if (!empty($ipv6_routes)){ $device_array['ipv6.routes'] = $ipv6_routes;}
            if (!empty($boot_priority)){ $device_array['boot.priority'] = $boot_priority;}
          }
          if ($nictype == "physical"){
            $device_array['parent'] = $parent;
            if (!empty($interface_name)){ $device_array['name'] = $interface_name;}
            if (!empty($mtu)){ $device_array['mtu'] = $mtu;}
            if (!empty($hwaddr)){ $device_array['hwaddr'] = $hwaddr;}
            if (!empty($maas_subnet_ipv4)){ $device_array['maas.subnet.ipv4'] = $maas_subnet_ipv4;}
            if (!empty($maas_subnet_ipv6)){ $device_array['maas.subnet.ipv6'] = $maas_subnet_ipv6;}
            if (!empty($boot_priority)){ $device_array['boot.priority'] = $boot_priority;}
            if (!empty($vlan)){ $device_array['vlan'] = $vlan;}
            if (!empty($gvrp)){ $device_array['gvrp'] = $gvrp;}
          }
          if ($nictype == "routed"){
            $device_array['parent'] = $parent;
            if (!empty($interface_name)){ $device_array['name'] = $interface_name;}
            if (!empty($mtu)){ $device_array['mtu'] = $mtu;}
            if (!empty($hwaddr)){ $device_array['hwaddr'] = $hwaddr;}
            if (!empty($host_name)){ $device_array['host_name'] = $host_name;}
            if (!empty($limits_ingress)){ $device_array['limits.ingress'] = $limits_ingress;}
            if (!empty($limits_egress)){ $device_array['limits.egress'] = $limits_egress;}
            if (!empty($limits_max)){ $device_array['limits.max'] = $limits_max;}
            if (!empty($ipv4_address)){ $device_array['ipv4.address'] = $ipv4_address;}
            if (!empty($ipv4_gateway)){ $device_array['ipv4.gateway'] = $ipv4_gateway;}
            if (!empty($ipv4_host_table)){ $device_array['ipv4.host_table'] = $ipv4_host_table;}
            if (!empty($ipv4_host_address)){ $device_array['ipv4.host_address'] = $ipv4_host_address;}
            if (!empty($ipv6_address)){ $device_array['ipv6.address'] = $ipv6_address;}
            if (!empty($ipv6_gateway)){ $device_array['ipv6.gateway'] = $ipv6_gateway;}
            if (!empty($ipv6_host_table)){ $device_array['ipv6.host_table'] = $ipv6_host_table;}
            if (!empty($ipv6_host_address)){ $device_array['ipv6.host_address'] = $ipv6_host_address;}
            if (!empty($vlan)){ $device_array['vlan'] = $vlan;}
            if (!empty($gvrp)){ $device_array['gvrp'] = $gvrp;}
          }
          if ($nictype == "sriov"){
            $device_array['parent'] = $parent;
            if (!empty($interface_name)){ $device_array['name'] = $interface_name;}
            if (!empty($mtu)){ $device_array['mtu'] = $mtu;}
            if (!empty($hwaddr)){ $device_array['hwaddr'] = $hwaddr;}
            if (!empty($maas_subnet_ipv4)){ $device_array['maas.subnet.ipv4'] = $maas_subnet_ipv4;}
            if (!empty($maas_subnet_ipv6)){ $device_array['maas.subnet.ipv6'] = $maas_subnet_ipv6;}
            if (!empty($boot_priority)){ $device_array['boot.priority'] = $boot_priority;}
            if (!empty($vlan)){ $device_array['vlan'] = $vlan;}
            if (!empty($security_mac_filtering)){ $device_array['security.mac_filtering'] = $security_mac_filtering;}
          }
        }

        $device_json = json_encode($device_array);
        $data = '{"description":"'.$description.'", "devices": {"'.$name.'": '.$device_json.'}}';
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
      }

      break;
    
    case "addInstanceProxyDevice":
      $url = $base_url . "/1.0/containers/" . $instance . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $data = json_decode($results, true);
      $data = $data['metadata'];
      $description = $data['description'];

      //Before applying PATCH, check to make sure device does not already exists.
      if (isset($data['devices'][$name])){
        echo '{"type": "error","error": "Unable to add new device. Device name already exists","error_code": 409,"metadata": {"error": "Unable to add new device. Device name already exists"}}';
      }
      else {
        $url = $base_url . "/1.0/containers/" . $instance . "?project=" . $project;
        $device_array = array();
        $device_array['type'] = "proxy";
        $device_array['listen'] = $listen;
        $device_array['connect'] = $connect;
      
        if (!empty($bind)){ $device_array['bind'] = $bind;}
        if (!empty($uid)){ $device_array['uid'] = $uid;}
        if (!empty($gid)){ $device_array['gid'] = $gid;}
        if (!empty($mode)){ $device_array['mode'] = $mode;}
        if (!empty($nat)){ $device_array['nat'] = $nat;}
        if (!empty($proxy_protocol)){ $device_array['proxy_protocol'] = $proxy_protocol;}
        if (!empty($security_uid)){ $device_array['security_uid'] = $security_uid;}
        if (!empty($security_gid)){ $device_array['security_gid'] = $security_gid;}
  
        $device_json = json_encode($device_array);
        $data = '{"description":"'.$description.'", "devices": {"'.$name.'": '.$device_json.'}}';
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
      }
      
      break;

    case "addInstanceUnixDevice":
      $url = $base_url . "/1.0/containers/" . $instance . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $data = json_decode($results, true);
      $data = $data['metadata'];
      $description = $data['description'];

      //Before applying PATCH, check to make sure device does not already exists.
      if (isset($data['devices'][$name])){
        echo '{"type": "error","error": "Unable to add new device. Device name already exists","error_code": 409,"metadata": {"error": "Unable to add new device. Device name already exists"}}';
      }
      else {
        $url = $base_url . "/1.0/containers/" . $instance . "?project=" . $project;
        $device_array = array();
        $device_array['type'] = $type;
        $device_array['source'] = $source;
        $device_array['path'] = $path;
      
        if (!empty($major)){ $device_array['major'] = $major;}
        if (!empty($minor)){ $device_array['minor'] = $minor;}
        if (!empty($uid)){ $device_array['uid'] = $uid;}
        if (!empty($gid)){ $device_array['gid'] = $gid;}
        if (!empty($mode)){ $device_array['mode'] = $mode;}
        if (!empty($required)){ $device_array['required'] = $required;}
  
        $device_json = json_encode($device_array);
        $data = '{"description":"'.$description.'", "devices": {"'.$name.'": '.$device_json.'}}';
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
      }
      
      break;

    case "addInstanceUSBDevice":
      $url = $base_url . "/1.0/containers/" . $instance . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $data = json_decode($results, true);
      $data = $data['metadata'];
      $description = $data['description'];

      //Before applying PATCH, check to make sure device does not already exists.
      if (isset($data['devices'][$name])){
        echo '{"type": "error","error": "Unable to add new device. Device name already exists","error_code": 409,"metadata": {"error": "Unable to add new device. Device name already exists"}}';
      }
      else {
        $url = $base_url . "/1.0/containers/" . $instance . "?project=" . $project;
        $device_array = array();
        $device_array['type'] = "usb";
        $device_array['vendorid'] = $vendorid;
      
        if (!empty($productid)){ $device_array['productid'] = $productid;}
        if (!empty($uid)){ $device_array['uid'] = $uid;}
        if (!empty($gid)){ $device_array['gid'] = $gid;}
        if (!empty($mode)){ $device_array['mode'] = $mode;}
  
        $device_json = json_encode($device_array);
        $data = '{"description":"'.$description.'", "devices": {"'.$name.'": '.$device_json.'}}';
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
      }
      
      break;

    case "displayInstanceInfo":
      $url = $base_url . "/1.0/containers/".$instance."?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      echo $results;
      break;

    case "displayInstanceStateInfo":
      $url = $base_url . "/1.0/containers/".$instance."/state?project=" . $project;
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
        $memory = number_format($memory/1024/1024, 2); //total amount of memory used in MiB
        $memory_unit = "MiB";
      }
      else {
        $memory = number_format($memory/1024/1024/1024, 2); //total amount of memory used in GiB
        $memory_unit = "GiB";
      }

      //Format swap memory output
      if ($swap < 1073741824){
        $swap = number_format($swap/1024/1024, 2); //total amount of swap memory used in MiB
        $swap_unit = "MiB";
      }
      else {
        $swap = number_format($swap/1024/1024/1024, 2); //total amount of swap memory used in GiB
        $swap_unit = "GiB";
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
      $url = $base_url . "/1.0/containers/".$instance."/console?project=" . $project;
      //$data = '{ "command": ["/bin/bash"], "wait-for-websocket": true, "record-output": false, "interactive": true, "width": 80, "height": 25, "user": 0, "group": 0, "cwd": "/~" }';
      $data = '{ "type": "console", "width": 80, "height": 25 }';
      $results = sendCurlRequest($action, "POST", $url, $data);

      $exec_api_data = json_decode($results, true);
      $operation = (isset($exec_api_data['operation'])) ? $exec_api_data['operation'] : ""; //$operation = "/1.0/operations/d77f70b9-ae8d-4a47-9935-4d49d707f0aa";
      $secret = (isset($exec_api_data['metadata']['metadata']['fds']["0"])) ? $exec_api_data['metadata']['metadata']['fds']["0"] : ""; //$secret = "64f5592ee1bc64b8b699e232371dd1286465bafa4a9e688ea7a9cc48f785e98e";
      $control = (isset($exec_api_data['metadata']['metadata']['fds']["control"])) ? $exec_api_data['metadata']['metadata']['fds']["control"] : ""; //used to close connection properly

      $results = '{"operation": "'.$operation.'", "secret": "'.$secret.'", "control": "'.$control.'"}';
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance;
      logEvent($action, $remote, $project, $object, '200', 'Ok');

      break;

    case "establishInstanceWebSocketExecConnection":
      $url = $base_url . "/1.0/containers/".$instance."/exec?project=" . $project;
      if ($shell == "sh"){
        $data = '{ "command": ["/bin/sh"], "wait-for-websocket": true, "environment":{"HOME": "/root", "TERM": "xterm", "USER": "root"}, "interactive": true}';
      }
      else {
        $data = '{ "command": ["/bin/bash"], "wait-for-websocket": true, "environment":{"HOME": "/root", "TERM": "xterm", "USER": "root"}, "interactive": true}';
      }
      $results = sendCurlRequest($action, "POST", $url, $data);

      $exec_api_data = json_decode($results, true);
      $operation = (isset($exec_api_data['operation'])) ? $exec_api_data['operation'] : ""; //$operation = "/1.0/operations/d77f70b9-ae8d-4a47-9935-4d49d707f0aa";
      $secret = (isset($exec_api_data['metadata']['metadata']['fds']["0"])) ? $exec_api_data['metadata']['metadata']['fds']["0"] : ""; //$secret = "64f5592ee1bc64b8b699e232371dd1286465bafa4a9e688ea7a9cc48f785e98e";
      $control = (isset($exec_api_data['metadata']['metadata']['fds']["control"])) ? $exec_api_data['metadata']['metadata']['fds']["control"] : ""; //used to close connection properly

      $results = '{"operation": "'.$operation.'", "secret": "'.$secret.'", "control": "'.$control.'"}';
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $instance;
      logEvent($action, $remote, $project, $object, '200', 'Ok');

      break;
      
    case "listInstanceBackups":
      $url = $base_url . "/1.0/containers/" . $instance . "/backups?recursion=1&project=" . $project;
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

      if ($results['status_code'] == "200"){

        foreach ($instance_backups as $instance_backup){

          $instance_only = ($instance_backup['instance_only'])?"true":"false";
          $optimized_storage = ($instance_backup['optimized_storage'])?"true":"false";
          $hostname = retrieveHostName($remote);
          $file = '/var/lxdware/backups/' . $hostname . '/' . $project . '/' . $instance . '/' . $instance_backup['name'];
          $file_exists = false;
          $file_size = "";
          $unit_size = "";

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
              $unit_size = "KiB";
            }
            if ($file_size >= 1024){
              $file_size = $file_size / 1024;
              $unit_size = "MiB";
            }
            if ($file_size >= 1024){
              $file_size = $file_size / 1024;
              $unit_size = "GiB";
            }
            if ($file_size >= 1024){
              $file_size = $file_size / 1024;
              $unit_size = "TiB";
            }

            $file_size = (number_format($file_size,2));

            echo '"' . "<a href='./backend/lxd/containers.php?remote=".$remote."&project=".$project."&instance=".$instance."&name=".$instance_backup['name']."&action=downloadInstanceExportFile'>".htmlentities(basename($file))."</a>" . '",';
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
          echo '"' . htmlentities($file_size . " " . $unit_size) . '",';

          echo '"';
            //check to see if file exists for export action
            if (!$file_exists && !in_array($instance_backup['name'], $current_backups)){
              echo "<a href='#' onclick=exportInstanceBackup('".$instance_backup['name']."')><i class='fas fa-file-export fa-lg' style='color:#ddd' title='Export to local file' aria-hidden='true'></i></a>";
            } 
            else {
              echo "<i class='fas fa-file-export fa-lg' style='color:#f1f1f1' title='Export to local file' aria-hidden='true'></i>";
            }
            echo " &nbsp ";
            echo "<a href='#' onclick=deleteInstanceBackup('".$instance_backup['name']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
            
          echo '"';

          echo " ]";
          
        }

      }

      echo " ]}";
      break;

    case "listInstanceDiskDevices":
      $url = $base_url . "/1.0/containers/" . $instance . "/state?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $disk_names = (isset($results['metadata']['disk'])) ? $results['metadata']['disk'] : [];

      //Retrieve Expanded Device information to get a list of disks
      $url = $base_url . "/1.0/containers/" . $instance . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $device_names = (isset($results['metadata']['devices'])) ? $results['metadata']['devices'] : [];
      $expanded_device_names = (isset($results['metadata']['expanded_devices'])) ? $results['metadata']['expanded_devices'] : [];

      $i = 0;
      echo '{ "data": [';

      if ($results['status_code'] == "200"){

        //Loop through the expanded devices
        foreach ($expanded_device_names as $expanded_device_name => $device_data){
          $disk_path = (isset($device_data['path'])) ? $device_data['path'] : "";
          $disk_type = $device_data['type'];
          $disk_usage = "";
          $disk_unit = "";
          
          //Proceed only if a disk device
          if ($disk_type == "disk"){

            //Determine if there is usage data available for disk device
            foreach ($disk_names as $disk_name => $disk_data){
              if ($expanded_device_name == $disk_name){
                $disk_usage = $disk_data['usage']/1024/1024;
                $disk_unit = "MiB";
                if ($disk_usage >= 1024){
                  $disk_usage = $disk_usage/1024;
                  $disk_unit = "GiB";
                }
                if ($disk_usage >= 1024){
                  $disk_usage = $disk_usage/1024;
                  $disk_unit = "TiB";
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
    
            echo '"' . htmlentities($expanded_device_name) . '",';
            echo '"' . htmlentities($disk_path) . '",';
            echo '"' . htmlentities($disk_usage) . " " . $disk_unit . '",';
            echo '"' . htmlentities($disk_type) . '",';

            echo '"';
            if (array_key_exists($expanded_device_name, $device_names)){
              echo "<a href='#' onclick=removeInstanceDevice('".$expanded_device_name."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Remove' aria-hidden='true'></i></a>";
            } 
            echo '"';
    
            echo " ]";

          }

        }

      }

      echo " ]}";
      break;

    case "listInstanceGPUDevices":
      $url = $base_url . "/1.0/containers/" . $instance . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $device_names = (isset($results['metadata']['devices'])) ? $results['metadata']['devices'] : [];
      $expanded_device_names = (isset($results['metadata']['expanded_devices'])) ? $results['metadata']['expanded_devices'] : [];
    
      $i = 0;
      echo '{ "data": [';
    
      if ($results['status_code'] == "200"){

        foreach ($expanded_device_names as $expanded_device_name => $device_data){
          if ($device_data['type'] == "gpu"){

            $device_data_type = (isset($device_data['gputype'])) ? htmlentities($device_data['gputype']) : "";
            $device_data_vendorid = (isset($device_data['vendorid'])) ? htmlentities($device_data['vendorid']) : "";
            $device_data_productid = (isset($device_data['productid'])) ? htmlentities($device_data['productid']) : "";
            $device_data_id = (isset($device_data['id'])) ? htmlentities($device_data['id']) : "";
            $device_data_pci = (isset($device_data['pci'])) ? htmlentities($device_data['pci']) : "";
            $device_data_uid = (isset($device_data['uid'])) ? htmlentities($device_data['uid']) : "";
            $device_data_gid = (isset($device_data['gid'])) ? htmlentities($device_data['gid']) : "";
            $device_data_mode = (isset($device_data['mode'])) ? htmlentities($device_data['mode']) : "";
            $device_data_mig_ci = (isset($device_data['mig.ci'])) ? htmlentities($device_data['mig.ci']) : "";
            $device_data_mig_gi = (isset($device_data['mig.gi'])) ? htmlentities($device_data['mig.gi']) : "";

            if ($i > 0){
              echo ",";
            }
            $i++;

            echo "[ ";

            echo '"' . "<i class='fas fa-photo-video fa-lg' style='color:#4e73df'></i>" . '",';

            echo '"' . htmlentities($expanded_device_name) . '",';
            echo '"' . $device_data_vendorid . '",';
            echo '"' . $device_data_productid . '",';
            echo '"' . $device_data_id . '",';
            echo '"' . $device_data_pci . '",';
            echo '"' . $device_data_type . '",';

            echo '"';
            if (array_key_exists($expanded_device_name, $device_names)){
              echo "<a href='#' onclick=removeInstanceDevice('".$expanded_device_name."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Remove' aria-hidden='true'></i></a>";
            } 
            echo '"';

            echo " ]";
      
          }

        }

      }
      
      echo " ]}";
      break;

    case "listInstanceInterfaces":
      $url = $base_url . "/1.0/containers/" . $instance . "/state?recursion=1&project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $networks = (isset($results['metadata']['network'])) ? $results['metadata']['network'] : [];

      $i = 0;
      echo '{ "data": [';

      if ($results['status_code'] == "200"){

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

      }

      echo " ]}";
  
      break;

    case "listInstanceLogs":
      $url = $base_url . "/1.0/containers/" . $instance . "/logs?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $instance_logs = (isset($results['metadata'])) ? $results['metadata'] : [];

      $i = 0;
      echo '{ "data": [';

      if ($results['status_code'] == "200"){

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

      }
      
      echo " ]}";
      break;

    case "listInstanceNetworkDevices":
      $url = $base_url . "/1.0/containers/" . $instance . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $device_names = (isset($results['metadata']['devices'])) ? $results['metadata']['devices'] : [];
      $expanded_device_names = (isset($results['metadata']['expanded_devices'])) ? $results['metadata']['expanded_devices'] : [];
    
      $i = 0;
      echo '{ "data": [';
    
      if ($results['status_code'] == "200"){

        foreach ($expanded_device_names as $expanded_device_name => $device_data){
          if ($device_data['type'] == "nic"){

            $device_data_nictype = (isset($device_data['nictype'])) ? htmlentities($device_data['nictype']) : "";
            $device_data_parent = (isset($device_data['parent'])) ? htmlentities($device_data['parent']) : "";
            $device_data_network = (isset($device_data['network'])) ? htmlentities($device_data['network']) : "";
            $device_data_name = (isset($device_data['name'])) ? htmlentities($device_data['name']) : "";

            if ($i > 0){
              echo ",";
            }
            $i++;

            echo "[ ";

            echo '"' . "<i class='fas fa-exchange-alt fa-lg' style='color:#4e73df'></i>" . '",';

            echo '"' . htmlentities($expanded_device_name) . '",';
            echo '"' . $device_data_nictype . '",';
            echo '"' . $device_data_parent . '",';
            echo '"' . $device_data_network . '",';
            echo '"' . $device_data_name . '",';

            echo '"';
            if (array_key_exists($expanded_device_name, $device_names)){
              echo "<a href='#' onclick=removeInstanceDevice('".$expanded_device_name."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Remove' aria-hidden='true'></i></a>";
            } 
            echo '"';

            echo " ]";
      
          }

        }
    
      }
      
      echo " ]}";

      break;

    case "listInstanceProfiles":
      $url = $base_url . "/1.0/containers/" . $instance . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $profile_names = (isset($results['metadata']['profiles'])) ? $results['metadata']['profiles'] : [];

      $i = 0;
      echo '{ "data": [';
        
      if ($results['status_code'] == "200"){

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

      }

      echo " ]}";
      break;
      
    case "listInstanceProxyDevices":
      $url = $base_url . "/1.0/containers/" . $instance . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $device_names = (isset($results['metadata']['devices'])) ? $results['metadata']['devices'] : [];
      $expanded_device_names = (isset($results['metadata']['expanded_devices'])) ? $results['metadata']['expanded_devices'] : [];
    
      $i = 0;
      echo '{ "data": [';
    
      if ($results['status_code'] == "200"){

        foreach ($expanded_device_names as $expanded_device_name => $device_data){
          if ($device_data['type'] == "proxy"){

            $device_data_connect = (isset($device_data['connect'])) ? htmlentities($device_data['connect']) : "";
            $device_data_listen = (isset($device_data['listen'])) ? htmlentities($device_data['listen']) : "";
            $device_data_type = (isset($device_data['type'])) ? htmlentities($device_data['type']) : "";

            if ($i > 0){
              echo ",";
            }
            $i++;

            echo "[ ";

            echo '"' . "<i class='fas fa-exchange-alt fa-lg' style='color:#4e73df'></i>" . '",';

            echo '"' . htmlentities($expanded_device_name) . '",';
            echo '"' . $device_data_connect . '",';
            echo '"' . $device_data_listen . '",';
            echo '"' . $device_data_type . '",';

            echo '"';
            if (array_key_exists($expanded_device_name, $device_names)){
              echo "<a href='#' onclick=removeInstanceDevice('".$expanded_device_name."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Remove' aria-hidden='true'></i></a>";
            } 
            echo '"';

            echo " ]";
      
          }

        }

      }
      
      echo " ]}";
      break;

    case "listInstanceSnapshots":
      $url = $base_url . "/1.0/containers/" . $instance . "/snapshots?recursion=1&project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $snapshots = (isset($results['metadata'])) ? $results['metadata'] : [];

      $i = 0;
      echo '{ "data": [';

      if ($results['status_code'] == "200"){

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
          echo '"' . htmlentities(number_format($snapshot['size']/1024/1024,2)) . " MiB" . '",';

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

      }
      
      echo " ]}";
      break;

    case "listInstanceUnixDevices":
      $url = $base_url . "/1.0/containers/" . $instance . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $device_names = (isset($results['metadata']['devices'])) ? $results['metadata']['devices'] : [];
      $expanded_device_names = (isset($results['metadata']['expanded_devices'])) ? $results['metadata']['expanded_devices'] : [];
    
      $i = 0;
      echo '{ "data": [';
    
      if ($results['status_code'] == "200"){

        foreach ($expanded_device_names as $expanded_device_name => $device_data){
          if ($device_data['type'] == "unix-block" || $device_data['type'] == "unix-char" ){

            $device_data_source = (isset($device_data['source'])) ? htmlentities($device_data['source']) : "";
            $device_data_path = (isset($device_data['path'])) ? htmlentities($device_data['path']) : "";
            $device_data_major = (isset($device_data['major'])) ? htmlentities($device_data['major']) : "";
            $device_data_minor = (isset($device_data['minor'])) ? htmlentities($device_data['minor']) : "";
            $device_data_uid = (isset($device_data['uid'])) ? htmlentities($device_data['uid']) : "";
            $device_data_gid = (isset($device_data['gid'])) ? htmlentities($device_data['gid']) : "";
            $device_data_mode = (isset($device_data['mode'])) ? htmlentities($device_data['mode']) : "";
            $device_data_required = (isset($device_data['required'])) ? htmlentities($device_data['required']) : "";
            $device_data_type = (isset($device_data['type'])) ? htmlentities($device_data['type']) : "";

            if ($i > 0){
              echo ",";
            }
            $i++;

            echo "[ ";

            echo '"' . "<i class='fas fa-stream fa-lg' style='color:#4e73df'></i>" . '",';

            echo '"' . htmlentities($expanded_device_name) . '",';
            echo '"' . $device_data_source . '",';
            echo '"' . $device_data_path . '",';
            echo '"' . $device_data_mode . '",';
            echo '"' . $device_data_required . '",';
            echo '"' . $device_data_type . '",';

            echo '"';
            if (array_key_exists($expanded_device_name, $device_names)){
              echo "<a href='#' onclick=removeInstanceDevice('".$expanded_device_name."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Remove' aria-hidden='true'></i></a>";
            } 
            echo '"';

            echo " ]";
      
          }

        }

      }
      
      echo " ]}";
      break;
    
    case "listInstanceUSBDevices":
      $url = $base_url . "/1.0/containers/" . $instance . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $results = json_decode($results, true);
      $device_names = (isset($results['metadata']['devices'])) ? $results['metadata']['devices'] : [];
      $expanded_device_names = (isset($results['metadata']['expanded_devices'])) ? $results['metadata']['expanded_devices'] : [];
    
      $i = 0;
      echo '{ "data": [';
    
      if ($results['status_code'] == "200"){

        foreach ($expanded_device_names as $expanded_device_name => $device_data){
          if ($device_data['type'] == "usb"){

            $device_data_vendorid = (isset($device_data['vendorid'])) ? htmlentities($device_data['vendorid']) : "";
            $device_data_productid = (isset($device_data['productid'])) ? htmlentities($device_data['productid']) : "";
            $device_data_uid = (isset($device_data['uid'])) ? htmlentities($device_data['uid']) : "";
            $device_data_gid = (isset($device_data['gid'])) ? htmlentities($device_data['gid']) : "";
            $device_data_mode = (isset($device_data['mode'])) ? htmlentities($device_data['mode']) : "";
            $device_data_required = (isset($device_data['required'])) ? htmlentities($device_data['required']) : "";
            $device_data_type = (isset($device_data['type'])) ? htmlentities($device_data['type']) : "";

            if ($i > 0){
              echo ",";
            }
            $i++;

            echo "[ ";

            echo '"' . "<i class='fab fa-usb fa-lg' style='color:#4e73df'></i>" . '",';

            echo '"' . htmlentities($expanded_device_name) . '",';
            echo '"' . $device_data_vendorid . '",';
            echo '"' . $device_data_productid . '",';
            echo '"' . $device_data_mode . '",';
            echo '"' . $device_data_required . '",';
            echo '"' . $device_data_type . '",';

            echo '"';
            if (array_key_exists($expanded_device_name, $device_names)){
              echo "<a href='#' onclick=removeInstanceDevice('".$expanded_device_name."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Remove' aria-hidden='true'></i></a>";
            } 
            echo '"';

            echo " ]";
      
          }

        }

      }
      
      echo " ]}";
      break;

    case "removeInstanceDevice":
      $url = $base_url . "/1.0/containers/" . $instance . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      $data = json_decode($results, true);
      $data = $data['metadata'];

      if (isset($data['devices'][$name])){
        unset($data['devices'][$name]);
        if (empty($data['devices'])){
          unset($data['devices']);
        }
        $data = json_encode($data);
        $url = $base_url . "/1.0/containers/" . $instance . "?project=" . $project;
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
      }

      break;

    case "retrieveGaugeStats":
      $url = $base_url . "/1.0/containers/" . $instance . "/exec?project=" . $project;

      //Write CPU and memory percentage to a file and retrieve the contents
      $command = "echo $(top -bn 2 -d 1 | grep Cpu |tail -n 1 | awk -F, '{ print $4 }' | awk '{ print $1  }'), $(free | grep Mem | awk '{ print  $3 / $2 * 100 }') > /tmp/lxc_stats";
      $data = '{ "command": ["/bin/sh", "-c", "' . $command . '"], "environment": {}, "wait-for-websocket": false, "record-output": false, "interactive": false, "width": 80, "height": 25, "user": 0, "group": 0, "cwd": "/"}';
      $results = sendCurlRequest($action, "POST", $url, $data);
      
      $url = $base_url . "/1.0/containers/" . $instance . "/files?project=" . $project . "&path=/tmp/lxc_stats";
      $results = sendCurlRequest($action, "GET", $url);
     
      $results = str_replace( "\n", "", $results);
      $results = explode(",", $results);
      
      if (is_numeric($results[0])){
        $results[0] = number_format(100-$results[0],1);
      }
      else{
        $results[0] = null;
      }
      
      $results[1] = number_format($results[1],1);
      $results = json_encode($results);

      echo $results;

      break;
      


    case "retrieveHostAndPort":
      $host = retrieveHostName($remote);
      $port = retrieveHostPort($remote);
      $external_host = retrieveExternalHostName($remote);
      $external_port = retrieveExternalHostPort($remote);
      if (!empty($external_host) && !empty($external_port)){
        $results =  '{"host": "'.$external_host.'", "port": "'.$external_port.'"}';
      }
      else {
        $results =  '{"host": "'.$host.'", "port": "'.$port.'"}';
      }
      echo $results;
      break;
    case "retrieveInstanceState":
      $url = $base_url . "/1.0/containers/" . $instance . "/state?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      echo $results;
      break;
    
  }
    
}
?>
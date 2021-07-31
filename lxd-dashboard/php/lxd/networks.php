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
  $bridge_driver = (isset($_GET['bridge_driver'])) ? filter_var(urldecode($_GET['bridge_driver']), FILTER_SANITIZE_STRING) : "";
  $bridge_external_interfaces = (isset($_GET['bridge_external_interfaces'])) ? filter_var(urldecode($_GET['bridge_external_interfaces']), FILTER_SANITIZE_STRING) : "";
  $bridge_hwaddr = (isset($_GET['bridge_hwaddr'])) ? filter_var(urldecode($_GET['bridge_hwaddr']), FILTER_SANITIZE_STRING) : "";
  $bridge_mode = (isset($_GET['bridge_mode'])) ? filter_var(urldecode($_GET['bridge_mode']), FILTER_SANITIZE_STRING) : "";
  $bridge_mtu = (isset($_GET['bridge_mtu'])) ? filter_var(urldecode($_GET['bridge_mtu']), FILTER_SANITIZE_STRING) : "";
  $description = (isset($_GET['description'])) ? filter_var(urldecode($_GET['description']), FILTER_SANITIZE_STRING) : "";
  $dns_domain = (isset($_GET['dns_domain'])) ? filter_var(urldecode($_GET['dns_domain']), FILTER_SANITIZE_STRING) : "";
  $dns_mode = (isset($_GET['dns_mode'])) ? filter_var(urldecode($_GET['dns_mode']), FILTER_SANITIZE_STRING) : "";
  $dns_nameservers = (isset($_GET['dns_nameservers'])) ? filter_var(urldecode($_GET['dns_nameservers']), FILTER_SANITIZE_STRING) : "";
  $dns_search = (isset($_GET['dns_search'])) ? filter_var(urldecode($_GET['dns_search']), FILTER_SANITIZE_STRING) : "";
  $fan_overlay_subnet = (isset($_GET['fan_overlay_subnet'])) ? filter_var(urldecode($_GET['fan_overlay_subnet']), FILTER_SANITIZE_STRING) : "";
  $fan_type = (isset($_GET['fan_type'])) ? filter_var(urldecode($_GET['fan_type']), FILTER_SANITIZE_STRING) : "";
  $fan_underlay_subnet = (isset($_GET['fan_underlay_subnet'])) ? filter_var(urldecode($_GET['fan_underlay_subnet']), FILTER_SANITIZE_STRING) : "";
  $ipv4_address = (isset($_GET['ipv4_address'])) ? filter_var(urldecode($_GET['ipv4_address']), FILTER_SANITIZE_STRING) : "";
  $ipv4_dhcp = (isset($_GET['ipv4_dhcp'])) ? filter_var(urldecode($_GET['ipv4_dhcp']), FILTER_SANITIZE_STRING) : "";
  $ipv4_dhcp_expiry = (isset($_GET['ipv4_dhcp_expiry'])) ? filter_var(urldecode($_GET['ipv4_dhcp_expiry']), FILTER_SANITIZE_STRING) : "";
  $ipv4_dhcp_gateway = (isset($_GET['ipv4_dhcp_gateway'])) ? filter_var(urldecode($_GET['ipv4_dhcp_gateway']), FILTER_SANITIZE_STRING) : "";
  $ipv4_dhcp_ranges = (isset($_GET['ipv4_dhcp_ranges'])) ? filter_var(urldecode($_GET['ipv4_dhcp_ranges']), FILTER_SANITIZE_STRING) : "";
  $ipv4_firewall = (isset($_GET['ipv4_firewall'])) ? filter_var(urldecode($_GET['ipv4_firewall']), FILTER_SANITIZE_STRING) : "";
  $ipv4_gateway = (isset($_GET['ipv4_gateway'])) ? filter_var(urldecode($_GET['ipv4_gateway']), FILTER_SANITIZE_STRING) : "";
  $ipv4_nat = (isset($_GET['ipv4_nat'])) ? filter_var(urldecode($_GET['ipv4_nat']), FILTER_SANITIZE_STRING) : "";
  $ipv4_nat_address = (isset($_GET['ipv4_nat_address'])) ? filter_var(urldecode($_GET['ipv4_nat_address']), FILTER_SANITIZE_STRING) : "";
  $ipv4_nat_order = (isset($_GET['ipv4_nat_order'])) ? filter_var(urldecode($_GET['ipv4_nat_order']), FILTER_SANITIZE_STRING) : "";
  $ipv4_ovn_ranges = (isset($_GET['ipv4_ovn_ranges'])) ? filter_var(urldecode($_GET['ipv4_ovn_ranges']), FILTER_SANITIZE_STRING) : "";
  $ipv4_routes = (isset($_GET['ipv4_routes'])) ? filter_var(urldecode($_GET['ipv4_routes']), FILTER_SANITIZE_STRING) : "";
  $ipv4_routes_anycast = (isset($_GET['ipv4_routes_anycast'])) ? filter_var(urldecode($_GET['ipv4_routes_anycast']), FILTER_SANITIZE_STRING) : "";
  $ipv4_routing = (isset($_GET['ipv4_routing'])) ? filter_var(urldecode($_GET['ipv4_routing']), FILTER_SANITIZE_STRING) : "";
  $ipv6_address = (isset($_GET['ipv6_address'])) ? filter_var(urldecode($_GET['ipv6_address']), FILTER_SANITIZE_STRING) : "";
  $ipv6_dhcp = (isset($_GET['ipv6_dhcp'])) ? filter_var(urldecode($_GET['ipv6_dhcp']), FILTER_SANITIZE_STRING) : "";
  $ipv6_dhcp_expiry = (isset($_GET['ipv6_dhcp_expiry'])) ? filter_var(urldecode($_GET['ipv6_dhcp_expiry']), FILTER_SANITIZE_STRING) : "";
  $ipv6_dhcp_ranges = (isset($_GET['ipv6_dhcp_ranges'])) ? filter_var(urldecode($_GET['ipv6_dhcp_ranges']), FILTER_SANITIZE_STRING) : "";
  $ipv6_dhcp_stateful = (isset($_GET['ipv6_dhcp_stateful'])) ? filter_var(urldecode($_GET['ipv6_dhcp_stateful']), FILTER_SANITIZE_STRING) : "";
  $ipv6_firewall = (isset($_GET['ipv6_firewall'])) ? filter_var(urldecode($_GET['ipv6_firewall']), FILTER_SANITIZE_STRING) : "";
  $ipv6_gateway = (isset($_GET['ipv6_gateway'])) ? filter_var(urldecode($_GET['ipv6_gateway']), FILTER_SANITIZE_STRING) : "";
  $ipv6_nat = (isset($_GET['ipv6_nat'])) ? filter_var(urldecode($_GET['ipv6_nat']), FILTER_SANITIZE_STRING) : "";
  $ipv6_nat_address = (isset($_GET['ipv6_nat_address'])) ? filter_var(urldecode($_GET['ipv6_nat_address']), FILTER_SANITIZE_STRING) : "";
  $ipv6_nat_order = (isset($_GET['ipv6_nat_order'])) ? filter_var(urldecode($_GET['ipv6_nat_order']), FILTER_SANITIZE_STRING) : "";
  $ipv6_ovn_ranges = (isset($_GET['ipv6_ovn_ranges'])) ? filter_var(urldecode($_GET['ipv6_ovn_ranges']), FILTER_SANITIZE_STRING) : "";
  $ipv6_routes = (isset($_GET['ipv6_routes'])) ? filter_var(urldecode($_GET['ipv6_routes']), FILTER_SANITIZE_STRING) : "";
  $ipv6_routes_anycast = (isset($_GET['ipv6_routes_anycast'])) ? filter_var(urldecode($_GET['ipv6_routes_anycast']), FILTER_SANITIZE_STRING) : "";
  $ipv6_routing = (isset($_GET['ipv6_routing'])) ? filter_var(urldecode($_GET['ipv6_routing']), FILTER_SANITIZE_STRING) : "";
  $maas_subnet_ipv4 = (isset($_GET['maas_subnet_ipv4'])) ? filter_var(urldecode($_GET['maas_subnet_ipv4']), FILTER_SANITIZE_STRING) : "";
  $maas_subnet_ipv6 = (isset($_GET['maas_subnet_ipv6'])) ? filter_var(urldecode($_GET['maas_subnet_ipv6']), FILTER_SANITIZE_STRING) : "";
  $managed_only = (isset($_GET['managed_only'])) ? filter_var(urldecode($_GET['managed_only']), FILTER_SANITIZE_STRING) : "";
  $mtu = (isset($_GET['mtu'])) ? filter_var(urldecode($_GET['mtu']), FILTER_SANITIZE_STRING) : "";
  $name = (isset($_GET['name'])) ? filter_var(urldecode($_GET['name']), FILTER_SANITIZE_STRING) : "";
  $network = (isset($_GET['network'])) ? filter_var(urldecode($_GET['network']), FILTER_SANITIZE_STRING) : "";
  $ovn_ingress_mode = (isset($_GET['ovn_ingress_mode'])) ? filter_var(urldecode($_GET['ovn_ingress_mode']), FILTER_SANITIZE_STRING) : "";
  $parent = (isset($_GET['parent'])) ? filter_var(urldecode($_GET['parent']), FILTER_SANITIZE_STRING) : "";
  $project = (isset($_GET['project'])) ? filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING) : "";
  $raw_dnsmasq = (isset($_GET['raw_dnsmasq'])) ? filter_var(urldecode($_GET['raw_dnsmasq']), FILTER_SANITIZE_STRING) : "";
  $remote = (isset($_GET['remote'])) ? filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_NUMBER_INT) : "";
  $repo = (isset($_GET['repo'])) ? filter_var(urldecode($_GET['repo']), FILTER_SANITIZE_STRING) : "";
  $type = (isset($_GET['type'])) ? filter_var(urldecode($_GET['type']), FILTER_SANITIZE_STRING) : "";
  $vlan = (isset($_GET['vlan'])) ? filter_var(urldecode($_GET['vlan']), FILTER_SANITIZE_STRING) : "";
  
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

    case "createNetworkUsingForm":
      $url = $base_url . "/1.0/networks?project=" . $project;
      $device_array = array();
      $device_array['name'] = $name;
      $device_array['type'] = $type;
      $device_array['description'] = $description;

      if ($type == "bridge"){
        if (!empty($bridge_driver)){ $device_array['config']['bridge.driver'] = $bridge_driver;}
        if (!empty($bridge_external_interfaces)){ $device_array['config']['bridge.external_interfaces'] = $bridge_external_interfaces;}
        if (!empty($bridge_hwaddr)){ $device_array['config']['bridge.hwaddr'] = $bridge_hwaddr;}
        if (!empty($bridge_mode)){ $device_array['config']['bridge.mode'] = $bridge_mode;}
        if (!empty($bridge_mtu)){ $device_array['config']['bridge.mtu'] = $bridge_mtu;}
        if (!empty($dns_domain)){ $device_array['config']['dns.domain'] = $dns_domain;}
        if (!empty($dns_mode)){ $device_array['config']['dns.mode'] = $dns_mode;}
        if (!empty($dns_search)){ $device_array['config']['dns.search'] = $dns_search;}
        if (!empty($fan_overlay_subnet)){ $device_array['config']['fan.overlay_subnet'] = $fan_overlay_subnet;}
        if (!empty($fan_type)){ $device_array['config']['fan.type'] = $fan_type;}
        if (!empty($fan_underlay_subnet)){ $device_array['config']['fan.underlay_subnet'] = $fan_underlay_subnet;}
        if (!empty($ipv4_address)){ $device_array['config']['ipv4.address'] = $ipv4_address;}
        if (!empty($ipv4_dhcp)){ $device_array['config']['ipv4.dhcp'] = $ipv4_dhcp;}
        if (!empty($ipv4_dhcp_expiry)){ $device_array['config']['ipv4.dhcp.expiry'] = $ipv4_dhcp_expiry;}
        if (!empty($ipv4_dhcp_gateway)){ $device_array['config']['ipv4.dhcp.gateway'] = $ipv4_dhcp_gateway;}
        if (!empty($ipv4_dhcp_ranges)){ $device_array['config']['ipv4.dhcp.ranges'] = $ipv4_dhcp_ranges;}
        if (!empty($ipv4_firewall)){ $device_array['config']['ipv4.firewall'] = $ipv4_firewall;}
        if (!empty($ipv4_nat_address)){ $device_array['config']['ipv4.nat.address'] = $ipv4_nat_address;}
        if (!empty($ipv4_nat)){ $device_array['config']['ipv4.nat'] = $ipv4_nat;}
        if (!empty($ipv4_nat_order)){ $device_array['config']['ipv4.nat.order'] = $ipv4_nat_order;}
        if (!empty($ipv4_ovn_ranges)){ $device_array['config']['ipv4.ovn.ranges'] = $ipv4_ovn_ranges;}
        if (!empty($ipv4_routes)){ $device_array['config']['ipv4.routes'] = $ipv4_routes;}
        if (!empty($ipv4_routing)){ $device_array['config']['ipv4.routing'] = $ipv4_routing;}
        if (!empty($ipv6_address)){ $device_array['config']['ipv6.address'] = $ipv6_address;}
        if (!empty($ipv6_dhcp)){ $device_array['config']['ipv6.dhcp'] = $ipv6_dhcp;}
        if (!empty($ipv6_dhcp_expiry)){ $device_array['config']['ipv6.dhcp.expiry'] = $ipv6_dhcp_expiry;}
        if (!empty($ipv6_dhcp_ranges)){ $device_array['config']['ipv6.dhcp.ranges'] = $ipv6_dhcp_ranges;}
        if (!empty($ipv6_dhcp_stateful)){ $device_array['config']['ipv6.dhcp.stateful'] = $ipv6_dhcp_stateful;}
        if (!empty($ipv6_firewall)){ $device_array['config']['ipv6.firewall'] = $ipv6_firewall;}
        if (!empty($ipv6_nat_address)){ $device_array['config']['ipv6.nat.address'] = $ipv6_nat_address;}
        if (!empty($ipv6_nat)){ $device_array['config']['ipv6.nat'] = $ipv6_nat;}
        if (!empty($ipv6_nat_order)){ $device_array['config']['ipv6.nat.order'] = $ipv6_nat_order;}
        if (!empty($ipv6_ovn_ranges)){ $device_array['config']['ipv6.ovn.ranges'] = $ipv6_ovn_ranges;}
        if (!empty($ipv6_routes)){ $device_array['config']['ipv6.routes'] = $ipv6_routes;}
        if (!empty($ipv6_routing)){ $device_array['config']['ipv6.routing'] = $ipv6_routing;}
        if (!empty($maas_subnet_ipv4)){ $device_array['config']['maas.subnet.ipv4'] = $maas_subnet_ipv4;}
        if (!empty($maas_subnet_ipv6)){ $device_array['config']['maas.subnet.ipv6'] = $maas_subnet_ipv6;}
        if (!empty($raw_dnsmasq)){ $device_array['config']['raw.dnsmasq'] = $raw_dnsmasq;}
      }
      if ($type == "macvlan" || $type == "sriov"){
        if (!empty($maas_subnet_ipv4)){ $device_array['config']['maas.subnet.ipv4'] = $maas_subnet_ipv4;}
        if (!empty($maas_subnet_ipv6)){ $device_array['config']['maas.subnet.ipv6'] = $maas_subnet_ipv6;}
        if (!empty($mtu)){ $device_array['config']['mtu'] = $mtu;}
        if (!empty($parent)){ $device_array['config']['parent'] = $parent;}
        if (!empty($vlan)){ $device_array['config']['vlan'] = $vlan;}
      }

      if ($type == "ovn"){
        if (!empty($bridge_hwaddr)){ $device_array['config']['bridge.hwaddr'] = $bridge_hwaddr;}
        if (!empty($bridge_mtu)){ $device_array['config']['bridge.mtu'] = $bridge_mtu;}
        if (!empty($dns_domain)){ $device_array['config']['dns.domain'] = $dns_domain;}
        if (!empty($dns_search)){ $device_array['config']['dns.search'] = $dns_search;}
        if (!empty($ipv4_address)){ $device_array['config']['ipv4.address'] = $ipv4_address;}
        if (!empty($ipv4_dhcp)){ $device_array['config']['ipv4.dhcp'] = $ipv4_dhcp;}
        if (!empty($ipv4_nat)){ $device_array['config']['ipv4.nat'] = $ipv4_nat;}
        if (!empty($ipv6_address)){ $device_array['config']['ipv6.address'] = $ipv6_address;}
        if (!empty($ipv6_dhcp)){ $device_array['config']['ipv6.dhcp'] = $ipv6_dhcp;}
        if (!empty($ipv6_dhcp_stateful)){ $device_array['config']['ipv6.dhcp.stateful'] = $ipv6_dhcp_stateful;}
        if (!empty($ipv6_nat)){ $device_array['config']['ipv6.nat'] = $ipv6_nat;}
        if (!empty($network)){ $device_array['config']['network'] = $network;}
      }

      if ($type == "physical"){
        if (!empty($maas_subnet_ipv4)){ $device_array['config']['maas.subnet.ipv4'] = $maas_subnet_ipv4;}
        if (!empty($maas_subnet_ipv6)){ $device_array['config']['maas.subnet.ipv6'] = $maas_subnet_ipv6;}
        if (!empty($mtu)){ $device_array['config']['mtu'] = $mtu;}
        if (!empty($parent)){ $device_array['config']['parent'] = $parent;}
        if (!empty($vlan)){ $device_array['config']['vlan'] = $vlan;}
        if (!empty($ipv4_gateway)){ $device_array['config']['ipv4.gateway'] = $ipv4_gateway;}
        if (!empty($ipv4_ovn_ranges)){ $device_array['config']['ipv4.ovn.ranges'] = $ipv4_ovn_ranges;}
        if (!empty($ipv4_routes)){ $device_array['config']['ipv4.routes'] = $ipv4_routes;}
        if (!empty($ipv4_routes_anycast)){ $device_array['config']['ipv4.routes.anycast'] = $ipv4_routes_anycast;}
        if (!empty($ipv6_gateway)){ $device_array['config']['ipv6.gateway'] = $ipv6_gateway;}
        if (!empty($ipv6_ovn_ranges)){ $device_array['config']['ipv6.ovn.ranges'] = $ipv6_ovn_ranges;}
        if (!empty($ipv6_routes)){ $device_array['config']['ipv6.routes'] = $ipv6_routes;}
        if (!empty($ipv6_routes_anycast)){ $device_array['config']['ipv6.routes.anycast'] = $ipv6_routes_anycast;}
        if (!empty($dns_nameservers)){ $device_array['config']['dns.nameservers'] = $dns_nameservers;}
        if (!empty($ovn_ingress_mode)){ $device_array['config']['ovn.ingress_mode'] = $ovn_ingress_mode;}
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

    case "createNetworkUsingJSON":
      $url = $base_url . "/1.0/networks?project=" . $project;
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

    case "deleteNetwork":
      $url = $base_url . "/1.0/networks/" . $network . "?project=" . $project;
      $results = sendCurlRequest($action, "DELETE", $url);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $network;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "listNetworks":
      if (validateAuthorization($action)) {
        $url = $base_url . "/1.0/networks?recursion=1&project=" . $project;
        $results = sendCurlRequest($action, "GET", $url);
        $results = json_decode($results, true);
        $networks = (isset($results['metadata'])) ? $results['metadata'] : [];

        $i = 0;
        echo '{ "data": [';

        foreach ($networks as $network){
          
          if ($network['name'] == "")
            continue;

          $network_data_managed = ($network['managed']) ? "true" : "false";

          //This array key is not availabe on unmanaged network devices
          if (isset($network['config']['ipv4.address']))
            $ipv4 = $network['config']['ipv4.address'];
          else
            $ipv4 = "";

          //This array key is not available on unmanaged network devices
          if (isset($network['config']['ipv6.address']))
            $ipv6 = $network['config']['ipv6.address'];
          else
            $ipv6 = "";

          if ($i > 0){
            echo ",";
          }
          $i++;

          echo "[ ";

          if ($network['managed'] == "true"){
            echo '"' . "<i class='fas fa-network-wired fa-lg' style='color:#4e73df'></i>" . '",';
            echo '"' . htmlentities($network['name']) . '",';
          }
          else {
            echo '"' . "<i class='fas fa-network-wired fa-lg' style='color:#ddd'></i>" . '",';
            echo '"' . htmlentities($network['name']) . '",';
          }

          echo '"' . htmlentities($network['description']) . '",';
          echo '"' . htmlentities($ipv4) . '",';
          echo '"' . htmlentities($ipv6) . '",';
          echo '"' . htmlentities($network['type']) . '",';
          echo '"' . htmlentities($network_data_managed) . '",';

          echo '"';
          if ($network['managed'] == "true"){
            echo "<a href='#' onclick=loadNetworkJson('".$network['name']."')><i class='fas fa-edit fa-lg' style='color:#ddd' title='Edit' aria-hidden='true'></i></a>";
            echo " &nbsp ";
            echo "<a href='#' onclick=loadRenameNetwork('".$network['name']."')><i class='fas fa-tag fa-lg' style='color:#ddd' title='Rename' aria-hidden='true'></i></a>";
            echo " &nbsp ";
            echo "<a href='#' onclick=deleteNetwork('".$network['name']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
          }
          echo '"';

          echo " ]";

        }

        echo " ]}";
      }
      else {
        echo '{ "data": [] }';
      }      
      break;

    case "listNetworksForSelectOption":
      if (validateAuthorization($action)) {
        $url = $base_url . "/1.0/networks?recursion=1&project=" . $project;
        $results = sendCurlRequest($action, "GET", $url);
        $results = json_decode($results, true);
        $networks = (isset($results['metadata'])) ? $results['metadata'] : [];
        $i = 0;
        foreach ($networks as $network){
          
          if ($managed_only == "true"){
            if ($type != ""){
              if ($network['managed'] == "true" && $network['type'] == $type){
                echo '<option value="' . $network['name'] . '">' . htmlentities($network['name']) . '</option>';
                $i++;
              }
            }
            else{
              if ($network['managed'] == "true"){
                echo '<option value="' . $network['name'] . '">' . htmlentities($network['name']) . '</option>';
                $i++;
              }
            }
          }
          else {
            echo '<option value="' . $network['name'] . '">' . htmlentities($network['name']) . '</option>';
            $i++;
          }
        }
        if ($i == 0){
          echo '<option value="">(No networks available)</option>';
        }
      }     
      break;

    case "loadNetwork":
      $url = $base_url . "/1.0/networks/" . $network . "?project=" . $project;
      $results = sendCurlRequest($action, "GET", $url);
      echo $results;
      break;

    case "renameNetwork":
      $url = $base_url . "/1.0/networks/" . $network . "?project=" . $project;
      $data = '{"name": "' . $name . '"}';
      $results = sendCurlRequest($action, "POST", $url, $data);
      echo $results;

      //Send event to accounting
      $event = json_decode($results, true);
      $object = $network . " - " . $name;
      if ($event['error_code'] == 0){
        logEvent($action, $remote, $project, $object, $event['status_code'], $event['status']);
      }
      else {
        logEvent($action, $remote, $project, $object, $event['error_code'], $event['error']);
      }
      break;

    case "updateNetwork":
      $url = $base_url . "/1.0/networks/" . $network . "?project=" . $project;
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
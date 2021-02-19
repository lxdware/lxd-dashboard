<?php

if (!empty($_SERVER['PHP_AUTH_USER'])) {

  $cert = "/var/lxdware/data/lxd/client.crt";
  $key = "/var/lxdware/data/lxd/client.key";

  //Instantiate the GET variables
  if (isset($_GET['remote']))
    $remote = filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_STRING);
  if (isset($_GET['project']))
    $project = filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING);
  if (isset($_GET['instance']))
    $instance = filter_var(urldecode($_GET['instance']), FILTER_SANITIZE_STRING);


  //Determine host info from database
  $db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
  $db_statement = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
  $db_statement->bindValue(':id', $remote);
  $db_results = $db_statement->execute();

  while($row = $db_results->fetchArray()){
    $url = "https://" . $row['host'] . ":" . $row['port'];

    //Instance State
    $url = $url . "/1.0/instances/".$instance."/state?project=" . $project;
    $instance_api_state = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET '$url'");
    $instance_api_state = json_decode($instance_api_state, true);
    $instance_state = $instance_api_state['metadata'];

    $pid = $instance_state['pid']?: "N/A"; //process ID on the host
    $processes = $instance_state['processes']?: "N/A"; //number of process running in container
    $cpu = $instance_state['cpu']['usage']; //cpu usage in nanoseconds

    if ($instance_state['memory']['usage'] < 1073741824){
      $memory = number_format($instance_state['memory']['usage']/1024/1024, 2);//total amount of memory used in MB
      $memory_unit = "MB";
    }
    else {
      $memory = number_format($instance_state['memory']['usage']/1024/1024/1024, 2);//total amount of memory used in GB
      $memory_unit = "GB";
    }

    $network_interfaces = $instance_state['network']; //array of networks

    //echo "<strong>CPU Usage</strong>: " . htmlentities($cpu) . " nanoseconds<br />";
    echo "<strong>Memory</strong>: " . htmlentities($memory) . " " . $memory_unit . "<br />";
    echo "<strong>PID</strong>: " . htmlentities($pid) . "<br />";
    echo "<strong>Processes</strong>: " . htmlentities($processes) . "<br />";

    echo "<strong>IPv4 Addresses</strong>: ";
    $i = 0;
    if (!$network_interfaces)
    echo "N/A";
    foreach ($network_interfaces as $network_interface){
      foreach ($network_interface['addresses'] as $address){
        if ($address['family'] == "inet" && $address['scope'] == "global"){
          if ($i > 0)
            echo ", ";
          echo htmlentities($address['address']) . "/" . htmlentities($address['netmask']);
          $i++;
        }
      }
    }
    echo "<br />";
    
    echo "<strong>IPv6 Addresses</strong>: ";
    $i = 0;
    if (!$network_interfaces)
      echo "N/A";
    foreach ($network_interfaces as $network_interface){
      foreach ($network_interface['addresses'] as $address){
        if ($address['family'] == "inet6" && $address['scope'] == "global"){
          if ($i > 0)
            echo ", ";
          echo htmlentities($address['address']);
          $i++;
        }
      }
    }
    echo "<br />";
    
  }

}
?>
<?php

if (!empty($_SERVER['PHP_AUTH_USER'])) {

  $cert = "/var/lxdware/data/lxd/client.crt";
  $key = "/var/lxdware/data/lxd/client.key";

  if (isset($_GET['remote']))
    $remote = filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_STRING);
  if (isset($_GET['project']))
    $project = filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING);
  if (isset($_GET['instance']))
    $instance = filter_var(urldecode($_GET['instance']), FILTER_SANITIZE_STRING);

  echo "<thead>";
  echo "<tr>";
  echo "<th style='width:75px'></th>";
  echo "<th>Name</th>";
  echo "<th>Path</th>";
  echo "<th>Usage</th>";
  echo "<th>Type</th>";
  echo "</tr>";
  echo "</thead>";

  echo "<tbody>";

  //Determine host info from database
  $db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
  $db_statement = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
  $db_statement->bindValue(':id', $remote);
  $db_results = $db_statement->execute();

  while($row = $db_results->fetchArray()){

    //Retrieve Instance State information to get disk usage stats
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/instances/" . $instance . "/state?project=" . $project;
    $remote_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET '$url'");
    $remote_data = json_decode($remote_data, true);
    if (isset($remote_data['metadata']['disk'])){
      $disk_names = $remote_data['metadata']['disk'];
    }

    //Retrieve Expanded Device information to get a list of disks
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/instances/" . $instance . "?project=" . $project;
    $remote_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET '$url'");
    $remote_data = json_decode($remote_data, true);
    if (isset($remote_data['metadata']['expanded_devices'])){
      $device_names = $remote_data['metadata']['expanded_devices'];

      //Loop through the expanded devices
      foreach ($device_names as $device_name => $device_data){
        $disk_path = $device_data['path'];
        $disk_type = $device_data['type'];
        $disk_usage = "";
        $disk_unit = "";
        
        //Proceed only if a disk device
        if ($disk_type == "disk"){

          //Determine if there is usage data available for disk device
          if (isset($disk_names)){
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
                $disk_usage = round($disk_usage,2);
              }
            }
          }
          echo "<tr>";
          echo "<td> <i class='fas fa-hdd fa-lg' style='color:#4e73df'></i> </td>";
          echo "<td>" . htmlentities($device_name) . "</td>";
          echo "<td>" . htmlentities($disk_path) . "</td>";
          echo "<td>" . htmlentities($disk_usage) . " " . $disk_unit . "</td>";
          echo "<td>" . htmlentities($disk_type) . "</td>";
          echo "</tr>";
        }

      }
    }

  
        
  }
    



  echo "</tbody>";

}
?>
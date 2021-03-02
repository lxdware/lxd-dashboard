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
  echo "<th>Connect</th>";
  echo "<th>Listen</th>";
  echo "<th>Type</th>";
  echo "<th style='width:150px'></th>";
  echo "</tr>";
  echo "</thead>";

  echo "<tbody>";

  //Determine host info from database
  $db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
  $db_statement = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
  $db_statement->bindValue(':id', $remote);
  $db_results = $db_statement->execute();

  while($row = $db_results->fetchArray()){

    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/instances/" . $instance . "?project=" . $project;
    $remote_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET '$url'");
    $remote_data = json_decode($remote_data, true);

    if (isset($remote_data['metadata']['expanded_devices'])){
      $device_names = $remote_data['metadata']['expanded_devices'];
      
      foreach ($device_names as $device_name => $device_data){
        if ($device_data['type'] == "proxy"){
          echo "<tr>";
  
          echo "<td> <i class='fas fa-exchange-alt fa-lg' style='color:#4e73df'></i> </td>";
          echo "<td>" . htmlentities($device_name) . "</td>";
          echo "<td>" . htmlentities($device_data['connect']) . "</td>";
          echo "<td>" . htmlentities($device_data['listen']) . "</td>";
          echo "<td>" . htmlentities($device_data['type']) . "</td>";
          
          echo "<td>";
            //echo '<a href="#" onclick="detachProfile('.escapeshellarg($device_name).')"><i class="fas fa-trash-alt fa-lg" style="color:#ddd"></i></a>';
          echo "</td>";
          
          echo "</tr>";
        }
        else {
          continue;
        }
      }
    }
    
  }

  echo "</tbody>";

}

?>
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
  echo "<th>Hardware Address</th>";
  echo "<th>IPv4 Address</th>";
  echo "<th>IPv6 Address</th>";
  echo "<th>State</th>";
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
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/instances/" . $instance . "/state?recursion=1&project=" . $project;
    $remote_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $remote_data = json_decode($remote_data, true);
    $networks = $remote_data['metadata']['network'];

    foreach ($networks as $network => $network_data){

      echo "<tr>";
      if ($network_data['state'] == "up")
        echo "<td> <i class='fas fa-network-wired fa-lg' style='color:#4e73df'></i> </td>";
      else
        echo "<td> <i class='fas fa-network-wired fa-lg' style='color:#ddd'></i> </td>";
      echo "<td>" . htmlentities($network) . "</td>";
      echo "<td>" . htmlentities($network_data['hwaddr']) . "</td>";

      echo "<td>";
      $i = 0;
      foreach ($network_data['addresses'] as $address){
        if ($address['family'] == "inet"){
          if ($i > 0)
            echo "<br />";
          echo htmlentities($address['address']) . "/" . htmlentities($address['netmask']);
          $i++;
        }
      }
      echo "</td>";

      echo "<td>";
      $i = 0;
      foreach ($network_data['addresses'] as $address){
        if ($address['family'] == "inet6"){
          if ($i > 0)
            echo "<br />";
          echo htmlentities($address['address']);
          $i++;
        }
      }
      echo "</td>";

      echo "<td>" . htmlentities($network_data['state']) . "</td>";

      echo "<td>";
        //echo '<a href="#" onclick="detachProfile('.escapeshellarg($network).')"><i class="fas fa-trash-alt fa-lg" style="color:#ddd"></i></a>';
      echo "</td>";
      
      echo "</tr>";

    }
  }

  echo "</tbody>";

}

?>
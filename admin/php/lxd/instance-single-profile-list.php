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
  echo "<th>Description</th>";
  echo "<th style='width:150px'>Actions</th>";
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

    if (isset($remote_data['metadata']['profiles'])){
      $profile_names = $remote_data['metadata']['profiles'];
      
      foreach ($profile_names as $profile_name){
        $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/profiles/" . $profile_name . "?project=" . $project;
        $profile_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET '$url'");
        $profile_data = json_decode($profile_data, true);
        $profile_data = $profile_data['metadata'];
        if ($profile_data['name'] == "")
        continue;
  
  
        echo "<tr>";
  
        echo "<td> <i class='fas fa-address-card fa-lg' style='color:#4e73df'></i> </td>";
        echo "<td>" . htmlentities($profile_data['name']) . "</td>";
        echo "<td>" . htmlentities($profile_data['description']) . "</td>";
  
        echo "<td>";
          echo '<a href="#" onclick="detachProfile('.escapeshellarg($profile_data['name']).')"><i class="fas fa-trash-alt fa-lg" style="color:#ddd" title="Detach" aria-hidden="true"></i></a>';
        echo "</td>";
        
        echo "</tr>";
  
      }
    }

  }

  echo "</tbody>";

}

?>
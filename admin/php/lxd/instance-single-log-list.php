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

  echo "<thead>";
  echo "<tr>";
  echo "<th style='width:75px'></th>";
  echo "<th>Name</th>";
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
    $url = "https://" . $row['host'] . ":" . $row['port'];

    //Instance Backups
    $url = $url . "/1.0/instances/" . $instance . "/logs?project=" . $project;
    $instance_api_logs = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $instance_api_logs = json_decode($instance_api_logs, true);
    $instance_logs = $instance_api_logs['metadata'];

    foreach ($instance_logs as $instance_log){

      echo "<tr>";

      echo "<td> <i class='fas fa-history fa-lg' style='color:#4e73df'></i> </td>";
      echo "<td>" . htmlentities($instance_log) . "</td>";

      echo "<td>";
        echo '<a href="#" onclick="loadLog('.escapeshellarg($instance_log).')"><i class="fas fa-file fa-lg" style="color:#ddd" title="Display" aria-hidden="true"></i></a>';
        echo ' &nbsp ';
        echo '<a href="#" onclick="deleteLog('.escapeshellarg($instance_log).')"><i class="fas fa-trash-alt fa-lg" style="color:#ddd" title="Delete" aria-hidden="true"></i></a>';
      echo "</td>";
      
      echo "</tr>";

    }
  }

  echo "</tbody>";

}
?>
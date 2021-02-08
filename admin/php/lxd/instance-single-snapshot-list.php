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
  echo "<th>Stateful/Stateless</th>";
  echo "<th>Size</th>";
  echo "<th>Created At</th>";
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
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/instances/" . $instance . "/snapshots?recursion=1&project=" . $project;
    $remote_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET '$url'");
    $remote_data = json_decode($remote_data, true);
    $snapshots = $remote_data['metadata'];

    foreach ($snapshots as $snapshot){

      if ($snapshot['name'] == "")
      continue;

      if ($snapshot['stateful'])
        $state = "stateful";
      else
        $state = "stateless";

      echo "<tr>";

      echo "<td> <i class='fas fa-clone fa-lg' style='color:#4e73df'></i> </td>";
      echo "<td>" . htmlentities($snapshot['name']) . "</td>";
      echo "<td>" . htmlentities($state) . "</td>";
      echo "<td>" . htmlentities(number_format($snapshot['size']/1024/1024,2)) . "MB</td>";
      echo "<td>" . htmlentities($snapshot['created_at']) . "</td>";

      echo "<td>";
        echo '<a href="#" onclick="restoreSnapshot('.escapeshellarg($snapshot['name']).')"><i class="fas fa-window-restore fa-lg" style="color:#ddd" title="Restore Snapshot" aria-hidden="true"></i></a>';
        echo ' &nbsp ';
        echo '<a href="#" onclick="loadCreateInstanceFromSnapshotModal('.escapeshellarg($snapshot['name']).')"><i class="fas fa-cube fa-lg" style="color:#ddd" title="Create Instance" aria-hidden="true"></i></a>';
        echo ' &nbsp ';
        echo '<a href="#" onclick="loadPublishImageFromSnapshotModal('.escapeshellarg($snapshot['name']).')"><i class="fas fa-box-open fa-lg" style="color:#ddd" title="Publish Image" aria-hidden="true"></i></a>';
        echo ' &nbsp ';
        echo '<a href="#" onclick="deleteSnapshot('.escapeshellarg($snapshot['name']).')"><i class="fas fa-trash-alt fa-lg" style="color:#ddd" title="Delete" aria-hidden="true"></i></a>';
      echo "</td>";
      
      echo "</tr>";

    }
  }

  echo "</tbody>";

}

?>

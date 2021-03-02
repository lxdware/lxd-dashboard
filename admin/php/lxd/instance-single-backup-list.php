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
  echo "<th style='width:50px'></th>";
  echo "<th>Name</th>";
  echo "<th>Created</th>";
  echo "<th>Expires</th>";
  echo "<th>Instance Only</th>";
  echo "<th>Optimized Storage</th>";
  echo "<th>Local Export</th>";
  echo "<th style='width:100px'>Actions</th>";
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
    $url = $url . "/1.0/instances/" . $instance . "/backups?recursion=1&project=" . $project;
    $instance_api_backups = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET '$url'");
    $instance_api_backups = json_decode($instance_api_backups, true);

    if (isset($instance_api_backups['metadata'])){
      $instance_backups = $instance_api_backups['metadata'];

      foreach ($instance_backups as $instance_backup){
  
        $instance_only = ($instance_backup['instance_only'])?"true":"false";
        $container_only = ($instance_backup['container_only'])?"true":"false";
        $optimized_storage = ($instance_backup['optimized_storage'])?"true":"false";
        $file = '/var/lxdware/backups/' . $row['host'] . '/' . $project . '/' . $instance . '/' . $instance_backup['name'];
    
        echo "<tr>";
  
        echo "<td> <i class='fas fa-save fa-lg' style='color:#4e73df'></i> </td>";
        echo "<td>" . htmlentities($instance_backup['name']) . "</td>";
        echo "<td>" . htmlentities($instance_backup['created_at']) . "</td>";
        echo "<td>" . htmlentities($instance_backup['expires_at']) . "</td>";
        echo "<td>" . htmlentities($instance_only) . "</td>";
        echo "<td>" . htmlentities($optimized_storage) . "</td>";
        if (file_exists($file)){
          $file_size = filesize($file);
          $unit_size = "bytes";
          if ($file_size >= 1024){
            $file_size = $file_size / 1024;
            $unit_size = "KB";
          }
          if ($file_size >= 1024){
            $file_size = $file_size / 1024;
            $unit_size = "MB";
          }
          if ($file_size >= 1024){
            $file_size = $file_size / 1024;
            $unit_size = "GB";
          }
          if ($file_size >= 1000){
            $file_size = $file_size / 1024;
            $unit_size = "TB";
          }
          echo '<td> <a href="./php/lxd/instances.php?remote='.$remote.'&project='.$project.'&instance='.$instance.'&name='.$instance_backup['name'].'&action=downloadExportFile">'.htmlentities(basename($file)).'</a> ('.number_format($file_size,0).' '.$unit_size.')</td>';
        }
        else{
          echo "<td></td>";
        }
       
        echo "<td>";
          echo '<a href="#" onclick="exportBackup('.escapeshellarg($instance_backup['name']).')"><i class="fas fa-file-export fa-lg" style="color:#ddd" title="Export to local file" aria-hidden="true"></i></a>';
          echo ' &nbsp ';
          echo '<a href="#" onclick="deleteBackup('.escapeshellarg($instance_backup['name']).')"><i class="fas fa-trash-alt fa-lg" style="color:#ddd" title="Delete" aria-hidden="true"></i></a>';
        echo "</td>";
        
        echo "</tr>";
  
      }
    }


  }

  echo "</tbody>";

}
?>
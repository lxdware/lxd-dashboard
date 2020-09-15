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


  $db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
  $db_statement = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
  $db_statement->bindValue(':id', $remote);
  $db_results = $db_statement->execute();

  while($row = $db_results->fetchArray()){

    //Instance Data
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/instances/" . $instance . "?project=" . $project;
    $instance_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $instance_data = json_decode($instance_data, true);
    $instance_data = $instance_data['metadata'];

    //Instance State
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/instances/" . $instance . "/state?project=" . $project;
    $instance_state = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $instance_state = json_decode($instance_state, true);
    $instance_state = $instance_state['metadata'];

    //Instance Logs
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/instances/" . $instance . "/logs?project=" . $project;
    $instance_logs = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $instance_logs = json_decode($instance_logs, true);
    $instance_logs = $instance_logs['metadata'];

    //Instance Backups
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/instances/" . $instance . "/backups?project=" . $project;
    $instance_backups = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $instance_backups = json_decode($instance_backups, true);
    $instance_backups = $instance_backups['metadata'];


    $name = $instance_data['name'];
    $created = $instance_data['created_at'];
    $description = $instance_data['description'];
    $type = $instance_data['type'];
    $image = $instance_data['config']['image.description'];
    $status = $instance_data['status']; //ex Running
    $memory = number_format($instance_state['memory']['usage'] / 1048576, 2);
    $network_interfaces = $instance_state['network'];


    echo '<div class="row">';
      echo '<div class="col-xl-4 col-lg-4">';

      echo "<strong>Name</strong>: " . htmlentities($name) . "<br />";
      echo "<strong>Description</strong>: " . htmlentities($description) . "<br />";
      echo "<strong>Type</strong>: " . htmlentities($type) . "<br />";
      echo "<strong>Status</strong>: " . htmlentities($status) . "<br />";
      echo "<strong>Image</strong>: " . htmlentities($image) . "<br />";
      echo "<strong>Memory</strong>: " . htmlentities($memory) . " MB<br />";

      echo "<strong>IPv4 Addresses</strong>: ";
      $i = 0;
      foreach ($network_interfaces as $network_interface){
        foreach ($network_interface['addresses'] as $address){
          if ($address['family'] == "inet" && substr($address['address'],0,3) != 127){
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
      foreach ($network_interfaces as $network_interface){
        foreach ($network_interface['addresses'] as $address){
          if ($address['family'] == "inet6" && substr($address['address'],0,4) != "fe80" && $address['address'] != "::1"){
            if ($i > 0)
              echo ", ";
            echo htmlentities($address['address']);
            $i++;
          }
        }
      }
      echo "<br />";
    

      echo "<br />";
      echo '</div>';



      echo '<!-- Second Column -->';
      echo '<div class="col-xl-3 col-lg-3">';

      echo '<ul class="list-unstyled">';

      echo '<li class="media">';
      echo '<i class="mr-3 mb-5 fas fa-clipboard fa-2x fa-fw" style="color:#ddd"></i>';
      echo '<div class="media-body">';
      echo '<h6 class="mt-0 mb-1"><strong>Logs:</strong></h6>';
      $i = 0;
      foreach ($instance_logs as $log){
        if ($i > 0)
          echo ", ";
        echo "<a href='#' onclick=loadLog('".$log."')>".htmlentities(basename($log))."</a>";
        $i++;
      }
      echo '</div>';
      echo '</li>';

      echo '<li class="media">';
      echo '<i class="mr-3 mb-5 fas fa-file-archive fa-2x fa-fw" style="color:#ddd"></i>';
      echo '<div class="media-body">';
      echo '<h6 class="mt-0 mb-1"><strong>Backups:</strong></h6>';
      $i = 0;
      foreach ($instance_backups as $backup){
        if ($i > 0)
          echo ", ";
        echo "<a href='#' onclick=loadBackup('".$backup."')>".htmlentities(basename($backup))."</a>";
        $i++;
      }
      echo '</div>';
      echo '</li>';

      echo '</ul>';

      echo '</div>';



      echo '<!-- Third Column -->';
      echo '<div class="col-xl-5 col-lg-5">';
      
      echo '</div>';



    echo '</div>';

  }

}
?>


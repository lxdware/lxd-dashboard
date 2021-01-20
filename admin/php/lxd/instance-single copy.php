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

    //Instance Data 
    $data_url = $url . "/1.0/instances/".$instance."?project=" . $project;
    $instance_api_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $data_url");
    $instance_api_data = json_decode($instance_api_data, true);
    $instance_data = $instance_api_data['metadata'];

    //Instance State
    $state_url = $url . "/1.0/instances/".$instance."/state?project=" . $project;
    $instance_api_state = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $state_url");
    $instance_api_state = json_decode($instance_api_state, true);
    $instance_state = $instance_api_state['metadata'];


    $name = $instance_data['name']?: "N/A";
    $created = $instance_data['created_at']?: "N/A";
    $description = $instance_data['description']?: "N/A";
    $type = $instance_data['type']?: "N/A"; //ex container, virtual-machine
    $location = $instance_data['location']?: "N/A"; //used with clusters,none for non-clustered host
    $image = $instance_data['config']['image.description']?: "N/A"; //ex Ubuntu focal amd64 (20200821_07:42)
    $status = $instance_data['status']?: "N/A"; //ex Running
    $pid = $instance_state['pid']?: "N/A"; //process ID on the host
    $processes = $instance_state['processes']?: "N/A"; //number of process running in container
    //$cpu = $instance_state['cpu']['usage']; //cpu usage in nanoseconds

    if ($instance_state['memory']['usage'] < 1073741824){
      $memory = number_format($instance_state['memory']['usage']/1024/1024, 2);//total amount of memory used in MB
      $memory_unit = "MB";
    }
    else {
      $memory = number_format($instance_state['memory']['usage']/1024/1024/1024, 2);//total amount of memory used in GB
      $memory_unit = "GB";
    }

    $network_interfaces = $instance_state['network']; //array of networks

    //Instance Logs
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/instances/" . $instance . "/logs?project=" . $project;
    $instance_api_logs = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $instance_api_logs = json_decode($instance_api_logs, true);
    $instance_logs = $instance_api_logs['metadata'];

    //Instance Backups
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/instances/" . $instance . "/backups?project=" . $project;
    $instance_api_backups = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $instance_api_backups = json_decode($instance_api_backups, true);
    $instance_backups = $instance_api_backups['metadata'];


    echo '<div class="row">';
      echo '<div class="col-xl-4 col-lg-4">';

      echo "<strong>Name</strong>: " . htmlentities($name) . "<br />";
      echo "<strong>Description</strong>: " . htmlentities($description) . "<br />";
      echo "<strong>Type</strong>: " . htmlentities($type) . "<br />";
      echo "<strong>Status</strong>: " . htmlentities($status) . "<br />";
      echo "<strong>Image</strong>: " . htmlentities($image) . "<br />";
      echo "<strong>Location</strong>: " . htmlentities($location) . "<br />";
      echo "<strong>Memory</strong>: " . htmlentities($memory) . " " . $memory_unit . "<br />";
      echo "<strong>PID</strong>: " . htmlentities($pid) . "<br />";
      echo "<strong>Processes</strong>: " . htmlentities($processes) . "<br />";


      echo "<strong>IPv4 Addresses</strong>: ";
      $i = 0;
      if (!$network_interfaces)
      echo "N/A";
      foreach ($network_interfaces as $network_interface){
        if (count($network_interface['addresses']) == 0)
          echo "N/A";
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
        if (count($network_interface['addresses']) == 0)
          echo "N/A";
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
      if (count($instance_logs) == 0)
        echo "N/A";
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
      if (count($instance_backups) == 0)
        echo "N/A";
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
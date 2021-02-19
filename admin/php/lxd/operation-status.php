<?php

if (!empty($_SERVER['PHP_AUTH_USER'])) {

  //Instantiate the GET variables
  if (isset($_GET['remote']))
    $remote = filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_STRING);
  if (isset($_GET['project']))
    $project = filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING);
  if (isset($_GET['id']))
    $id = filter_var(urldecode($_GET['id']), FILTER_SANITIZE_STRING);

  $cert = "/var/lxdware/data/lxd/client.crt";
  $key = "/var/lxdware/data/lxd/client.key";

  $db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
  $db_statement = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
  $db_statement->bindValue(':id', $remote);
  $db_results = $db_statement->execute();

  while($row = $db_results->fetchArray()){
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/operations?recursion=1&project=" . $project;
    $operations_api_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET '$url'");
    $operations_api_data= json_decode($operations_api_data, true);
    $operations_data = $operations_api_data['metadata'];

    $results = "";

    if (!empty($operations_data)){

      if (!empty($operations_data['running'])){
        foreach ($operations_data['running'] as $running_task){
          $results =  $running_task['description'];
          $instance = basename($running_task['resources']['instances'][0]);

          switch($running_task['description']){
            case "Backing up container":
              $results .= " " . $instance; 
              break;
            case "Creating container":
              $results .= " " . $instance; 
              break;
            case "Creating instance":
              $results .= " " . $instance; 
              break;
            case "Deleting container":
              $results .= " " . $instance; 
              break;
            case "Deleting instance":
              $results .= " " . $instance; 
              break;
            case "Downloading image":
              $results .= " " . $running_task['metadata']['download_progress'];
              break;
            case "Executing command":
              $results = "Executing " . htmlentities($running_task['metadata']['command'][0]) . " command on " . htmlentities($instance);
              break;
            case "Freezing instance":
              $results .= " " . $instance;
              break;
            case "Migrating container":
              $results .= " " . $instance; 
              break;
            case "Restarting instance":
              $results .= " " . $instance;
              break;
            case "Restoring backup":
              $results .= " to instance " . $instance; 
              break;
            case "Showing console":
              $results = "Showing console of " . $instance; 
              break;
            case "Starting instance":
              $results .= " " . $instance; 
              break;
            case "Stopping instance":
              $results .= " " . $instance; 
              break;
            case "Updating instance":
              $results .= " " . $instance; 
              break;
          }
        }
      }

      if (!empty($operations_data['failure'])){
        foreach ($operations_data['failure'] as $failed_task){
          $results =  $failed_task['description'] . " Error: " . $failed_task['err'];
        }
      }
    
    }
  
  }
  echo $results;
}

?>
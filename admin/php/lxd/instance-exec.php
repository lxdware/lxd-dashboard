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
  if (isset($_GET['command']))
    $command = filter_var(urldecode($_GET['command']), FILTER_SANITIZE_ADD_SLASHES);

 //Determine host info from database
  $db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
  $db_statement = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
  $db_statement->bindValue(':id', $remote);
  $db_results = $db_statement->execute();

  while($row = $db_results->fetchArray()){
    $url = "https://" . $row['host'] . ":" . $row['port'];

    //Send the command using exec api and record the output to the instance logs
    $exec_url = $url. "/1.0/instances/" . $instance . "/exec?project=" . $project;
    $data = escapeshellarg('{ "command": ["/bin/sh", "-c", "' . $command . '"], "environment": {}, "wait-for-websocket": false, "record-output": true, "interactive": false, "width": 80, "height": 25, "user": 0, "group": 0, "cwd": "/"}');
    $exec_api_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X POST -d $data '$exec_url'");
    $exec_api_data = json_decode($exec_api_data, true);

    //Use the operation url to check the status of the command and wait up to 30 seconds for operation to complete to return data. Consider PHP timeout.
    $operation_url = $url . $exec_api_data['operation']. "/wait?project=".$project."&timeout=30";
    $exec_operation_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET '$operation_url'");
    $exec_operation_data = json_decode($exec_operation_data, true);
    $operation_data = $exec_operation_data['metadata'];

    //Determine status of api operation
    if ($operation_data['status_code'] == 200){
      //This means operation completed, but the command it executed may either be in stdout or stderr
      $return_value = $operation_data['metadata']['return']; //Similar to $? in bash
      $stdout_log_url = $url . $operation_data['metadata']['output']['1'] . "?project=".$project; //stdout log
      $stderr_log_url = $url . $operation_data['metadata']['output']['2'] . "?project=".$project; //stderr log

      //Store the data from both the stdout and stderr logs in variables
      $stdout = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET '$stdout_log_url'");
      $stderr = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET '$stderr_log_url'");

      //Display the contents
      echo $stdout;
      echo $stderr;

      //Delete the stdout and stderr logs
      $stdout_delete_log = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X DELETE '$stdout_log_url'");
      $stderr_delete_log = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X DELETE '$stderr_log_url'");   
    }
    if ($operation_data['status_code'] >= 400){
      //This means the operation did not execute the command, display the error
      echo $operation_data['err'];
      //Delete the the stdout and stderr logs
      $stdout_log_url = $url . "/1.0/instances/" . $instance . "/logs/exec_" . $operation_data['id'] . ".stdout?project=" . $project;
      $stderr_log_url = $url . "/1.0/instances/" . $instance . "/logs/exec_" . $operation_data['id'] . ".stderr?project=" . $project;
      $stdout_delete_log = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X DELETE '$stdout_log_url'");
      $stderr_delete_log = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X DELETE '$stderr_log_url'"); 
    }
   
    if ($operation_data['status_code'] < 200){
      if ($operation_data['status_code'] == 103){
        echo "The operating is still running and has taken longer than 30 seconds. \n";
        echo "You should see the status of you command when complete in the instance logs.";
      }
      else {
        echo "Interestingly, the status of your command is unknown";
      }
      
    }
  }

}
?>
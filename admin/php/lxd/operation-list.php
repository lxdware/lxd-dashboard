<?php

$cert = "/root/.config/lxc/client.crt";
$key = "/root/.config/lxc/client.key";

if (isset($_GET['remote']))
  $remote = filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_STRING);
if (isset($_GET['project']))
  $project = filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING);

$db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
$db_statement = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
$db_statement->bindValue(':id', $remote);
$db_results = $db_statement->execute();

while($row = $db_results->fetchArray()){
  $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/operations";
  $remote_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
  $remote_data = json_decode($remote_data, true);
  $operations_dict = $remote_data['metadata'];

  $i = 0;
  echo '{ "data": [';

  foreach ($operations_dict as $operations_url){


    foreach ($operations_url as $operation_url){
      $url = "https://" . $row['host'] . ":" . $row['port'] . $operation_url;
      $operation_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
      $operation_data = json_decode($operation_data, true);
      $operation_data = $operation_data['metadata'];

      if ($i > 0){
        echo ",";
      }
      $i++;
  
      echo "[ ";
      echo '"';
      echo "<a href='#' onclick=loadOperationJson('".$operation_data['id']."')> <i class='fas fa-exchange-alt fa-lg' style='color:#4e73df'></i> </a>";    
      echo '",';

      echo '"';
      echo "<a href='#' onclick=loadOperationJson('".$operation_data['id']."')>".htmlentities($operation_data['id'])."</a>";
      echo '",';

      echo '"' . htmlentities($operation_data['class']) . '",';
      echo '"' . htmlentities($operation_data['description']) . '",';
      echo '"' . htmlentities($operation_data['status']) . '",';
      echo '"' . htmlentities($operation_data['created_at']) . '",';

      if($operation_data['may_cancel']){
        $may_cancel = "true";
        echo '"' . htmlentities($may_cancel) . '",';

        echo '"';
        echo "<a href='#' onclick=deleteOperation('".$operation_data['id']."')> <i class='fas fa-stop fa-2x' style='color:#ddd'></i> </a>";
        echo '"';
      }
        
      else{
        $may_cancel = "false";
        echo '"' . htmlentities($may_cancel) . '",';
        echo '" ';
        echo ' "';
      }
       
    
      
      echo " ]";
  
    }
  
  }
    echo " ]}";
    
  

}

  
      
    



?>

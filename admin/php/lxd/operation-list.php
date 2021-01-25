<?php

if (!empty($_SERVER['PHP_AUTH_USER'])) {

  $cert = "/var/lxdware/data/lxd/client.crt";
  $key = "/var/lxdware/data/lxd/client.key";

  if (isset($_GET['remote']))
    $remote = filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_STRING);
  if (isset($_GET['project']))
    $project = filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING);

  $db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
  $db_statement = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
  $db_statement->bindValue(':id', $remote);
  $db_results = $db_statement->execute();

  while($row = $db_results->fetchArray()){
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/operations?recursion=1";
    $remote_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET $url");
    $remote_data = json_decode($remote_data, true);
    $operations_dict = $remote_data['metadata'];

    $i = 0;
    echo '{ "data": [';

    foreach ($operations_dict as $operations){


      foreach ($operations as $operation){

        if ($i > 0){
          echo ",";
        }
        $i++;
    
        echo "[ ";
        echo '"';
        echo "<a href='#' onclick=loadOperationJson('".$operation['id']."')> <i class='fas fa-exchange-alt fa-lg' style='color:#4e73df'></i> </a>";    
        echo '",';

        echo '"';
        echo "<a href='#' onclick=loadOperationJson('".$operation['id']."')>".htmlentities($operation['id'])."</a>";
        echo '",';

        echo '"' . htmlentities($operation['class']) . '",';
        echo '"' . htmlentities($operation['description']) . '",';
        echo '"' . htmlentities($operation['status']) . '",';
        echo '"' . htmlentities($operation['created_at']) . '",';

        if($operation['may_cancel']){
          $may_cancel = "true";
          echo '"' . htmlentities($may_cancel) . '",';

          echo '"';
          echo "<a href='#' onclick=deleteOperation('".$operation['id']."')> <i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i> </a>";
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

}
else {
  echo '{ "data": [] }';
}

?>

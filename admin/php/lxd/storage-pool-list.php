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
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/storage-pools?recursion=1&project=" . $project;
    $remote_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $remote_data = json_decode($remote_data, true);
    $storage_pools = $remote_data['metadata'];

    $i = 0;
    echo '{ "data": [';

    foreach ($storage_pools as $storage_pool){
      
      if ($storage_pool['name'] == "")
      continue;

      if ($i > 0){
        echo ",";
      }
      $i++;

      echo "[ ";
      echo '"';
      echo "<a href='storage-volumes.html?pool=".$storage_pool['name']."&remote=".$remote."&project=".$project."'><i class='fas fa-hdd fa-lg' style='color:#4e73df'></i> </a>";
      echo '",';

      echo '"';
      echo "<a href='storage-volumes.html?pool=".$storage_pool['name']."&remote=".$remote."&project=".$project."'> ".$storage_pool['name']."</a>";
      echo '",';

      echo '"' . htmlentities($storage_pool['description']) . '",';
      echo '"' . htmlentities($storage_pool['driver']) . '",';
      echo '"' . htmlentities($storage_pool['status']) . '",';
      echo '"' . htmlentities($storage_pool['config']['source']) . '",';
      echo '"' . htmlentities($storage_pool['config']['size']) . '",';

      echo '"';
        echo "<a href='#' onclick=loadStoragePoolJson('".$storage_pool['name']."')><i class='fas fa-edit fa-lg' style='color:#ddd' title='Edit' aria-hidden='true'></i></a>";
        echo " &nbsp ";
        echo "<a href='#' onclick=deleteStoragePool('".$storage_pool['name']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
      echo '"';

      echo " ]";

    }

    echo " ]}";
    
  }

}
else {
  echo '{ "data": [] }';
}

?>
<?php

if (!empty($_SERVER['PHP_AUTH_USER'])) {

  $cert = "/var/lxdware/data/lxd/client.crt";
  $key = "/var/lxdware/data/lxd/client.key";

  if (isset($_GET['remote']))
    $remote = filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_STRING);

  $db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
  $db_statement = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
  $db_statement->bindValue(':id', $remote);
  $db_results = $db_statement->execute();

  while($row = $db_results->fetchArray()){
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/cluster";
    $remote_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $remote_data = json_decode($remote_data, true);
    $cluster_status = $remote_data['metadata'];

    if ($cluster_status['enabled'] == false){
      echo '{ "data": [';
    }
    else {
      $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/cluster/members?recursion=1";
      $remote_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
      $remote_data = json_decode($remote_data, true);
      $members = $remote_data['metadata'];
    
      $i = 0;
      echo '{ "data": [';
    
      foreach ($members as $member){
    
        $database_status = ($member['database'])?"true":"false";
    
        if ($i > 0){
          echo ",";
        }
        $i++;
    
        echo "[ ";
        echo '"';
        echo "<i class='fas fa-project-diagram  fa-lg' style='color:#4e73df'></i>";
        echo '",';
        echo '"' . htmlentities($member['server_name']) . '",';
        echo '"' . htmlentities($member['url']) . '",';
        echo '"' . htmlentities($database_status) . '",';
        echo '"' . htmlentities($member['status']) . '",';
        echo '"' . htmlentities($member['message']) . '",';
    
    
        echo '"';
        echo '"';
    
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
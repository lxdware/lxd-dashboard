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
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/networks?recursion=1&project=" . $project;
    $remote_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET '$url'");
    $remote_data = json_decode($remote_data, true);
    $networks = $remote_data['metadata'];

    $i = 0;
    echo '{ "data": [';

    foreach ($networks as $network){
      
      if ($network['name'] == "")
      continue;

      $network_data_managed = ($network['managed'])?"true":"false";

      //This array key is not availabe on unmanaged network devices
      if (isset($network['config']['ipv4.address']))
        $ipv4 = $network['config']['ipv4.address'];
      else
        $ipv4 = "";

      //This array key is not available on unmanaged network devices
      if (isset($network['config']['ipv6.address']))
        $ipv6 = $network['config']['ipv6.address'];
      else
        $ipv6 = "";

      if ($i > 0){
        echo ",";
      }
      $i++;

      echo "[ ";

      if ($network['managed'] == "true"){
        echo '"' . "<a href='#' onclick=viewNetworkJson('".$network['name']."')><i class='fas fa-network-wired fa-lg' style='color:#4e73df'></i></a>" . '",';
        echo '"' . "<a href='#' onclick=viewNetworkJson('".$network['name']."')>".htmlentities($network['name'])."</a>" . '",';
      }
      else {
        echo '"' . "<i class='fas fa-network-wired fa-lg' style='color:#ddd'></i>" . '",';
        echo '"' . htmlentities($network['name']) . '",';
      }

      echo '"' . htmlentities($network['description']) . '",';
      echo '"' . htmlentities($ipv4) . '",';
      echo '"' . htmlentities($ipv6) . '",';
      echo '"' . htmlentities($network['type']) . '",';
      echo '"' . htmlentities($network_data_managed) . '",';

      echo '"';
      if ($network['managed'] == "true"){
        echo "<a href='#' onclick=loadNetworkJson('".$network['name']."')><i class='fas fa-edit fa-lg' style='color:#ddd' title='Edit' aria-hidden='true'></i></a>";
        echo " &nbsp ";
        echo "<a href='#' onclick=deleteNetwork('".$network['name']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
      }
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
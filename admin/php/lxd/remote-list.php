<?php

if (!empty($_SERVER['PHP_AUTH_USER'])) {

  $cert = "/var/lxdware/data/lxd/client.crt";
  $key = "/var/lxdware/data/lxd/client.key";

  $db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
  $db->busyTimeout(5000);

  $db_results = $db->query('SELECT * FROM lxd_hosts');

  if ($db_results != false){

    $i = 0;
    echo '{ "data": [';

    while ($row = $db_results->fetchArray()){

      if ($i > 0){
        echo ",";
      }
      $i++;

      echo "[ ";

      echo '"';
        echo "<a href='host.html?remote=" . $row['id'] . "&project=default'> <i class='fas fa-server fa-lg' style='color:#4e73df'></i> </a>";
      echo '",';

      echo '"';
        echo "<a href='host.html?remote=" . $row['id'] . "&project=default'>".htmlentities($row['host'])."</a>";
      echo '",';
      
      echo '"' . htmlentities($row['port']) . '",';
      echo '"' . htmlentities($row['alias']) . '",';
      echo '"' . htmlentities($row['protocol']) . '",';

      echo '"';
        echo "<a href='#' onclick=removeRemote('".$row['id']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd'></i></a>";
      echo '"';

      echo " ]";

    }
    echo " ]}";
  }

  $db->close();

}
else {
  echo '{ "data": [] }';
}

?>

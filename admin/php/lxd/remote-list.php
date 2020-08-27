<?php

$cert = "/root/.config/lxc/client.crt";
$key = "/root/.config/lxc/client.key";

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
      echo "<a href='host.html?remote=" . $row['id'] . "&project=default'> <i class='fas fa-archive fa-lg' style='color:#4e73df'></i> </a>";
    echo '",';

    echo '"';
      echo "<a href='host.html?remote=" . $row['id'] . "&project=default'>".htmlentities($row['host'])."</a>";
    echo '",';
    
    echo '"' . htmlentities($row['port']) . '",';
    echo '"' . htmlentities($row['alias']) . '",';
    echo '"' . htmlentities($row['protocol']) . '",';

    echo '"';
      echo "<div class='dropdown no-arrow'>";
      echo "<a class='dropdown-toggle' href='#' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
      echo "<i class='fas fa-ellipsis-v fa-sm fa-fw text-gray-400'></i>";
      echo "</a>";
      echo "<div class='dropdown-menu dropdown-menu-right shadow animated--fade-in' aria-labelledby='dropdownMenuLink'>";
      echo "<div class='dropdown-header'>Options:</div>";
      echo "<a class='dropdown-item' href='#' onclick=removeRemote('".$row['id']."')>Remove</a>";
      echo "</div>";
      echo "</div>";
    echo '"';

    echo " ]";

  }
  echo " ]}";
}

$db->close();

?>

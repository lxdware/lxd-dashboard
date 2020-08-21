<?php

//$cert = "/root/.config/lxc/client.crt";
//$key = "/root/.config/lxc/client.key";

$db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
$db_results = $db->query('SELECT * FROM lxd_simplestreams');

if($db_results != false){

  $i = 0;
  echo '{ "data": [';

  while($row = $db_results->fetchArray()){

    if ($i > 0){
      echo ",";
    }
    $i++;

    echo "[ ";
    echo '"';
    echo "<i class='fas fa-archive fa-lg' style='color:#4e73df'></i>";
    echo '",';
    echo '"' . htmlentities($row['host']) . '",';
    echo '"' . htmlentities($row['alias']) . '",';
    echo '"' . htmlentities($row['protocol']) . '",';


    echo '"';
      echo "<div class='dropdown no-arrow'>";
      echo "<a class='dropdown-toggle' href='#' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
      echo "<i class='fas fa-ellipsis-v fa-lg fa-fw text-gray-400'></i>";
      echo "</a>";
      echo "<div class='dropdown-menu dropdown-menu-right shadow animated--fade-in' aria-labelledby='dropdownMenuLink'>";
      echo "<div class='dropdown-header'>Options:</div>";
      echo "<a class='dropdown-item' href='#' onclick=removeSimplestreams('".$row['id']."')>Remove</a>";
      echo "</div>";
      echo "</div>";
    echo '"';

    echo " ]";

  }

  echo " ]}";
  
}

?>

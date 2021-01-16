<?php

if (!empty($_SERVER['PHP_AUTH_USER'])) {

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
        echo "<a href='#' onclick=removeSimplestreams('".$row['id']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd'></i></a>";
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

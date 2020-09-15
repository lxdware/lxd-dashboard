<?php

if (!empty($_SERVER['PHP_AUTH_USER'])) {

  $db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
  $db_results = $db->query('SELECT * FROM lxd_simplestreams');

  if ($db_results != false){
    while ($row = $db_results->fetchArray()){

      if ($row['alias'] != "")
        $host_display = $row['alias'];
      else 
        $host_display = $row['host'];

      echo '<option value="' . $row['host'] . '">' . htmlentities($host_display) . '</option>';

    }
  }
}
?>

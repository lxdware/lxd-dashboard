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
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/images?recursion=1&project=" . $project;
    $remote_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET '$url'");
    $remote_data = json_decode($remote_data, true);
    $images = $remote_data['metadata'];

    $i = 0;
    echo '{ "data": [';

    foreach ($images as $image){

      if ($image['fingerprint'] == "")
      continue;
      
      if ($i > 0){
        echo ",";
      }
      $i++;

      echo "[ ";
      
      echo '"' . "<a href='#' onclick=viewImageJson('".$image['fingerprint']."')><i class='fas fa-box-open fa-lg' style='color:#4e73df'></i></a>" . '",';
      echo '"' . "<a href='#' onclick=viewImageJson('".$image['fingerprint']."')>".htmlentities($image['properties']['description'])."</a>" . '",';
      echo '"' . htmlentities($image['fingerprint']) . '",';
      echo '"' . htmlentities($image['type']) . '",';
      echo '"' . htmlentities(number_format($image['size'] / 1048576, 2)) . ' MB",';

      echo '"';
        echo "<a href='#' onclick=refreshImage('".$image['fingerprint']."')><i class='fas fa-sync-alt fa-lg' style='color:#ddd' title='Refresh' aria-hidden='true'></i></a>";
        echo " &nbsp ";
        echo "<a href='#' onclick=loadImageJson('".$image['fingerprint']."')><i class='fas fa-edit fa-lg' style='color:#ddd' title='Edit' aria-hidden='true'></i></a>";
        echo " &nbsp ";
        echo "<a href='#' onclick=deleteImage('".$image['fingerprint']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
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
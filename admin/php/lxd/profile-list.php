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
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/profiles?recursion=1&project=" . $project;
    $remote_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET $url");
    $remote_data = json_decode($remote_data, true);
    $profiles = $remote_data['metadata'];

    $i = 0;
    echo '{ "data": [';

    foreach ($profiles as $profile){

      if ($profile['name'] == "")
      continue;
    
      if ($i > 0){
        echo ",";
      }
      $i++;

      echo "[ ";
      echo '"';
      echo "<i class='fas fa-address-card fa-lg' style='color:#4e73df'></i>";
      echo '",';
      echo '"' . htmlentities($profile['name']) . '",';
      echo '"' . htmlentities($profile['description']) . '",';

      echo '"';
        $ii = 0;
        foreach($profile['devices'] as $device=>$value){
          if ($ii > 0)
            echo ", ";
          echo $device;
          $ii++;
        }
      echo '",';

      echo '"';
        echo "<a href='#' onclick=loadProfileJson('".$profile['name']."')><i class='fas fa-edit fa-lg' style='color:#ddd' title='Edit' aria-hidden='true'></i></a>";
        echo " &nbsp ";
        echo "<a href='#' onclick=deleteProfile('".$profile['name']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
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
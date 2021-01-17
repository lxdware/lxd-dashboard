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
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/certificates?recursion=1&project=" . $project;
    $remote_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $remote_data = json_decode($remote_data, true);
    $certificates = $remote_data['metadata'];

    $i = 0;
    echo '{ "data": [';

    foreach ($certificates as $certificate){
      
      if ($i > 0){
        echo ",";
      }
      $i++;

      echo "[ ";
      echo '"';
      echo "<a href='#' onclick=loadCertificateJson('".$certificate['fingerprint']."')> <i class='fas fa-wallet fa-lg' style='color:#4e73df'></i> </a>";    
      echo '",';

      echo '"';
      echo "<a href='#' onclick=loadCertificateJson('".$certificate['fingerprint']."')>".htmlentities($certificate['name'])."</a>";
      echo '",';


      echo '"' . htmlentities($certificate['type']) . '",';
      echo '"' . htmlentities($certificate['fingerprint']) . '",';

      echo '"';
        echo "<a href='#' onclick=deleteCertificate('".$certificate['fingerprint']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
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
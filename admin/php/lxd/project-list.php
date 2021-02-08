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
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/projects?recursion=1";
    $remote_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET '$url'");
    $remote_data = json_decode($remote_data, true);
    $projects = $remote_data['metadata'];

    $i = 0;
    echo '{ "data": [';

    foreach ($projects as $project_data){

      if ($i > 0){
        echo ",";
      }
      $i++;

      echo "[ ";
      echo '"';
      echo "<a href='host.html?remote=".$remote."&project=".$project_data['name'] ."'><i class='fas fa-chart-bar fa-lg' style='color:#4e73df'></i> </a>";
      echo '",';

      echo '"';
      echo "<a href='host.html?remote=".$remote."&project=".$project_data['name'] ."'> ".htmlentities($project_data['name']) ."</a>";
      echo '",';

      echo '"' . htmlentities($project_data['description']) . '",';
      echo '"' . htmlentities($project_data['config']['features.images']) . '",';
      echo '"' . htmlentities($project_data['config']['features.profiles']) . '",';
      echo '"' . htmlentities($project_data['config']['features.storage.volumes']) . '",';

      echo '"';
        echo "<a href='#' onclick=loadProjectJson('".$project_data['name']."')><i class='fas fa-edit fa-lg' style='color:#ddd' title='Edit' aria-hidden='true'></i></a>";
        echo " &nbsp ";
        echo "<a href='#' onclick=deleteProject('".$project_data['name']."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete' aria-hidden='true'></i></a>";
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
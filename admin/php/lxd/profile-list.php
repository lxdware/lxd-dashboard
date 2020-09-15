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
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/profiles?project=" . $project;
    $remote_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $remote_data = json_decode($remote_data, true);
    $profile_urls = $remote_data['metadata'];

    $i = 0;
    echo '{ "data": [';

    foreach ($profile_urls as $profile_url){
      $url = "https://" . $row['host'] . ":" . $row['port'] . $profile_url . "?project=" . $project;
      $profile_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
      $profile_data = json_decode($profile_data, true);
      $profile_data = $profile_data['metadata'];

      if ($profile_data['name'] == "")
      continue;
    
      if ($i > 0){
        echo ",";
      }
      $i++;

      echo "[ ";
      echo '"';
      echo "<i class='fas fa-address-card fa-lg' style='color:#4e73df'></i>";
      echo '",';
      echo '"' . htmlentities($profile_data['name']) . '",';
      echo '"' . htmlentities($profile_data['description']) . '",';

      echo '"';
        $ii = 0;
        foreach($profile_data['devices'] as $device=>$value){
          if ($ii > 0)
            echo ", ";
          echo $device;
          $ii++;
        }
      echo '",';

      echo '"';
        echo "<div class='dropdown no-arrow'>";
        echo "<a class='dropdown-toggle' href='#' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
        echo "<i class='fas fa-ellipsis-v fa-sm fa-fw text-gray-400'></i>";
        echo "</a>";
        echo "<div class='dropdown-menu dropdown-menu-right shadow animated--fade-in' aria-labelledby='dropdownMenuLink'>";
        echo "<div class='dropdown-header'>Options:</div>";
        echo "<a class='dropdown-item' href='#' onclick=loadProfileJson('".$profile_data['name']."')>Edit</a>";
        echo "<a class='dropdown-item' href='#' onclick=deleteProfile('".$profile_data['name']."')>Delete</a>";
        echo "</div>";
        echo "</div>";
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
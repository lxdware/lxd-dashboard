<?php

$cert = "/root/.config/lxc/client.crt";
$key = "/root/.config/lxc/client.key";

if (isset($_GET['remote']))
  $remote = filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_STRING);
if (isset($_GET['project']))
  $project = filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING);

$db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
$db_statement = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
$db_statement->bindValue(':id', $remote);
$db_results = $db_statement->execute();

while($row = $db_results->fetchArray()){
  $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/images?project=" . $project;
  $remote_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
  $remote_data = json_decode($remote_data, true);
  $image_urls = $remote_data['metadata'];

  $i = 0;
  echo '{ "data": [';

  foreach ($image_urls as $image_url){
    $url = "https://" . $row['host'] . ":" . $row['port'] . $image_url . "?project=" . $project;
    $image_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $image_data = json_decode($image_data, true);
    $image_data = $image_data['metadata'];

    if ($image_data['fingerprint'] == "")
    continue;
    
    if ($i > 0){
      echo ",";
    }
    $i++;

    echo "[ ";
    echo '"';
    echo "<i class='fas fa-box-open fa-lg' style='color:#4e73df'></i>";
    echo '",';
    echo '"' . htmlentities($image_data['properties']['description']) . '",';
    echo '"' . htmlentities($image_data['fingerprint']) . '",';
    echo '"' . htmlentities($image_data['type']) . '",';
    echo '"' . htmlentities(number_format($image_data['size'] / 1048576, 2)) . ' MB",';

    echo '"';
      echo "<div class='dropdown no-arrow'>";
      echo "<a class='dropdown-toggle' href='#' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
      echo "<i class='fas fa-ellipsis-v fa-lg fa-fw text-gray-400'></i>";
      echo "</a>";
      echo "<div class='dropdown-menu dropdown-menu-right shadow animated--fade-in' aria-labelledby='dropdownMenuLink'>";
      echo "<div class='dropdown-header'>Options:</div>";
      echo "<a class='dropdown-item' href='#' onclick=refreshImage('".$image_data['fingerprint']."')>Refresh</a>";
      echo "<a class='dropdown-item' href='#' onclick=loadImageJson('".$image_data['fingerprint']."')>Edit</a>";
      echo "<a class='dropdown-item' href='#' onclick=deleteImage('".$image_data['fingerprint']."')>Delete</a>";
      echo "</div>";
      echo "</div>";
    echo '"';

    echo " ]";

  }

  echo " ]}";
  
}

?>

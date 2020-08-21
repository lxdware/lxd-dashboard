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
  $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/storage-pools?project=" . $project;
  $remote_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
  $remote_data = json_decode($remote_data, true);
  $storage_pool_urls = $remote_data['metadata'];

  $i = 0;
  echo '{ "data": [';

  foreach ($storage_pool_urls as $storage_pool_url){
    $url = "https://" . $row['host'] . ":" . $row['port'] . $storage_pool_url;
    $storage_pool_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $storage_pool_data = json_decode($storage_pool_data, true);
    $storage_pool_data = $storage_pool_data['metadata'];
    
    if ($storage_pool_data['name'] == "")
    continue;

    if ($i > 0){
      echo ",";
    }
    $i++;

    echo "[ ";
    echo '"';
    echo "<a href='storage-volumes.html?pool=".$storage_pool_data['name']."&remote=".$remote."&project=".$project."'><i class='fas fa-hdd fa-lg' style='color:#4e73df'></i> </a>";
    echo '",';

    echo '"';
    echo "<a href='storage-volumes.html?pool=".$storage_pool_data['name']."&remote=".$remote."&project=".$project."'> ".$storage_pool_data['name']."</a>";
    echo '",';

    echo '"' . htmlentities($storage_pool_data['description']) . '",';
    echo '"' . htmlentities($storage_pool_data['driver']) . '",';
    echo '"' . htmlentities($storage_pool_data['config']['source']) . '",';
    echo '"' . htmlentities($storage_pool_data['config']['size']) . '",';

    echo '"';
      echo "<div class='dropdown no-arrow'>";
      echo "<a class='dropdown-toggle' href='#' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
      echo "<i class='fas fa-ellipsis-v fa-lg fa-fw text-gray-400'></i>";
      echo "</a>";
      echo "<div class='dropdown-menu dropdown-menu-right shadow animated--fade-in' aria-labelledby='dropdownMenuLink'>";
      echo "<div class='dropdown-header'>Options:</div>";
      echo "<a class='dropdown-item' href='#' onclick=loadStoragePoolJson('".$storage_pool_data['name']."')>Edit</a>";
      echo "<a class='dropdown-item' href='#' onclick=deleteStoragePool('".$storage_pool_data['name']."')>Delete</a>";
      echo "</div>";
      echo "</div>";
    echo '"';

    echo " ]";

  }

  echo " ]}";
  
}

?>
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
  $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/networks?project=" . $project;
  $remote_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
  $remote_data = json_decode($remote_data, true);
  $network_urls = $remote_data['metadata'];

  $i = 0;
  echo '{ "data": [';

  foreach ($network_urls as $network_url){
    $url = "https://" . $row['host'] . ":" . $row['port'] . $network_url . "?project=" . $project;
    $network_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $network_data = json_decode($network_data, true);
    $network_data = $network_data['metadata'];
    
    if ($network_data['name'] == "")
    continue;

    $network_data_managed = ($network_data['managed'])?"true":"false";

    if ($i > 0){
      echo ",";
    }
    $i++;

    echo "[ ";
    echo '"';
    if ($network_data['managed'] == "true")
      echo "<i class='fas fa-network-wired fa-lg' style='color:#4e73df'></i>";
    else
      echo "<i class='fas fa-network-wired fa-lg' style='color:#ddd'></i>";
    echo '",';
    echo '"' . htmlentities($network_data['name']) . '",';
    echo '"' . htmlentities($network_data['description']) . '",';
    echo '"' . htmlentities($network_data['type']) . '",';
    echo '"' . htmlentities($network_data_managed) . '",';


    echo '"';
    if ($network_data['managed'] == "true"){
      echo "<div class='dropdown no-arrow'>";
      echo "<a class='dropdown-toggle' href='#' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
      echo "<i class='fas fa-ellipsis-v fa-sm fa-fw text-gray-400'></i>";
      echo "</a>";
      echo "<div class='dropdown-menu dropdown-menu-right shadow animated--fade-in' aria-labelledby='dropdownMenuLink'>";
      echo "<div class='dropdown-header'>Options:</div>";
      echo "<a class='dropdown-item' href='#' onclick=loadNetworkJson('".$network_data['name']."')>Edit</a>";
      echo "<a class='dropdown-item' href='#' onclick=deleteNetwork('".$network_data['name']."')>Delete</a>";
      echo "</div>";
      echo "</div>";
    }
    echo '"';

    echo " ]";

  }

  echo " ]}";
  
}

?>
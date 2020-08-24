<?php

$cert = "/root/.config/lxc/client.crt";
$key = "/root/.config/lxc/client.key";

if (isset($_GET['remote']))
  $remote = filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_STRING);
if (isset($_GET['project']))
  $project = filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING);
if (isset($_GET['instance']))
  $instance = filter_var(urldecode($_GET['instance']), FILTER_SANITIZE_STRING);


echo '<thead>';
echo '  <tr>';
echo "    <th style='width:75px'></th>";
echo '    <th>Name</th>';
echo '    <th>Stateful/Stateless</th>';
echo '    <th>Size</th>';
echo '    <th>Created At</th>';
echo "    <th style='width:75px'></th>";
echo '  </tr>';
echo '</thead>';
echo '<tbody>';


$db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
$db_statement = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
$db_statement->bindValue(':id', $remote);
$db_results = $db_statement->execute();

while($row = $db_results->fetchArray()){
  $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/instances/" . $instance . "/snapshots?project=" . $project;
  $remote_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
  $remote_data = json_decode($remote_data, true);
  $snapshot_urls = $remote_data['metadata'];
  foreach ($snapshot_urls as $snapshot_url){
    $url = "https://" . $row['host'] . ":" . $row['port'] . $snapshot_url . "?project=" . $project;
    $snapshot_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $snapshot_data = json_decode($snapshot_data, true);
    $snapshot_data = $snapshot_data['metadata'];
    if ($snapshot_data['name'] == "")
    continue;

    if ($snapshot_data['stateful'])
      $state = "stateful";
    else
      $state = "stateless";

    echo "<tr>";

    echo "<td> <i class='fas fa-clone fa-lg' style='color:#4e73df'></i> </td>";
    echo "<td>" . htmlentities($snapshot_data['name']) . "</td>";
    echo "<td>" . htmlentities($state) . "</td>";
    echo "<td>" . htmlentities(number_format($snapshot_data['size']/1024/1024,2)) . "MB</td>";
    echo "<td>" . htmlentities($snapshot_data['created_at']) . "</td>";

    echo "<td>";
      echo '<div class="dropdown no-arrow">';
      echo '<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
      echo '<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>';
      echo '</a>';
      echo '<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">';
      echo '<div class="dropdown-header">Options:</div>';
      echo '<a class="dropdown-item" href="#" onclick="restoreSnapshot(' . escapeshellarg($snapshot_data['name']) . ')">Restore</a>';
      echo '<a class="dropdown-item" href="#" onclick="deleteSnapshot(' . escapeshellarg($snapshot_data['name']) . ')">Delete</a>';
      echo '</div>';
      echo '</div>';
    echo "</td>";
    
    echo "</tr>";

  }
}

echo "</tbody>";


?>

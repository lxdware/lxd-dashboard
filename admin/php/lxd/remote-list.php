<?php

$cert = "/root/.config/lxc/client.crt";
$key = "/root/.config/lxc/client.key";

if (isset($_GET['action']))
  $action = filter_var(urldecode($_GET['action']), FILTER_SANITIZE_STRING);

echo "<thead>";
echo "<tr>";
echo "<th style='width:75px'></th>";
echo "<th>Host</th>";
echo "<th>Port</th>";
echo "<th>Alias</th>";
echo "<th>Protocol</th>";
echo "<th style='width:75px'></th>";
echo "</tr>";
echo "</thead>";

echo "<tbody>";

$db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');

$db_results = $db->query('SELECT * FROM lxd_hosts');

if ($db_results != false){
  while ($row = $db_results->fetchArray()){

    echo "<tr>";

    if ($action == "quickLoad"){
      echo '<td> <a href="host.html?remote=' . $row['id'] . '&project=default"> <i class="fas fa-server fa-2x" style="color:#4e73df"></i> </a> </td>';
      echo '<td> <a href="host.html?remote=' . $row['id'] . '&project=default">' . $row['host'] . '</a> </td>';
    } 
    else {
      $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0";
      $data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
      $data = json_decode($data, true);
      if ($data['metadata']['auth'] == "trusted"){
        echo '<td> <a href="host.html?remote=' . $row['id'] . '&project=default"> <i class="fas fa-server fa-2x" style="color:#4e73df"></i> </a> </td>';
        echo '<td> <a href="host.html?remote=' . $row['id'] . '&project=default">' . $row['host'] . '</a> </td>';
      }
      else {
        echo '<td> <i class="fas fa-server fa-2x" style="color:#ddd"></i> </td>';
        echo '<td>' . $row['host'] . '</td>';
      }
    }


    echo "<td>" . $row['port'] . "</td>";
    echo "<td>" . $row['alias'] . "</td>";
    echo "<td>" . $row['protocol'] . "</td>";

    echo "<td>";
    echo '<div class="dropdown no-arrow">';
    echo '<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
    echo '<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>';
    echo '</a>';
    echo '<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">';
    echo '<div class="dropdown-header">Options:</div>';
    echo '<a class="dropdown-item" href="#" onclick="removeRemote(' . escapeshellarg($row['id']) . ')">Remove</a>';
    echo '</div>';
    echo '</div>';
    echo "</td>";

    echo "</tr>";

  }
}

echo "</tbody>";

?>

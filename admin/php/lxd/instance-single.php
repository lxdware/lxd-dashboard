<?php

$cert = "/root/.config/lxc/client.crt";
$key = "/root/.config/lxc/client.key";

if (isset($_GET['remote']))
  $remote = filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_STRING);
if (isset($_GET['project']))
  $project = filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING);
if (isset($_GET['instance']))
  $instance = filter_var(urldecode($_GET['instance']), FILTER_SANITIZE_STRING);


$db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
$db_statement = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
$db_statement->bindValue(':id', $remote);
$db_results = $db_statement->execute();

while($row = $db_results->fetchArray()){

  //Instance Data
  $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/instances/" . $instance . "?project=" . $project;
  $instance_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
  $instance_data = json_decode($instance_data, true);
  $instance_data = $instance_data['metadata'];

  //Instance State
  $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/instances/" . $instance . "/state?project=" . $project;
  $instance_state = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
  $instance_state = json_decode($instance_state, true);
  $instance_state = $instance_state['metadata'];


  $name = $instance_data['name'];
  $created = $instance_data['created_at'];
  $description = $instance_data['description'];
  $type = $instance_data['type'];
  $image = $instance_data['config']['image.description'];
  $status = $instance_data['status']; //ex Running
  $memory = number_format($instance_state['memory']['usage'] / 1048576, 2);


  echo '<div class="row">';
  echo '<div class="col-12">';

  echo "<strong>Name</strong>: " . htmlentities($name) . "<br />";
  echo "<strong>Description</strong>: " . htmlentities($description) . "<br />";
  echo "<strong>Type</strong>: " . htmlentities($type) . "<br />";
  echo "<strong>Status</strong>: " . htmlentities($status) . "<br />";
  echo "<strong>Image</strong>: " . htmlentities($image) . "<br />";
  echo "<strong>Memory</strong>: " . htmlentities($memory) . " MB<br />";
  
  echo '</div>';

echo '</div>';



}

?>
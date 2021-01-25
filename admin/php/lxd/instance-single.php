<?php

if (!empty($_SERVER['PHP_AUTH_USER'])) {

  $cert = "/var/lxdware/data/lxd/client.crt";
  $key = "/var/lxdware/data/lxd/client.key";

  //Instantiate the GET variables
  if (isset($_GET['remote']))
    $remote = filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_STRING);
  if (isset($_GET['project']))
    $project = filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING);
  if (isset($_GET['instance']))
    $instance = filter_var(urldecode($_GET['instance']), FILTER_SANITIZE_STRING);

 //Determine host info from database
  $db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
  $db_statement = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
  $db_statement->bindValue(':id', $remote);
  $db_results = $db_statement->execute();

  while($row = $db_results->fetchArray()){
    $url = "https://" . $row['host'] . ":" . $row['port'];

    //Instance Data 
    $data_url = $url . "/1.0/instances/".$instance."?project=" . $project;
    $instance_api_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET $data_url");
    $instance_api_data = json_decode($instance_api_data, true);
    $instance_data = $instance_api_data['metadata'];

    $name = $instance_data['name']?: "N/A";
    $created = $instance_data['created_at']?: "N/A";
    $description = $instance_data['description']?: "N/A";
    $type = $instance_data['type']?: "N/A"; //ex container, virtual-machine
    $location = $instance_data['location']?: "N/A"; //used with clusters,none for non-clustered host
    $image = $instance_data['config']['image.description']?: "N/A"; //ex Ubuntu focal amd64 (20200821_07:42)
    $status = $instance_data['status']?: "N/A"; //ex Running
    
    echo "<strong>Name</strong>: " . htmlentities($name) . "<br />";
    echo "<strong>Description</strong>: " . htmlentities($description) . "<br />";
    echo "<strong>Type</strong>: " . htmlentities($type) . "<br />";
    echo "<strong>Status</strong>: " . htmlentities($status) . "<br />";
    echo "<strong>Image</strong>: " . htmlentities($image) . "<br />";
    echo "<strong>Location</strong>: " . htmlentities($location) . "<br />";

  }

}
?>
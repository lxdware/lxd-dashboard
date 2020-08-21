<?php
 
//Instantiate the GET variables
if (isset($_GET['remote']))
  $remote = filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_STRING);
if (isset($_GET['instance']))  
  $instance = filter_var(urldecode($_GET['instance']), FILTER_SANITIZE_STRING);
if (isset($_GET['project']))
  $project = filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING);
if (isset($_GET['action']))
  $action = filter_var(urldecode($_GET['action']), FILTER_SANITIZE_STRING);
if (isset($_GET['name']))
  $name = filter_var(urldecode($_GET['name']), FILTER_SANITIZE_STRING);
if (isset($_GET['profile']))
  $profile = filter_var(urldecode($_GET['profile']), FILTER_SANITIZE_STRING);
if (isset($_GET['fingerprint']))
  $fingerprint = filter_var(urldecode($_GET['fingerprint']), FILTER_SANITIZE_STRING);

//Instantiate the POST variable
if (isset($_POST['json']))  
  $json = $_POST['json'];

//Set the curl variables
$cert = "/root/.config/lxc/client.crt";
$key = "/root/.config/lxc/client.key";

//Query DB to find remote
$db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
$db_results = $db->query("SELECT * FROM lxd_hosts WHERE id = $remote LIMIT 1");

while($res = $db_results->fetchArray()){
  $url = "https://" . $res['host'] . ":" . $res['port'];

  //Run the matching action
  switch ($action) {
    case "deleteProject":
      $url = $url . "/1.0/projects/" . $name;
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X DELETE $url");
      break;
    case "createProject":
      $url = $url . "/1.0/projects";
      $data = escapeshellarg('{"name":"' . $name . '"}');
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X POST -d $data $url");
    break;
    case "loadProject":
      $url = $url . "/1.0/projects/" . $name;
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    break;
    case "updateProject":
      $url = $url . "/1.0/projects/" . $project;
      $data = $json;
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X PUT -d '$data' $url");
    break;

  }
}

echo $results;

?>
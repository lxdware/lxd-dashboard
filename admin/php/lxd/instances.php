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
if (isset($_GET['instance_type']))
  $instance_type = filter_var(urldecode($_GET['instance_type']), FILTER_SANITIZE_STRING);
if (isset($_GET['description']))
  $description = filter_var(urldecode($_GET['description']), FILTER_SANITIZE_STRING);
if (isset($_GET['public']))
  $public = filter_var(urldecode($_GET['public']), FILTER_SANITIZE_STRING);

$db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
$db_results = $db->query("SELECT * FROM lxd_hosts WHERE id = $remote LIMIT 1");

while($res = $db_results->fetchArray()){
  $url = "https://" . $res['host'] . ":" . $res['port'];

  //Set the curl variables
  $cert = "/root/.config/lxc/client.crt";
  $key = "/root/.config/lxc/client.key";

  //Run the matching action
  switch ($action) {
    case "createInstance":
      $url = $url . "/1.0/instances?project=" . $project;
      $data = escapeshellarg('{"name":"' . $name . '", "profiles": ["'. $profile . '"], "type": "' . $instance_type . '",  "source": {"type": "image", "fingerprint": "' . $fingerprint . '"} }');
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X POST -d $data $url");
      break;
    case "status":
      $url = $url . "/1.0/instances/" . $instance . "/state?project=" . $project;
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
      break;
    case "stopInstance":
      $url = $url . "/1.0/instances/" . $instance . "/state?project=" . $project;
      $data = escapeshellarg('{"action": "stop"}');
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X PUT -d $data $url");
      break;
    case "startInstance":
      $url = $url . "/1.0/instances/" . $instance . "/state?project=" . $project;
      $data = escapeshellarg('{"action": "start"}');
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X PUT -d $data $url");
      break;
    case "restartInstance":
      $url = $url . "/1.0/instances/" . $instance . "/state?project=" . $project;
      $data = escapeshellarg('{"action": "restart"}');
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X PUT -d $data $url");
      break;
    case "freeze":
      $url = $url . "/1.0/instances/" . $instance . "/state?project=" . $project;
      $data = escapeshellarg('{"action": "freeze"}');
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X PUT -d $data $url");
      break;
    case "unfreeze":
      $url = $url . "/1.0/instances/" . $instance . "/state?project=" . $project;
      $data = escapeshellarg('{"action": "unfreeze"}');
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X PUT -d $data $url");
      break;
    case "deleteInstance":
      $url = $url . "/1.0/instances/" . $instance . "?project=" . $project;
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X DELETE $url");
      break;
    case "snapshotInstance":
      $url = $url . "/1.0/instances/" . $instance . "/snapshots?project=" . $project;
      $data = escapeshellarg('{"name": "'. $name . '"}');
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X POST -d $data $url");
      break;
    case "renameInstance":
      $url = $url . "/1.0/instances/" . $instance . "?project=" . $project;
      $data = escapeshellarg('{"name": "'. $name . '"}');
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X POST -d $data $url");
      break;
    case "copyInstance":
      $url = $url . "/1.0/instances?project=" . $project;
      $data = escapeshellarg('{"name": "'. $name . '", "source":{"type":"copy","source": "'. $instance . '"}}');
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X POST -d $data $url");
      break;
    case "attachProfile":
      $url = $url . "/1.0/instances/" . $instance . "?project=" . $project;
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
      $data = json_decode($results, true);
      $data = $data['metadata']['profiles'];
      array_push($data, $name);
      $data = escapeshellarg('{"profiles":' . json_encode($data) . '}');
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X PATCH -d $data $url");
      break;
    case "detachProfile":
      $url = $url . "/1.0/instances/" . $instance . "?project=" . $project;
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
      $data = json_decode($results, true);
      $data = $data['metadata']['profiles'];
      $i = 0;
      foreach ($data as $element){
        if ($element == $name){
          unset($data[$i]);
        }
        $i++;
      }
      $data = escapeshellarg('{"profiles":' . json_encode($data) . '}');
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X PATCH -d $data $url");
      break;
    case "restoreSnapshot":
      $url = $url . "/1.0/instances/" . $instance . "?project=" . $project;
      $data = escapeshellarg('{"restore":"' . $name . '"}');
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X PUT -d $data $url");
      break;
    case "deleteSnapshot":
      $url = $url . "/1.0/instances/" . $instance . "/snapshots/" . $name . "?project=" . $project;
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X DELETE $url");
      break;
    case "publishInstance":
      $url = $url . "/1.0/images?project=" . $project;
      $data = escapeshellarg('{"properties":{"description": "'. $description . '"}, "public": '. $public . ', "source":{"type": "instance", "name": "'. $instance . '"}}');
      $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X POST -d $data $url");
      break;
  }
}

echo $results;

?>


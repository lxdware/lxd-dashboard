<?php

if (!empty($_SERVER['PHP_AUTH_USER'])) {

  $cert = "/var/lxdware/data/lxd/client.crt";
  $key = "/var/lxdware/data/lxd/client.key";

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
  if (isset($_GET['path']))
    $path = filter_var(urldecode($_GET['path']), FILTER_SANITIZE_STRING);
  if (isset($_GET['location']))
    $location = filter_var(urldecode($_GET['location']), FILTER_SANITIZE_STRING);
  if (isset($_GET['stateful']))
    $stateful = filter_var(urldecode($_GET['stateful']), FILTER_SANITIZE_STRING);

  //Determine host info from database
  $db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
  $db_statement = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
  $db_statement->bindValue(':id', $remote);
  $db_results = $db_statement->execute();

  while($row = $db_results->fetchArray()){
    $url = "https://" . $row['host'] . ":" . $row['port'];

    //Run the matching action
    switch ($action) {
      case "createInstance":
        
        if ($location == "none"){
          $url = $url . "/1.0/instances?project=" . $project; 
        }
        else {
          $url = $url . "/1.0/instances?target=" . $location . "&project=" . $project;
        }
        
        if ($fingerprint == "none") {
          $data = escapeshellarg('{"name":"' . $name . '", "profiles": ["'. $profile . '"], "type": "' . $instance_type . '",  "source": {"type": "none"} }');
        }
        else {
          $data = escapeshellarg('{"name":"' . $name . '", "profiles": ["'. $profile . '"], "type": "' . $instance_type . '",  "source": {"type": "image", "fingerprint": "' . $fingerprint . '"} }');
        }

        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X POST -d $data $url");
        break;
      case "status":
        $url = $url . "/1.0/instances/" . $instance . "/state?project=" . $project;
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET $url");
        break;
      case "stopInstance":
        $url = $url . "/1.0/instances/" . $instance . "/state?project=" . $project;
        $data = escapeshellarg('{"action": "stop"}');
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X PUT -d $data $url");
        break;
      case "forceStopInstance":
        $url = $url . "/1.0/instances/" . $instance . "/state?project=" . $project;
        $data = escapeshellarg('{"action": "stop","force":true}');
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X PUT -d $data $url");
        break;
      case "startInstance":
        $url = $url . "/1.0/instances/" . $instance . "/state?project=" . $project;
        $data = escapeshellarg('{"action": "start"}');
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X PUT -d $data $url");
        break;
      case "restartInstance":
        $url = $url . "/1.0/instances/" . $instance . "/state?project=" . $project;
        $data = escapeshellarg('{"action": "restart"}');
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X PUT -d $data $url");
        break;
      case "freezeInstance":
        $url = $url . "/1.0/instances/" . $instance . "/state?project=" . $project;
        $data = escapeshellarg('{"action": "freeze"}');
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X PUT -d $data $url");
        break;
      case "unfreezeInstance":
        $url = $url . "/1.0/instances/" . $instance . "/state?project=" . $project;
        $data = escapeshellarg('{"action": "unfreeze"}');
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X PUT -d $data $url");
        break;
      case "deleteInstance":
        $url = $url . "/1.0/instances/" . $instance . "?project=" . $project;
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X DELETE $url");
        break;
      case "snapshotInstance":
        $url = $url . "/1.0/instances/" . $instance . "/snapshots?project=" . $project;
        if ($stateful != "true"){
          $stateful = "false";
        }
        $data = escapeshellarg('{"name": "' . $name . '", "stateful": ' . $stateful . '}');
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X POST -d $data $url");
        break;
      case "renameInstance":
        $url = $url . "/1.0/instances/" . $instance . "?project=" . $project;
        $data = escapeshellarg('{"name": "' . $name . '"}');
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X POST -d $data $url");
        break;
      case "copyInstance":
        //Copying on clustered hosts requires target location. Determine location of instance being copied.
        $instance_url = $url . "/1.0/instances/$instance?project=" . $project;
        $instance_api_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET $instance_url");
        $instance_api_data = json_decode($instance_api_data, true);
        $instance_data = $instance_api_data['metadata'];
        $location = $instance_data['location']; //Returns "none" for instances on non-clusted hosts
        //Copy instance on host to same host
        $url = $url . "/1.0/instances?target=".$location."&project=" . $project;
        $data = escapeshellarg('{"name": "'. $name . '", "source":{"type":"copy","source": "'. $instance . '"}}');
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X POST -d $data $url");
        break;
      case "migrateInstance":
        $url = $url . "/1.0/instances/" . $instance . "?target=" . $location . "&project=" . $project;
        $data = escapeshellarg('{"name": "'. $instance . '", "migration": true, "live": false}');
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X POST -d $data $url");
        break;
      case "attachProfile":
        $url = $url . "/1.0/instances/" . $instance . "?project=" . $project;
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET $url");
        $data = json_decode($results, true);
        $data = $data['metadata']['profiles'];
        array_push($data, $name);
        $data = escapeshellarg('{"profiles":' . json_encode($data) . '}');
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X PATCH -d $data $url");
        break;
      case "detachProfile":
        $url = $url . "/1.0/instances/" . $instance . "?project=" . $project;
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET $url");
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
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X PATCH -d $data $url");
        break;
      case "restoreSnapshot":
        $url = $url . "/1.0/instances/" . $instance . "?project=" . $project;
        $data = escapeshellarg('{"restore":"' . $name . '"}');
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X PUT -d $data $url");
        break;
      case "deleteSnapshot":
        $url = $url . "/1.0/instances/" . $instance . "/snapshots/" . $name . "?project=" . $project;
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X DELETE $url");
        break;
      case "publishInstance":
        $url = $url . "/1.0/images?project=" . $project;
        $data = escapeshellarg('{"properties":{"description": "'. $description . '"}, "public": '. $public . ', "source":{"type": "instance", "name": "'. $instance . '"}}');
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X POST -d $data $url");
        break;
      case "loadLog":
        $url = $url . $path . "?project=" . $project;
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET $url");
        break;
      case "deleteLog":
        $url = $url . $path . "?project=" . $project;
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X DELETE $url");
        break;
      case "createBackup":
        $url = $url . "/1.0/instances/" . $instance . "/backups?project=" . $project;
        $data = escapeshellarg('{"name": "'. $name . '"}');
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X POST -d $data $url");
        break;
      case "downloadBackup":
        mkdir('../../downloads');
        $url = $url . "/1.0/instances/" . $instance . "/backups/" . $name . "/export?project=" . $project;
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --output ../../downloads/".$name.".tar.gz --cert $cert --key $key -X GET $url");
        $results = "downloads/".$name.".tar.gz";
        break;
      case "deleteBackup":
        $url = $url . "/1.0/instances/" . $instance . "/backups/" . $name . "?project=" . $project;
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X DELETE $url");
        break;
      case "loadInstance":
        $url = $url . "/1.0/instances/" . $name . "?project=" . $project;
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET $url");
        break;
    }
  }

  echo $results;

}
else {
  echo '{"error": "not authenticated", "error_code": "401", "metadata": {"err": "not authenticated", "status_code": "401"}}';
}

?>


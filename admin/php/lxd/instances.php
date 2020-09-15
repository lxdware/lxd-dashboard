<?php

if (!empty($_SERVER['PHP_AUTH_USER'])) {

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
  if (isset($_GET['destination']))
    $destination = filter_var(urldecode($_GET['destination']), FILTER_SANITIZE_STRING);

  $db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
  $db_results = $db->query("SELECT * FROM lxd_hosts WHERE id = $remote LIMIT 1");

  while($res = $db_results->fetchArray()){
    $url = "https://" . $res['host'] . ":" . $res['port'];

    //Set the curl variables
    $cert = "/var/lxdware/data/lxd/client.crt";
    $key = "/var/lxdware/data/lxd/client.key";

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
        /*
      case "migrateInstance":
        $operation_url = $url;
        $pem_url = $url;
        $url = $url . "/1.0/instances/" . $instance . "?project=" . $project;
        $data = escapeshellarg('{"name": "test", "migration": true, "live": false}');
        $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X POST -d $data $url");
        $operation_data = json_decode($results, true);
        $operation_data = $operation_data['metadata'];
        
        $id = $operation_data['id']; //operaton number
        $control = $operation_data['metadata']['control']; // Migration control socket
        //$criu = $operation_data['metadata']['criu']; // State transfer socket (only if live migrating)
        $fs = $operation_data['metadata']['fs']; // Filesystem transfer socket

        $pem_url = $pem_url . "/1.0";
        $pem_results = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $pem_url");
        $pem_results = json_decode($pem_results, true);
        $pem_data = $pem_results['metadata'];
        $pem_certificate = $pem_data['environment']['certificate'];
        $pem_certificate = str_replace('\n', '\\n', $pem_certificate);

        $operation_url = $operation_url . "/1.0/operations/" . $id . "?project=" . $project;
        $db_results2 = $db->query("SELECT * FROM lxd_hosts WHERE id = $destination LIMIT 1");
        while($res2 = $db_results2->fetchArray()){
          $url2 = "https://" . $res2['host'] . ":" . $res2['port'];
          $url2 = $url2 . "/1.0/instances?project=" . $project;
          $data2 = escapeshellarg('{"name":"' . $instance . '", "architecture": "x86_64", "profiles": ["'. $profile . '"], "type": "' . $instance_type . '", "source": {"type": "migration", "mode": "pull", "certificate": "'.$pem_certificate.'", "instance_only": true, "operation": "'.$operation_url.'", "secrets": {"control": "'.$control.'", "fs": "'.$fs.'"} } }');
          $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X POST -d $data2 $url2");
        }
        break;
        */
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
      case "loadLog":
        $url = $url . $path . "?project=" . $project;
        $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
        break;
      case "downloadBackup":
        mkdir('../../downloads');
        $url = $url . $path . "/export?project=" . $project;
        $results = shell_exec("sudo curl -k -L --output ../../downloads/".basename($path).".tar.gz --cert $cert --key $key -X GET $url");
        $results = "downloads/".basename($path).".tar.gz";
        break;
      case "deleteBackup":
        $url = $url . $path . "?project=" . $project;
        $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X DELETE $url");
        break;
      case "createBackup":
        $url = $url . "/1.0/instances/" . $instance . "/backups?project=" . $project;
        $data = escapeshellarg('{"name": "'. $name . '"}');
        $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X POST -d $data $url");
        break;
      case "loadBackup":
        $url = $url . $path . "?project=" . $project;
        $results = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
        break;
    }
  }

  echo $results;

}
else {
  echo '{"error": "not authenticated", "error_code": "401", "metadata": {"err": "not authenticated", "status_code": "401"}}';
}

?>


<?php

if (!empty($_SERVER['PHP_AUTH_USER'])) {

  //Instantiate the GET variables
  if (isset($_GET['remote']))
    $remote = filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_STRING);
  if (isset($_GET['project']))
    $project = filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING);
  if (isset($_GET['action']))
    $action = filter_var(urldecode($_GET['action']), FILTER_SANITIZE_STRING);
  if (isset($_GET['storage_pool']))
    $storage_pool = filter_var(urldecode($_GET['storage_pool']), FILTER_SANITIZE_STRING);

  if (isset($_GET['name']))
    $name = filter_var(urldecode($_GET['name']), FILTER_SANITIZE_STRING);
  if (isset($_GET['description']))
    $description = filter_var(urldecode($_GET['description']), FILTER_SANITIZE_STRING);
  if (isset($_GET['size']))
    $size = filter_var(urldecode($_GET['size']), FILTER_SANITIZE_STRING);
  if (isset($_GET['driver']))
    $driver = filter_var(urldecode($_GET['driver']), FILTER_SANITIZE_STRING);
  if (isset($_GET['repo']))
    $repo = filter_var(urldecode($_GET['repo']), FILTER_SANITIZE_STRING);

  //Instantiate the POST variable
  if (isset($_POST['json']))  
    $json = $_POST['json'];

  //Set the curl variables
  $cert = "/var/lxdware/data/lxd/client.crt";
  $key = "/var/lxdware/data/lxd/client.key";

  //Query DB to find remote
  $db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
  $db_results = $db->query("SELECT * FROM lxd_hosts WHERE id = $remote LIMIT 1");

  while($res = $db_results->fetchArray()){
    $url = "https://" . $res['host'] . ":" . $res['port'];

    //Run the matching action
    switch ($action) {
      case "createStoragePoolForm":
        //Check to see if host is part of a cluster. Clusted hosts need storage pool created first on each of the hosts
        $enabled_url = $url . "/1.0/cluster";
        $remote_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET '$enabled_url'");
        $remote_data = json_decode($remote_data, true);
        $cluster_status = $remote_data['metadata'];
        if ($cluster_status['enabled'] == true){
          //Now setup storage pool on each cluster member, putting them in pending status
          $cluster_url = $url . "/1.0/cluster/members?recursion=1";
          $cluster_api_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET '$cluster_url'");
          $cluster_api_data = json_decode($cluster_api_data, true);
          $cluster_api_data = $cluster_api_data['metadata'];
          foreach ($cluster_api_data as $cluster_data){
            if ($cluster_data['status'] == "Online"){
              $member_url = $url . "/1.0/storage-pools?target=".$cluster_data['server_name']."&project=" . $project;
              if ($driver == "dir" || $driver == "ceph")
                $data = escapeshellarg('{"driver": "'.$driver.'","name": "'.$name.'","description": "'.$description.'"}');
              else
                $data = escapeshellarg('{"config": {"size": "'.$size.'GB"},"driver": "'.$driver.'","name": "'.$name.'","description": "'.$description.'"}');
              $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X POST -d $data '$member_url'");
            }
          }
          //Now lets create the storage pool without config, moving the pending status to created
          $url = $url . "/1.0/storage-pools?project=" . $project;
          if ($driver == "dir" || $driver == "ceph")
            $data = escapeshellarg('{"driver": "'.$driver.'","name": "'.$name.'","description": "'.$description.'"}');
          else
            $data = escapeshellarg('{"config": {},"driver": "'.$driver.'","name": "'.$name.'","description": "'.$description.'"}');
          $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X POST -d $data '$url'");
        }
        else {
          //This is process of creating storage pool on a non-clustered host
          $url = $url . "/1.0/storage-pools?project=" . $project;
          if ($driver == "dir" || $driver == "ceph")
            $data = escapeshellarg('{"driver": "'.$driver.'","name": "'.$name.'","description": "'.$description.'"}');
          else
            $data = escapeshellarg('{"config": {"size": "'.$size.'GB"},"driver": "'.$driver.'","name": "'.$name.'","description": "'.$description.'"}');
          $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X POST -d $data '$url'");
        }
        break;
      case "createStoragePoolJson":
        $url = $url . "/1.0/storage-pools?project=" . $project;
        $data = escapeshellarg($json);
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X POST -d $data '$url'");
        break;
      case "deleteStoragePool":
        $url = $url . "/1.0/storage-pools/" . $storage_pool . "?project=" . $project;
        $data = escapeshellarg('{}');
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X DELETE -d $data '$url'");
      break;
      case "updateStoragePool":
        $url = $url . "/1.0/storage-pools/" . $storage_pool . "?project=" . $project;
        $data = escapeshellarg($json);
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X PUT -d $data '$url'");
      break;
      case "renameStoragePool":
        $url = $url . "/1.0/storage-pools/" . $storage_pool . "?project=" . $project;
        $data = escapeshellarg('{"name": "' . $name . '"}');
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X POST -d $data '$url'");
      break;
      case "loadStoragePool":
        $url = $url . "/1.0/storage-pools/" . $storage_pool . "?project=" . $project;
        $results = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET '$url'");
      break;
    }
  }

  echo $results;

}
else {
  echo '{"error": "not authenticated", "error_code": "401", "metadata": {"err": "not authenticated", "status_code": "401"}}';
}
  
?>
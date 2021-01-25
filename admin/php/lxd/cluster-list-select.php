<?php

if (!empty($_SERVER['PHP_AUTH_USER'])) {

  $cert = "/var/lxdware/data/lxd/client.crt";
  $key = "/var/lxdware/data/lxd/client.key";

  if (isset($_GET['remote']))
    $remote = filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_STRING);
  if (isset($_GET['include_none']))
    $include_none = filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_STRING);
  
  if ($include_none == true){
    echo '<option value="none">none</option>';
  }

  $db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
  $db_statement = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
  $db_statement->bindValue(':id', $remote);
  $db_results = $db_statement->execute();

  while($row = $db_results->fetchArray()){
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/cluster/members?recursion=1";
    $cluster_api_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET $url");
    $cluster_api_data = json_decode($cluster_api_data, true);
    $cluster_hosts = $cluster_api_data['metadata'];
    
    foreach ($cluster_hosts as $cluster_host){

      if ($cluster_host['message'] != "fully operational")
        continue;
    
      echo '<option value="' . $cluster_host['server_name'] . '">' . htmlentities($cluster_host['server_name']) . '</option>';
    }
  }
}
?>
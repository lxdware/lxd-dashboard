<?php

if (!empty($_SERVER['PHP_AUTH_USER'])) {

  $cert = "/var/lxdware/data/lxd/client.crt";
  $key = "/var/lxdware/data/lxd/client.key";

  if (isset($_GET['remote']))
    $remote = filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_STRING);
  if (isset($_GET['project']))
    $project = filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING);


  $db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
  $db_statement = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
  $db_statement->bindValue(':id', $remote);
  $db_results = $db_statement->execute();

  while($row = $db_results->fetchArray()){
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/profiles?project=" . $project;
    $remote_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $remote_data = json_decode($remote_data, true);
    $profile_urls = $remote_data['metadata'];
    foreach ($profile_urls as $profile_url){
      $url = "https://" . $row['host'] . ":" . $row['port'] . $profile_url . "?project=" . $project;
      $profile_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
      $profile_data = json_decode($profile_data, true);
      $profile_data = $profile_data['metadata'];
      
      if ($profile_data['name'] == "")
      continue;
    
      echo '<option value="' . $profile_data['name'] . '">' . htmlentities($profile_data['name']) . '</option>';
    }
  }
}
?>
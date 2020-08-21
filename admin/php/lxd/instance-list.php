<?php

$cert = "/root/.config/lxc/client.crt";
$key = "/root/.config/lxc/client.key";

if (isset($_GET['remote']))
  $remote = filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_STRING);
if (isset($_GET['project']))
  $project = filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING);

$db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
$db_statement = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
$db_statement->bindValue(':id', $remote);
$db_results = $db_statement->execute();

while($row = $db_results->fetchArray()){
  $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/instances?project=" . $project;
  $remote_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
  $remote_data = json_decode($remote_data, true);
  $instance_urls = $remote_data['metadata'];

  $i = 0;
  echo '{ "data": [';

  foreach ($instance_urls as $instance_url){
    $url = "https://" . $row['host'] . ":" . $row['port'] . $instance_url;
    $instance_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $instance_data = json_decode($instance_data, true);
    $instance_data = $instance_data['metadata'];
    if ($instance_data['name'] == "")
      continue;

    if ($i > 0){
      echo ",";
    }
    $i++;

    echo "[ ";
    if ($instance_data['status'] == "Running"){
      echo '"';
      echo "<a href='instance.html?instance=".$instance_data['name']."&remote=".$remote."&project=".$project."'><i class='fas fa-cube fa-lg' style='color:#4e73df'></i> </a>";
      echo '",';

      echo '"';
      echo "<a href='instance.html?instance=".$instance_data['name']."&remote=".$remote."&project=".$project."'> ".$instance_data['name']."</a>";
      echo '",';
    }
    else {
      echo '"';
      echo "<a href='instance.html?instance=".$instance_data['name']."&remote=".$remote."&project=".$project."'><i class='fas fa-cube fa-lg' style='color:#ddd'></i> </a>";
      echo '",';

      echo '"';
      echo "<a href='instance.html?instance=".$instance_data['name']."&remote=".$remote."&project=".$project."'> ".$instance_data['name']."</a>";
      echo '",';
    }
   
    echo '"' . $instance_data['config']['image.description'] . '",';
    echo '"' . $instance_data['type'] . '",';
    echo '"' . $instance_data['architecture'] . '",';
    echo '"' . $instance_data['status'] . '",';

    if ($instance_data['status'] == "Running"){
      echo '"';
      echo "<a href='#' onclick=stopInstance('".$instance_data['name']."')> <i class='fas fa-stop fa-lg' style='color:#ddd'></i> </a>";
      echo '"';
    }
    else{
      echo '"';
      echo "<a href='#' onclick=startInstance('".$instance_data['name']."')> <i class='fas fa-play fa-lg' style='color:#ddd'></i> </a>";
      echo '"';
    }
    
    echo " ]";

  }

  echo " ]}";
  
}



?>
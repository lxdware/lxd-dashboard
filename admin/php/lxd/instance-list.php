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
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/instances?recursion=2&project=" . $project;
    $instance_api_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $instance_api_data = json_decode($instance_api_data, true);
    $instance_api_data = $instance_api_data['metadata'];

    $i = 0;
    echo '{ "data": [';

    foreach ($instance_api_data as $instance_data){

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
      echo '"' . $instance_data['location'] . '",';
      echo '"' . $instance_data['type'] . '",';

      //Convert the memory usage to an appropriate unit
      if ($instance_data['state']['memory']['usage'] < 1073741824){
        $memory = number_format($instance_data['state']['memory']['usage']/1024/1024, 2);
        $memory_unit = "MB";
      }
      else {
        $memory = number_format($instance_data['state']['memory']['usage']/1024/1024/1024, 2);
        $memory_unit = "GB";
      }

      echo '"' . $memory . " " . $memory_unit . '",';

      //Convert the storage usage to an approprate unit
      if ($instance_data['state']['disk']['root']['usage']  < 1073741824){
        $disk_total = number_format($instance_data['state']['disk']['root']['usage']/1024/1024,2);
        $disk_unit = "MB";
      }
      if ($instance_data['state']['disk']['root']['usage']  >= 1073741824 && $instance_data['state']['disk']['root']['usage'] < 1099511627776) {
        $disk_total = number_format($instance_data['state']['disk']['root']['usage']/1024/1024/1024,2);
        $disk_unit = "GB";
      }
      if ($instance_data['state']['disk']['root']['usage'] >= 1099511627776){
        $disk_total = number_format($instance_data['state']['disk']['root']['usage']/1024/1024/1024/1024,2);
        $disk_unit = "TB";
      }

      echo '"' . $disk_total . " " . $disk_unit . '",';
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

}
else {
  echo '{ "data": [] }';
}

?>
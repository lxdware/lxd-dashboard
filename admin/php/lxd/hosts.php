<?php

if (!empty($_SERVER['PHP_AUTH_USER'])) {

  $cert = "/var/lxdware/data/lxd/client.crt";
  $key = "/var/lxdware/data/lxd/client.key";

   //Instantiate the GET variables
  if (isset($_GET['remote']))
    $remote = filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_STRING);
  if (isset($_GET['project']))
    $project = filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING);
  if (isset($_GET['action']))
    $action = filter_var(urldecode($_GET['action']), FILTER_SANITIZE_STRING);

  //Determine host info from database
  $db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
  $db_statement = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
  $db_statement->bindValue(':id', $remote);
  $db_results = $db_statement->execute();

  while($row = $db_results->fetchArray()){
    $url = "https://" . $row['host'] . ":" . $row['port'];

    //Run the matching action
    switch ($action) {
      case "sysInfo":
        //Retrieve host resource data
        $url = $url . "/1.0/resources?project=" . $project;
        $resource_api_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET $url");
        if ($resource_api_data == NULL) {
          $results =  "<strong>Error</strong>: Unable to connect to host <br /> <br />";
          break;
        }
        $resource_api_data = json_decode($resource_api_data, true);    
        $resource_data = $resource_api_data['metadata'];
        #Extract json data into variables
        $system_vendor = $resource_data['system']['vendor']?: "N/A"; //example: DigitalOcean, Dell, Etc
        $system_product = $resource_data['system']['product']?: "N/A"; //example: Droplet, R810, Etc
        $architecture = $resource_data['cpu']['architecture']?: "N/A"; //example: x86_64
        $cpus = $resource_data['cpu']['total']?: "N/A"; //total number of cpus
        $sockets = $resource_data['cpu']['sockets']; //array of cpu info per socket
        $storage_disks = $resource_data['storage']['disks']; //array of storage devices
        #Determine Memory Information
        if ($resource_data['memory']['total'] < 1073741824) {
          $memory_total = number_format($resource_data['memory']['total']/1024/1024,2); //total amount of memory used in MB
          $memory_used = number_format($resource_data['memory']['used']/1024/1024,2); //current amount of memory used in MB
          $memory_unit = "MB";
        }
        else {
          $memory_total = number_format($resource_data['memory']['total']/1024/1024/1024,2); //total amount of memory used in GB
          $memory_used = number_format($resource_data['memory']['used']/1024/1024/1024,2); //current amount of memory used in GB
          $memory_unit = "GB";
        }
        $memory_percentage = number_format($memory_used / $memory_total, 2) * 100;
        $results = '';
        $results .= "<strong>System Vendor</strong>: " . htmlentities($system_vendor) . "<br />";
        $results .= "<strong>System Product</strong>: " . htmlentities($system_product) . "<br />";
        $results .= "<br />";
        $results .= "<strong>CPU Information</strong>: <br />";
        $results .= "<ul>";
        $results .= "<li><strong>Architecture</strong>: " . htmlentities($architecture) . "</li>";
        $results .= "<li><strong>CPU Count</strong>: " . htmlentities($cpus) . "</li>";
        foreach($sockets as $socket){
          $results .= "<li><strong>Socket " . htmlentities($socket['socket']) . "</strong>: " . htmlentities($socket['name']?: "N/A") . "</li>";
        }
        $results .= "</ul>";
        $results .= "<strong>Total Memory</strong>: " . htmlentities($memory_total) . " " . $memory_unit . "<br />";
        $results .= "<strong>Percentage Used</strong>: " . htmlentities($memory_percentage) . "% <br />";
        $results .= "<br />";
        $results .= "<strong>Disk Storage Information</strong>: <br />";
        foreach($storage_disks as $disk){
          if ($disk['type'] == "cdrom")
            continue;
          $results .= "<ul>";
          $results .= "<li><strong>Disk ID</strong>: " . htmlentities($disk['id']?: "N/A") . "</li>";
          $results .= "<li><strong>Disk model</strong>: " . htmlentities($disk['model']?: "N/A") . "</li>";
          $results .= "<li><strong>Disk type</strong>: " . htmlentities($disk['type']?: "N/A") . "</li>";
          if ($disk['size'] < 1099511627776) {
            $disk_total = number_format($disk['size']/1024/1024/1024,2); //disk size in GB
            $disk_unit = "GB";
          }
          else {
            $disk_total = number_format($disk['size']/1024/1024/1024/1024,2); //disk size in TB
            $disk_unit = "TB";
          }
          $results .= "<li><strong>Disk size</strong>: " . $disk_total . " " . $disk_unit . "</li>";
          $results .= "</ul>";
        }   
        break;

      case "lxdInfo":
        //Retrieve host data
        $url = $url . "/1.0?project=" . $project;
        $api_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET $url");
        if ($api_data == NULL) {
          $results =  "<strong>Error</strong>: Unable to connect to host <br /> <br />";
          break;
        }
        $api_data = json_decode($api_data, true);    
        $data = $api_data['metadata'];
        #Extract json data into variables
        $addresses = $data['environment']['addresses']?: "N/A"; //array of ip addresses
        $driver = $data['environment']['driver']?: "N/A"; //example: qemu | lxc
        $driver_version = $data['environment']['driver_version']?: "N/A"; //example: 5.2.0 | 4.0.5
        $firewall = $data['environment']['firewall']?: "N/A"; //example: xtables
        $kernel = $data['environment']['kernel']?: "N/A"; //example: Linux
        $kernel_architecture = $data['environment']['kernel_architecture']?: "N/A"; //example: x86_64
        $kernel_version = $data['environment']['kernel_version']?: "N/A"; //example: 5.8.0-36-generic
        $os_name = $data['environment']['os_name']?: "N/A"; //example: Ubuntu
        $os_version = $data['environment']['os_version']?: "N/A"; //example: 20.04
        $server = $data['environment']['server']?: "N/A"; //example: lxd
        $server_version = $data['environment']['server_version']?: "N/A"; //example: 4.10
        $server_clustered = $data['environment']['server_clustered']?: "N/A"; //example: true
        $server_name = $data['environment']['server_name']?: "N/A"; //hostname
        $storage = $data['environment']['storage']?: "N/A"; //example: zfs
        $storage_version = $data['environment']['storage_version']?: "N/A"; //example: 0.8.4-1ubuntu11
        $results = '';
        $results .= "<strong>Operating System</strong>: " . htmlentities($os_name) . " " . htmlentities($os_version) ."<br />";
        $results .= "<strong>Hostname</strong>: " . htmlentities($server_name) . "<br />";
        $results .= "<strong>Kernel</strong>: " . htmlentities($kernel) . " " . htmlentities($kernel_version) ."<br />";
        $results .= "<br />";
        $results .= "<strong>Driver</strong>: " . htmlentities($driver) . "<br />";
        $results .= "<strong>Driver Version</strong>: " . htmlentities($driver_version) . "<br />";
        $results .= "<br />";
        $results .= "<strong>Storage Type</strong>: " . htmlentities($storage) . "<br />";
        $results .= "<strong>Storage Version</strong>: " . htmlentities($storage_version) . "<br />";
        $results .= "<br />";
        $results .= "<strong>Firewall</strong>: " . htmlentities($firewall) . "<br />";
        $results .= "<strong>Addresses</strong>: <br />";
        $results .= "<ul>";
        foreach($addresses as $address){
          $results .= "<li>" . htmlentities($address) . "</li>";
        }
        $results .= "</ul>";
        $results .= "<br />";
        break;

      case "instanceInfo":
        //Determine the number of running / total instances
        $running_instances = 0;
        $total_instances = 0;
        $url = $url. "/1.0/instances?recursion=2&project=" . $project;
        $instance_api_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET $url");
        $instance_api_data = json_decode($instance_api_data, true);
        foreach ($instance_api_data['metadata'] as $instance_data){
          if ($instance_data['state']['status'] == "Running"){
            $running_instances++;
          }
          $total_instances++;
        }
        $results = '';
        $results .= '<!-- Instance Card -->';
        $results .= '<i class="mb-2 fas fa-cube fa-5x fa-fw" style="color:#cccccc"></i>';
        $results .= '<div class="media-body">';
        $results .= '<h5 class="mt-0 mb-1"><strong>Instances:</strong></h5>';
        $results .= $running_instances . " out of " . $total_instances . " running";
        $results .= '<a href="instances.html?remote='.$remote.'&project='.$project.'" class="stretched-link"></a>'; 
        $results .= '</div>';
        break;

      case "imageInfo":
        //Retrieve list of images
        $url = $url . "/1.0/images?project=" . $project;
        $image_api_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET $url");
        $image_api_data = json_decode($image_api_data, true);
        $image_urls = $image_api_data['metadata'];
        $results = '';
        $results .= '<!-- Image Card -->';
        $results .=  '<i class="mb-2 fas fa-box-open fa-5x fa-fw" style="color:#cccccc"></i>';
        $results .=  '<div class="media-body">';
        $results .=  '<h5 class="mt-0 mb-1"><strong>Images:</strong></h5>';
        if (count($image_urls) != 1)
          $results .=  count($image_urls) . " images available";
        else
          $results .=  count($image_urls) . " image available";
        $results .= '<a href="images.html?remote='.$remote.'&project='.$project.'" class="stretched-link"></a>';
        $results .=  '</div>';
        break;

      case "clusterInfo":
        #First determine if part of a cluster
        $url_enabled = $url . "/1.0/cluster";
        $remote_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET $url_enabled");
        $remote_data = json_decode($remote_data, true);
        $cluster_status = $remote_data['metadata'];
        if ($cluster_status['enabled'] == false){
          //Host is not part of a cluster
          $results = '';
          $results .= '<!-- Cluster Card -->';
          $results .= '<i class="mb-2 fas fa-project-diagram fa-5x fa-fw" style="color:#cccccc"></i>';
          $results .= '<div class="media-body">';
          $results .= '<h5 class="mt-0 mb-1"><strong>Cluster:</strong></h5>';
          $results .= "0 out of 0 online";
          $results .= '<a href="cluster.html?remote='.$remote.'&project='.$project.'" class="stretched-link"></a>';
          $results .= '</div>';
        }
        else {
          //Retrieve cluster member status
          $online_members = 0;
          $total_members = 0;
          $url = $url . "/1.0/cluster/members?recursion=1";
          $cluster_api_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET $url");
          $cluster_api_data = json_decode($cluster_api_data, true);
          $cluster_api_data = $cluster_api_data['metadata'];
          foreach ($cluster_api_data as $cluster_data){
            if ($cluster_data['status'] == "Online"){
              $online_members++;
            }
            $total_members++;
          }
          $results = '';
          $results .= '<!-- Cluster Card -->';
          $results .= '<i class="mb-2 fas fa-project-diagram fa-5x fa-fw" style="color:#cccccc"></i>';
          $results .= '<div class="media-body">';
          $results .= '<h5 class="mt-0 mb-1"><strong>Cluster:</strong></h5>';
          $results .= $online_members . " out of " . $total_members . " online"; 
          $results .= '<a href="cluster.html?remote='.$remote.'&project='.$project.'" class="stretched-link"></a>';
          $results .= '</div>';
        }
        break;

      case "projectInfo":
        //Retrieve list of projects
        $url = $url . "/1.0/projects?project=" . $project;
        $project_api_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET $url");
        $project_api_data = json_decode($project_api_data, true);
        $project_urls = $project_api_data['metadata'];
        $results = '';
        $results .= '<!-- Project Card -->';
        $results .= '<i class="mb-2 fas fa-chart-bar fa-5x fa-fw" style="color:#cccccc"></i>';
        $results .= '<div class="media-body">';
        $results .= '<h5 class="mt-0 mb-1"><strong>Projects:</strong></h5>';
        if (count($project_urls) != 1)
          $results .= count($project_urls) . " project environments";
        else
          $results .= count($project_urls) . " project environment";
        $results .= '<a href="projects.html?remote='.$remote.'&project='.$project.'" class="stretched-link"></a>';
        $results .= '</div>';
        break;

      case "networkInfo":
        //Retrieve list of networks
        $url = $url . "/1.0/networks?project=" . $project;
        $network_api_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET $url");
        $network_api_data = json_decode($network_api_data, true);
        $network_urls = $network_api_data['metadata'];
        $results = '';
        $results .= '<!-- Network Card -->';
        $results .= '<i class="mb-2 fas fa-network-wired fa-5x fa-fw" style="color:#cccccc"></i>';
        $results .= '<div class="media-body">';
        $results .= '<h5 class="mt-0 mb-1"><strong>Networks:</strong></h5>';
        if (count($network_urls) != 1)
          $results .= count($network_urls) . " network interfaces";
        else
          $results .= count($network_urls) . " network interface";
        $results .= '<a href="networks.html?remote='.$remote.'&project='.$project.'" class="stretched-link"></a>';
        $results .= '</div>';
        break;

      case "storageInfo":
        //Retrieve list of storage pools
        $url = $url . "/1.0/storage-pools?project=" . $project;
        $storage_pool_api_data = shell_exec("sudo curl -k -L --connect-timeout 3 --cert $cert --key $key -X GET $url");
        $storage_pool_api_data = json_decode($storage_pool_api_data, true);
        $storage_pool_urls = $storage_pool_api_data['metadata'];
        $results = '';
        $results .= '<!-- Storage Card -->';
        $results .= '<i class="mb-2 fas fa-hdd fa-5x fa-fw" style="color:#cccccc"></i>';
        $results .= '<div class="media-body">';
        $results .= '<h5 class="mt-0 mb-1"><strong>Storage Pools:</strong></h5>';
        if (count($storage_pool_urls) != 1)
          $results .= count($storage_pool_urls) . " dedicated storage pools";
        else
          $results .= count($storage_pool_urls) . " dedicated storage pool";
        $results .= '<a href="storage-pools.html?remote='.$remote.'&project='.$project.'" class="stretched-link"></a>';
        $results .= '</div>';
        break;
    }
    echo $results;
  }
}

?>

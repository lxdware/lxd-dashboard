<?php

if (!empty($_SERVER['PHP_AUTH_USER'])) {

  $cert = "/var/lxdware/data/lxd/client.crt";
  $key = "/var/lxdware/data/lxd/client.key";

   //Instantiate the GET variables
  if (isset($_GET['remote']))
    $remote = filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_STRING);
  if (isset($_GET['project']))
    $project = filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING);

  //Determine host info from database
  $db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
  $db_statement = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
  $db_statement->bindValue(':id', $remote);
  $db_results = $db_statement->execute();

  while($row = $db_results->fetchArray()){

    //Retrieve host resource data
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/resources?project=" . $project;
    $resource_api_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    if ($resource_api_data == NULL) {
      echo "<strong>Error</strong>: Unable to connect to host <br /> <br />";
      exit;
    }
    $resource_api_data = json_decode($resource_api_data, true);    
    $resource_data = $resource_api_data['metadata'];
    
    $system_vendor = $resource_data['system']['vendor']?: "N/A"; //example: DigitalOcean, Dell, Etc
    $system_product = $resource_data['system']['product']?: "N/A"; //example: Droplet, R810, Etc
    $architecture = $resource_data['cpu']['architecture']?: "N/A"; //example: x86_64
    $cpus = $resource_data['cpu']['total']?: "N/A"; //total number of cpus
    $sockets = $resource_data['cpu']['sockets']; //array of cpu info per socket
    $storage_disks = $resource_data['storage']['disks']; //array of storage devices
  
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
    $memory_free = $memory_total - $memory_used;

    //Determine the number of running / total instances
    $running_instances = 0;
    $total_instances = 0;
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/instances?recursion=2&project=" . $project;
    $instance_api_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $instance_api_data = json_decode($instance_api_data, true);
    foreach ($instance_api_data['metadata'] as $instance_data){
      if ($instance_data['state']['status'] == "Running"){
        $running_instances++;
      }
      $total_instances++;
    }

    //Retrieve list of images
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/images?project=" . $project;
    $image_api_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $image_api_data = json_decode($image_api_data, true);
    $image_urls = $image_api_data['metadata'];

    //Retrieve list of profiles
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/profiles?project=" . $project;
    $profile_api_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $profile_api_data = json_decode($profile_api_data, true);
    $profile_urls = $profile_api_data['metadata'];

    //Retrieve list of networks
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/networks?project=" . $project;
    $network_api_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $network_api_data = json_decode($network_api_data, true);
    $network_urls = $network_api_data['metadata'];

    //Retrieve list of storage pools
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/storage-pools?project=" . $project;
    $storage_pool_api_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $storage_pool_api_data = json_decode($storage_pool_api_data, true);
    $storage_pool_urls = $storage_pool_api_data['metadata'];

    echo '<div class="row">';
      echo '<div class="col-xl-5 col-lg-5">';

      echo "<strong>System Vendor</strong>: " . htmlentities($system_vendor) . "<br />";
      echo "<strong>System Product</strong>: " . htmlentities($system_product) . "<br />";
      echo "<br />";

      echo "<strong>CPU Information</strong>: <br />";
      echo "<ul>";
      echo "<li><strong>Architecture</strong>: " . htmlentities($architecture) . "</li>";
      echo "<li><strong>CPU Count</strong>: " . htmlentities($cpus) . "</li>";
      foreach($sockets as $socket){
        echo "<li><strong>Socket " . htmlentities($socket['socket']) . "</strong>: " . htmlentities($socket['name']?: "N/A") . "</li>";
      }
      echo "</ul>";

      echo "<strong>Memory Total</strong>: " . htmlentities($memory_total) . " " . $memory_unit . "<br />";
      echo "<strong>Memory Used</strong>: " . htmlentities($memory_used) . " " . $memory_unit . "<br />";
      echo "<br />";

      echo "<strong>Disk Storage Information</strong>: <br />";
      foreach($storage_disks as $disk){
        if ($disk['type'] == "cdrom")
          continue;

        echo "<ul>";
        echo "<li><strong>Disk ID</strong>: " . htmlentities($disk['id']?: "N/A") . "</li>";
        echo "<li><strong>Disk model</strong>: " . htmlentities($disk['model']?: "N/A") . "</li>";
        echo "<li><strong>Disk type</strong>: " . htmlentities($disk['type']?: "N/A") . "</li>";

        if ($disk['size'] < 1099511627776) {
          $disk_total = number_format($disk['size']/1024/1024/1024,2); //disk size in GB
          $disk_unit = "GB";
        }
        else {
          $disk_total = number_format($disk['size']/1024/1024/1024/1024,2); //disk size in TB
          $disk_unit = "TB";
        }

        echo "<li><strong>Disk size</strong>: " . $disk_total . " " . $disk_unit . "</li>";
        echo "</ul>";
      }   

    echo '</div>';


    echo '<!-- Second Column -->';
    echo '<div class="col-xl-3 col-lg-3">';

    echo '<ul class="list-unstyled">';

    echo '<li class="media">';
    echo '<i class="mr-3 mb-5 fas fa-cube fa-2x fa-fw" style="color:#cccccc"></i>';
    echo '<div class="media-body">';
    echo '<h6 class="mt-0 mb-1"><strong><a href="instances.html?remote='.$remote.'&project='.$project.'">Instances</a>:</strong></h6>';
    echo $running_instances . " out of " . $total_instances . " running"  ; 
    echo '</div>';
    echo '</li>';

    echo '<li class="media">';
    echo '<i class="mr-3 mb-5 fas fa-box-open fa-2x fa-fw" style="color:#cccccc"></i>';
    echo '<div class="media-body">';
    echo '<h6 class="mt-0 mb-1"><strong><a href="images.html?remote='.$remote.'&project='.$project.'">Images</a>:</strong></h6>';
    if (count($image_urls) != 1)
      echo count($image_urls) . " images available";
    else
      echo count($image_urls) . " image available";
    echo '</div>';
    echo '</li>';

    echo '<li class="media">';
    echo '<i class="mr-3 mb-5 fas fa-address-card fa-2x fa-fw" style="color:#cccccc"></i>';
    echo '<div class="media-body">';
    echo '<h6 class="mt-0 mb-1"><strong><a href="profiles.html?remote='.$remote.'&project='.$project.'">Profiles</a>:</strong></h6>';
    if (count($profile_urls) != 1)
      echo count($profile_urls) . " profiles created";
    else
      echo count($profile_urls) . " profile created";
    echo '</div>';
    echo '</li>';

    echo '<li class="media">';
    echo '<i class="mr-3 mb-5 fas fa-network-wired fa-2x fa-fw" style="color:#cccccc"></i>';
    echo '<div class="media-body">';
    echo '<h6 class="mt-0 mb-1"><strong><a href="networks.html?remote='.$remote.'&project='.$project.'">Networks</a>:</strong></h6>';
    if (count($network_urls) != 1)
      echo count($network_urls) . " network interfaces";
    else
      echo count($network_urls) . " network interface";
    echo '</div>';
    echo '</li>';

    echo '<li class="media">';
    echo '<i class="mr-3 mb-5 fas fa-hdd fa-2x fa-fw" style="color:#cccccc"></i>';
    echo '<div class="media-body">';
    echo '<h6 class="mt-0 mb-1"><strong><a href="storage-pools.html?remote='.$remote.'&project='.$project.'">Storage Pools</a>:</strong></h6>';
    if (count($storage_pool_urls) != 1)
      echo count($storage_pool_urls) . " dedicated storage pools";
    else
      echo count($storage_pool_urls) . " dedicated storage pool"; 
    echo '</div>';
    echo '</li>';

    echo '</ul>';

    echo '</div>';

    echo '<!-- Donut Chart -->';
    echo '<div class="col-xl-4 col-lg-4">';
    echo '<div class="chart-pie pt-4">';
    echo '<canvas id="memoryDoughnutChart"></canvas>';
    echo '</div>';
    echo '</div>';


  echo '</div>';

  }

}

?>

<script>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Doughnut Pie Chart
var ctx = document.getElementById("memoryDoughnutChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Used Memory (<?php echo $memory_unit;?>)", "Available Memory (<?php echo $memory_unit;?>)"],
    datasets: [{
      data: [<?php echo $memory_used;?>, <?php echo $memory_free;?>],
      backgroundColor: ['#4e73df', '#1cc88a'],
      hoverBackgroundColor: ['#2e59d9', '#17a673'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: true,
      position: 'right',
    },
    title: {
      display: true,
      text: 'Memory Usage',
      fontSize: 18,
    },
    cutoutPercentage: 60,
  },
});
</script>

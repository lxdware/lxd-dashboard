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

  //Host Resource Data
  $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/resources?project=" . $project;
  $resource_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
  if ($resource_data == NULL) {
    echo "<strong>Error</strong>: Unable to connect to host <br /> <br />";
    exit;
  }
  $resource_data = json_decode($resource_data, true);
  $resource_data = $resource_data['metadata'];


  $system_vendor = $resource_data['system']['vendor'];
  $system_product = $resource_data['system']['product'];
  $architecture = $resource_data['cpu']['architecture']; //example: x86
  $cpus = $resource_data['cpu']['total']; //total number of cpus
  $sockets = $resource_data['cpu']['sockets']; //array of cpu info per socket
  $storage_disks = $resource_data['storage']['disks']; //array of storage devices
 
  $memory_total = number_format($resource_data['memory']['total']/1024/1024/1024,2); //total amount of memory used in GB
  $memory_used = number_format($resource_data['memory']['used']/1024/1024/1024,2); //current amount of memory used in GB
  $memory_free = $memory_total - $memory_used;

  $url1 = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/instances?project=" . $project;
  $instance_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url1");
  $instance_data = json_decode($instance_data, true);
  $instance_urls = $instance_data['metadata'];
  $running_instances = 0;
  foreach ($instance_urls as $instance_url){
    $url2 = "https://" . $row['host'] . ":" . $row['port'] . $instance_url . "?project=" . $project;
    $instance_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url2");
    $instance_data = json_decode($instance_data, true);
    $instance_data = $instance_data['metadata'];
    if ($instance_data['status'] == "Running")
      $running_instances++;
  }


  $url3 = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/images?project=" . $project;
  $image_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url3");
  $image_data = json_decode($image_data, true);
  $image_urls = $image_data['metadata'];

  $url4 = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/profiles?project=" . $project;
  $profile_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url4");
  $profile_data = json_decode($profile_data, true);
  $profile_urls = $profile_data['metadata'];

  $url5 = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/networks?project=" . $project;
  $network_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url5");
  $network_data = json_decode($network_data, true);
  $network_urls = $network_data['metadata'];

  $url6 = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/storage-pools?project=" . $project;
  $storage_pool_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url6");
  $storage_pool_data = json_decode($storage_pool_data, true);
  $storage_pool_urls = $storage_pool_data['metadata'];

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
      echo "<li><strong>Socket " . $socket['socket'] . "</strong>: " . $socket['name'] . "</li>";
    }
    echo "</ul>";

    echo "<strong>Memory Total</strong>: " . htmlentities($memory_total) . " GB<br />";
    echo "<strong>Memory Used</strong>: " . htmlentities($memory_used) . " GB<br />";
    echo "<br />";

    echo "<strong>Disk Storage Information</strong>: <br />";
    foreach($storage_disks as $disk){
      if ($disk['type'] == "cdrom")
        continue;
      echo "<ul>";
      echo "<li><strong>Disk ID</strong>: " . $disk['id'] . "</li>";
      echo "<li><strong>Disk model</strong>: " . $disk['model'] . "</li>";
      echo "<li><strong>Disk type</strong>: " . $disk['type'] . "</li>";
      echo "<li><strong>Disk size</strong>: " . number_format($disk['size']/1024/1024/1024,2) . " GB</li>";
      echo "</ul>";
    }   

  echo '</div>';


  echo '<!-- Second Column -->';
  echo '<div class="col-xl-3 col-lg-3">';

  echo '<ul class="list-unstyled">';

  echo '<li class="media" onclick="location.href=\'instances.html?remote='.$remote.'&project='.$project.'\'">';
  echo '<i class="mr-3 mb-5 fas fa-cube fa-2x fa-fw" style="color:#ddd"></i>';
  echo '<div class="media-body">';
  echo '<h6 class="mt-0 mb-1"><strong>Instances:</strong></h6>';
  echo $running_instances . " out of " . count($instance_urls) . " running"  ; 
  echo '</div>';
  echo '</li>';

  echo '<li class="media" onclick="location.href=\'images.html?remote='.$remote.'&project='.$project.'\'">';
  echo '<i class="mr-3 mb-5 fas fa-box-open fa-2x fa-fw" style="color:#ddd"></i>';
  echo '<div class="media-body">';
  echo '<h6 class="mt-0 mb-1"><strong>Images:</strong></h6>';
  if (count($image_urls) != 1)
    echo count($image_urls) . " images available";
  else
    echo count($image_urls) . " image available";
  echo '</div>';
  echo '</li>';

  echo '<li class="media" onclick="location.href=\'profiles.html?remote='.$remote.'&project='.$project.'\'">';
  echo '<i class="mr-3 mb-5 fas fa-address-card fa-2x fa-fw" style="color:#ddd"></i>';
  echo '<div class="media-body">';
  echo '<h6 class="mt-0 mb-1"><strong>Profiles:</strong></h6>';
  echo count($profile_urls) . " profiles created"; 
  echo '</div>';
  echo '</li>';

  echo '<li class="media" onclick="location.href=\'networks.html?remote='.$remote.'&project='.$project.'\'">';
  echo '<i class="mr-3 mb-5 fas fa-network-wired fa-2x fa-fw" style="color:#ddd"></i>';
  echo '<div class="media-body">';
  echo '<h6 class="mt-0 mb-1"><strong>Networks:</strong></h6>';
  if (count($network_urls) != 1)
    echo count($network_urls) . " network interfaces";
  else
    echo count($network_urls) . " network interface";
  echo '</div>';
  echo '</li>';

  echo '<li class="media" onclick="location.href=\'storage-pools.html?remote='.$remote.'&project='.$project.'\'">';
  echo '<i class="mr-3 mb-5 fas fa-hdd fa-2x fa-fw" style="color:#ddd"></i>';
  echo '<div class="media-body">';
  echo '<h6 class="mt-0 mb-1"><strong>Storage Pools:</strong></h6>';
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
    labels: ["Used Memory (GB)", "Available Memory (GB)"],
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

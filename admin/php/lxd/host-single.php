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

  //Instance Data
  $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/resources?project=" . $project;
  $resource_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
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


  echo '<div class="row">';
    echo '<div class="col-xl-6 col-lg-7">';

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


  echo '<!-- Donut Chart -->';
  echo '<div class="col-xl-4 col-lg-5">';
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

<?php

if (isset($_GET['remote']))
  $remote = filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_STRING);
if (isset($_GET['project']))
  $project = filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING);


$cert = "/root/.config/lxc/client.crt";
$key = "/root/.config/lxc/client.key";

$return_url = strtok($_SERVER["HTTP_REFERER"], '?');

$db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
$db_statement = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
$db_statement->bindValue(':id', $remote);
$db_results = $db_statement->execute();

while($row = $db_results->fetchArray()){
  $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/projects";
  $project_results = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
  $project_results = json_decode($project_results, true);
  $project_urls = $project_results['metadata'];


  //echo '<li class="nav-item dropdown no-arrow">';
  echo '<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
  echo '<span class="mr-2 d-none d-lg-inline text-gray-600 small">Project: '. htmlentities($project) . '</span>';
  echo '</a>';
  echo '<!-- Dropdown - User Information -->';
  echo '<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">';

  foreach ($project_urls as $project_url){
    $url = "https://" . $row['host'] . ":" . $row['port'] . $project_url;
    $project_data = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $project_data = json_decode($project_data, true);
    $project_data = $project_data['metadata']; 

   
    if ($project_data['name'] == $project)
      echo '<a class="dropdown-item"  href="'.$return_url.'?remote=' . $remote . '&project=' . $project_data['name'] . '"><i class="fas fa-project-diagram fa-sm fa-fw mr-2 text-gray-400"></i><strong>' . htmlentities($project_data['name']) . '</strong></a>';
    else
      echo '<a class="dropdown-item"  href="'.$return_url.'?remote=' . $remote . '&project=' . $project_data['name'] . '"><i class="fas fa-project-diagram fa-sm fa-fw mr-2 text-gray-400"></i>' . htmlentities($project_data['name']) . '</a>';
  }

  echo '</div>';
 //echo '</li>';


}


?>




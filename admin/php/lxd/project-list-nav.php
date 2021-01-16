<?php

if (!empty($_SERVER['PHP_AUTH_USER'])) {

  if (isset($_GET['remote']))
    $remote = filter_var(urldecode($_GET['remote']), FILTER_SANITIZE_STRING);
  if (isset($_GET['project']))
    $project = filter_var(urldecode($_GET['project']), FILTER_SANITIZE_STRING);


  $cert = "/var/lxdware/data/lxd/client.crt";
  $key = "/var/lxdware/data/lxd/client.key";

  $return_url = strtok($_SERVER["HTTP_REFERER"], '?');

  $db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');
  $db_statement = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
  $db_statement->bindValue(':id', $remote);
  $db_results = $db_statement->execute();

  while($row = $db_results->fetchArray()){
    $url = "https://" . $row['host'] . ":" . $row['port'] . "/1.0/projects?recursion=1";
    $project_results = shell_exec("sudo curl -k -L --cert $cert --key $key -X GET $url");
    $project_results = json_decode($project_results, true);
    $projects = $project_results['metadata'];


    //echo '<li class="nav-item dropdown no-arrow">';
    echo '<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
    echo '<span class="mr-2 d-none d-lg-inline text-gray-600">Project: <strong>'. htmlentities($project) . '</strong></span>';
    echo '</a>';
    echo '<!-- Dropdown - User Information -->';
    echo '<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">';

    foreach ($projects as $project_data){
    
      if ($project_data['name'] == $project)
        echo '<a class="dropdown-item"  href="'.$return_url.'?remote=' . $remote . '&project=' . $project_data['name'] . '"><i class="fas fa-chart-bar fa-sm fa-fw mr-2 text-gray-400"></i><strong>' . htmlentities($project_data['name']) . '</strong></a>';
      else {
        if (basename($return_url) == "instance.html")
          echo '<a class="dropdown-item"  href="instances.html?remote=' . $remote . '&project=' . $project_data['name'] . '"><i class="fas fa-chart-bar fa-sm fa-fw mr-2 text-gray-400"></i>' . htmlentities($project_data['name']) . '</a>';
        else
          echo '<a class="dropdown-item"  href="'.$return_url.'?remote=' . $remote . '&project=' . $project_data['name'] . '"><i class="fas fa-chart-bar fa-sm fa-fw mr-2 text-gray-400"></i>' . htmlentities($project_data['name']) . '</a>';
      }
    }

    echo '</div>';
  //echo '</li>';

  }

}
?>




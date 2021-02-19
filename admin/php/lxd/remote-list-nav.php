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

    if ($row['alias'] != "")
      $display_name = $row['alias'];
    else
      $display_name = $row['host'];



    //echo '<li class="nav-item dropdown no-arrow">';
    echo '<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
    echo '<i class="fas fa-server mr-2 text-gray-600"></i>';
    echo '<span class="mr-2 d-none d-lg-inline text-gray-600">Host: <font class="text-primary">'. htmlentities($display_name) . '</font></span>';
    echo '</a>';
    echo '<!-- Dropdown - User Information -->';
    echo '<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">';

    $db_results2 = $db->query('SELECT * FROM lxd_hosts');
    while($row2 = $db_results2->fetchArray()){

      if ($row2['alias'] != "")
        $display_name2 = $row2['alias'];
      else
        $display_name2 = $row2['host'];
      if ($row2['id'] == $remote)
        echo '<a class="dropdown-item"  href="host.html?remote=' . $row2['id'] . '&project=' . $project . '"><i class="fas fa-server fa-sm fa-fw mr-2 text-gray-900"></i><strong>' . htmlentities($display_name2) . '</strong></a>';
      else
        echo '<a class="dropdown-item"  href="host.html?remote=' . $row2['id'] . '&project=default"><i class="fas fa-server fa-sm fa-fw mr-2 text-gray-600"></i>' . htmlentities($display_name2) . '</a>'; 
    
    }
    echo '</div>';
  //echo '</li>';

  }

}

?>
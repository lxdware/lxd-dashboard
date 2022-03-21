<?php
/*
LXDWARE LXD Dashboard - A web-based interface for managing LXD servers
Copyright (C) 2020-2021  LXDWARE.COM

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

//Start session if not already started
if (!isset($_SESSION)) {
  session_start();
}

//Declare and instantiate GET variables
$action = (isset($_GET['action'])) ? filter_var(urldecode($_GET['action']), FILTER_SANITIZE_STRING) : "";

//Require code from lxd-dashboard/backend/config/db.php
require_once('../config/db.php');

//Require code from lxd-dashboard/backend/aaa/accounting.php
require_once('../aaa/accounting.php');

if (isset($_SESSION['username'])) {

  require_once('../aaa/authorization.php');

  //Run the matching action
  switch ($action) {
    
    case "listLogEvents":
        $logs_retrieval = intval(retrievePreference("logs_retrieval"));
        if ($logs_retrieval < 1){
          $logs_retrieval = 100;
        }

        $rows = retrieveTableRows('lxd_logs', $logs_retrieval);

        $i = 0;
        echo '{ "data": [';

        foreach ($rows as $row){

          if ($i > 0){
            echo ",";
          }
          $i++;

          echo "[ ";

          echo '"';
          echo "<i class='fas fa-history fa-lg' style='color:#4e73df'></i>";
          echo '",';

          echo '"' . htmlentities($row['id']) . '",';
          echo '"' . htmlentities($row['control']) . '",';
          echo '"' . htmlentities($row['remote_id']) . '",';
          echo '"' . htmlentities($row['project']) . '",';
          echo '"' . htmlentities($row['object']) . '",';
          echo '"' . htmlentities($row['status_code']) . '",';
          echo '"' . htmlentities($row['message']) . '",';
          echo '"' . htmlentities($row['hostname']) . '",';
          echo '"' . htmlentities($row['user_id']) . '",';
          echo '"' . htmlentities($row['date']) . '"';

          echo " ]";
        }

        echo " ]}";
        break;

  }
  
}

?>
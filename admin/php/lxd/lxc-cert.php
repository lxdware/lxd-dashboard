<?php

if (!empty($_SERVER['PHP_AUTH_USER'])) {
  $results = shell_exec("cat /var/lxdware/data/lxd/client.crt");
  echo htmlentities($results);
}

?>

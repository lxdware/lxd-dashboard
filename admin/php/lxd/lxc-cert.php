<?php

$results = shell_exec("cat /var/lxdware/data/lxd/client.crt");

echo htmlentities($results);

?>

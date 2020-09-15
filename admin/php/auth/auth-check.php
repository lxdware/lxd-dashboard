<?php

$auth = "false";

if (!empty($_SERVER['PHP_AUTH_USER'])) {
    //header('WWW-Authenticate: Basic realm="My Realm"');
    //header('HTTP/1.0 401 Unauthorized');
    //exit;
    $auth = "true";
}

echo $auth;

?>
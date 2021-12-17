#!/usr/bin/php
<?php

if (!isset($_SERVER['REQUEST_METHOD'])) {
  //Capture command-line arguments
  $file = $argv[1];
  $url = $argv[2];
  $cert = $argv[3];
  $key = $argv[4];

  $fp = fopen($file, "w+");

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FILE, $fp);
  curl_setopt($ch, CURLOPT_SSLCERT, $cert);
  curl_setopt($ch, CURLOPT_SSLKEY, $key);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
  curl_setopt($ch, CURLOPT_TIMEOUT, 0);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $results = curl_exec($ch);
  curl_close($ch);
  fclose($fp);
}

?>
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

//Create Certificate if it does not already exist
if (!file_exists('/var/lxdware/data/lxd/client.crt')){
  $subject = array(
    "commonName" => "LXDWARE",
  );
  
  //Generate a new private (and public) key pair
  $private_key = openssl_pkey_new(array(
    "private_key_type" => OPENSSL_KEYTYPE_EC,
    "curve_name" => 'secp384r1',
  ));
  
  //Generate a certificate signing request
  $csr = openssl_csr_new($subject, $private_key);
  
  //Generate self-signed EC cert
  $x509 = openssl_csr_sign($csr, null, $private_key, $days=3650);
  openssl_x509_export_to_file($x509, '/var/lxdware/data/lxd/client.crt');
  openssl_pkey_export_to_file($private_key, '/var/lxdware/data/lxd/client.key');
  
  //Change permissions on private key
  chmod('/var/lxdware/data/lxd/client.key',0600);
}

if (isset($_SESSION['username'])) {

  //Declare and instantiate GET variables
  $action = (isset($_GET['action'])) ? filter_var(urldecode($_GET['action']), FILTER_SANITIZE_STRING) : "";

  require_once('../aaa/authorization.php');

  //Run the matching action
  switch ($action) {
    case "viewCertificate":
      if (validateAuthorization($action)) {
        $results = shell_exec("cat /var/lxdware/data/lxd/client.crt");
        echo htmlentities($results);
      }
      else {
        echo "You are not authorized to view the certificate";
      }
      break;
  }
}

?>

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

function createCertificate($certificateFilename, $numberofDays = 3650){
  //Only create the certificate if it does not already exist
  if (!file_exists('/var/lxdware/data/lxd/'.$certificateFilename.'.crt')){
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
    $x509 = openssl_csr_sign($csr, null, $private_key, $numberofDays);
    openssl_x509_export_to_file($x509, '/var/lxdware/data/lxd/'.$certificateFilename.'.crt');
    openssl_pkey_export_to_file($private_key, '/var/lxdware/data/lxd/'.$certificateFilename.'.key');
    
    //Change permissions to lock down private key
    chmod('/var/lxdware/data/lxd/'.$certificateFilename.'.key',0600);
  }
}

//Create default client.crt certificate if it does not already exist, ensuring that it is always available to the system, even if deleted. 
createCertificate('client');

if (isset($_SESSION['username'])) {

  //Declare and instantiate GET variables
  $action = (isset($_GET['action'])) ? filter_var(urldecode($_GET['action']), FILTER_SANITIZE_STRING) : "";
  $name = (isset($_GET['name'])) ? filter_var(urldecode($_GET['name']), FILTER_SANITIZE_STRING) : "";
  $days = (isset($_GET['days'])) ? filter_var(urldecode($_GET['days']), FILTER_SANITIZE_NUMBER_INT) : "3650";

  require_once('../aaa/authorization.php');

  //Run the matching action
  switch ($action) {
    case "createCertificateFiles":
      if (validateAuthorization($action)) {
        if (!empty($name)){
          if (!file_exists('/var/lxdware/data/lxd/'.$name.'.crt')){
            createCertificate($name, $days);
            if (file_exists('/var/lxdware/data/lxd/'.$name.'.crt') && file_exists('/var/lxdware/data/lxd/'.$name.'.key'))
              echo '{"status": "Ok", "status_code": 200, "metadata": {"status": "Certificate files created"}}';
            else
              echo '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Unable to create all certificate files"}}';
          }
          else {
            echo '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "A certificate by that name already exists"}}';
          }
        }
        else {
          echo '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "A certificate name must be supplied"}}';
        }
      }
      break;

    case "deleteCertificateFiles":
      if (validateAuthorization($action)) {
        if (!empty($name)){
          unlink('/var/lxdware/data/lxd/'.$name.'.crt');
          unlink('/var/lxdware/data/lxd/'.$name.'.key');
        }
        
        if (file_exists('/var/lxdware/data/lxd/'.$name.'.crt') || file_exists('/var/lxdware/data/lxd/'.$name.'.key'))
          echo '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Unable to remove all certificate files"}}';
        else 
          echo '{"status": "Ok", "status_code": 200, "metadata": {"status": "Certificate files removed"}}';
        
        if ($name == 'client'){
          createCertificate('client');
        }
      }
      break;

    case "listCertificateFiles":
      if (validateAuthorization($action)) {
        $i = 0;
        echo '{ "data": [';
  
        foreach (glob("/var/lxdware/data/lxd/*.crt") as $filename) {
  
          $data = openssl_x509_parse(file_get_contents($filename));
          $validFrom = date('Y-m-d H:i:s', $data['validFrom_time_t']);
          $validTo = date('Y-m-d H:i:s', $data['validTo_time_t']);
  
          if ($i > 0){
            echo ",";
          }
          $i++;
  
          echo "[ ";
          echo '"';
          echo "<i class='fas fa-wallet fa-lg' style='color:#4e73df'></i>";
          echo '",';
          echo '"' . htmlentities(basename($filename)) . '",';
          echo '"' . htmlentities($data['issuer']['CN']) . '",';
          echo '"' . htmlentities($validFrom) . '",';
          echo '"' . htmlentities($validTo) . '",';
  
          echo '"';
          echo "<a href='#' onclick=loadDeleteCertModal('".basename($filename, ".crt")."')><i class='fas fa-trash-alt fa-lg' style='color:#ddd' title='Delete Certificate' aria-hidden='true'></i></a>";
          echo '"';
    
          echo " ]";
        }
    
        echo " ]}";
      }
      break;

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

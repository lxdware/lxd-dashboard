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

//Declare and instantiate GET variables
$action = (isset($_GET['action'])) ? filter_var(urldecode($_GET['action']), FILTER_SANITIZE_STRING) : "";
$database_host = (isset($_GET['database_host'])) ? filter_var(urldecode($_GET['database_host']), FILTER_SANITIZE_STRING) : "";
$database_name = (isset($_GET['database_name'])) ? filter_var(urldecode($_GET['database_name']), FILTER_SANITIZE_STRING) : "";
$database_type = (isset($_GET['database_type'])) ? filter_var(urldecode($_GET['database_type']), FILTER_SANITIZE_STRING) : "";
$database_user = (isset($_GET['database_user'])) ? filter_var(urldecode($_GET['database_user']), FILTER_SANITIZE_STRING) : "";

//Declare and instantiate POST variables
$database_password = (isset($_POST['database_password'])) ? filter_var(urldecode($_POST['database_password']), FILTER_SANITIZE_STRING) : "";

//Require code from lxd-dashboard/php/config/db.php
require_once('../config/db.php');

switch ($action) {
  case "loadLoginForm":
    $showRegistrationForm = false;
    
    if (!file_exists('/var/lxdware/data/db_config.php')){
      $showRegistrationForm = true;
    }
    else {
      if (isFirstUser()){
        $showRegistrationForm = true;
      }
    }

    if ($showRegistrationForm){
      echo '<div class="text-center">';
      echo '<h1 class="h4 text-gray-900 mb-4">REGISTRATION</h1>';
      echo '</div>';

      echo '<div class="form-group">';
      echo '<label>Username:</label>';
      echo '<input type="text" class="form-control" name="username" id="registerUsernameInput" autofocus>';
      echo '</div>';

      echo '<div class="form-group row">';
      echo '<div class="col-sm-6 mb-3 mb-sm-0">';
      echo '<label>Password:</label>';
      echo '<input type="password" class="form-control" name="password" id="registerPasswordInput">';
      echo '</div>';

      echo '<div class="col-sm-6">';
      echo '<label>Repeat Password:</label>';
      echo '<input type="password" class="form-control" name="repeat_password" id="registerRepeatPasswordInput">';
      echo '</div>';
      echo '</div>';

      echo '<div class="form-group">';
      echo '<label>Email:</label>';
      echo '<input type="email" class="form-control" name="email" id="registerEmailInput">';
      echo '</div>';

      echo '<div class="form-group">';
      echo '<label>Database:</label>';
      echo '<select id="registerDatabaseTypeInput" onchange="changeDatabaseInput()" class="form-control" name="registerDatabaseTypeInput">';
      $database_types = retrieveDatabaseTypes();
      foreach( $database_types as $database_type){
          echo '<option value="'.$database_type.'">'.$database_type.'</option>';
      }
      echo '</select>';
      echo '</div>';

      echo '<div class="form-group" id="registerDatabaseHostDiv" style="display: none;">';
      echo '<label>Database Host:</label>';
      echo '<input type="text" class="form-control" name="database_host" id="registerDatabaseHostInput">';
      echo '</div>';

      echo '<div class="form-group" id="registerDatabaseNameDiv" style="display: none;">';
      echo '<label>Database Name:</label>';
      echo '<input type="text" class="form-control" name="database_name" id="registerDatabaseNameInput">';
      echo '</div>';

      echo '<div class="form-group" id="registerDatabaseUserDiv" style="display: none;">';
      echo '<label>Database User:</label>';
      echo '<input type="text" class="form-control" name="database_user" id="registerDatabaseUserInput">';
      echo '</div>';

      echo '<div class="form-group" id="registerDatabasePasswordDiv" style="display: none;">';
      echo '<label>Database Password:</label>';
      echo '<input type="password" class="form-control" name="database_password" id="registerDatabasePasswordInput">';
      echo '</div>';

      echo '<input type="submit" class="btn btn-primary btn-block" id="registerInputButton" onclick="registerUser()" value="Register Account">';
    }
    else {
      echo '<div class="text-center">';
      echo '<h1 class="h4 text-gray-900 mb-4">LOGIN</h1>';
      echo '</div>';

      echo '<div class="form-group">';
      echo '<label>Username:</label>';
      echo '<input type="text" class="form-control" name="username" id="loginUsernameInput" aria-describedby="usernameHelp" autofocus>';
      echo '</div>';
      
      echo '<div class="form-group">';
      echo '<label>Password:</label>';
      echo '<input type="password" class="form-control" name="password" id="loginPasswordInput">';
      echo '</div>';
      
      echo '<div class="form-group">';
      echo '<label></label>';
      echo '<input type="submit" class="btn btn-primary btn-block" id="loginInputButton" onclick="loginUser()" value="Login">';
      echo '</div>';
    }
    
    break;
  
  case "writeDatabaseConfig":
    
    if (!file_exists('/var/lxdware/data/db_config.php')){
      if ($database_type == 'sqlite'){
        try {
          $conn = new PDO('sqlite:/var/lxdware/data/sqlite/lxdware.sqlite');
          $db = null;
        }
        catch (PDOException $e){
          echo '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "'.$e->getMessage().'"}}';
          break;
        }
        
        $file = fopen("/var/lxdware/data/db_config.php", "w") or die('{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Unable to write database configuration file"}}');
        $txt = "<?php\n";
        $txt .= "define( 'DB_TYPE', 'sqlite' );\n";
        $txt .= "define( 'DB_NAME', '' );\n";
        $txt .= "define( 'DB_USER', '' );\n";
        $txt .= "define( 'DB_PASSWORD', '' );\n";
        $txt .= "define( 'DB_HOST', '' );\n";
        $txt .= "?>";
        fwrite($file, $txt);
        fclose($file);
        chmod('/var/lxdware/data/db_config.php',0600);
      }

      if ($database_type == 'mysql'){
        try {
          $conn = new PDO("mysql:host=$database_host;dbname=$database_name", $database_user, $database_password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db = null;
        }
        catch (PDOException $e){
          echo '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Database connection error: '.$e->getMessage().'"}}';
          break;
        }

        $file = fopen("/var/lxdware/data/db_config.php", "w") or die('{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Unable to write database configuration file"}}');
        $txt = "<?php\n";
        $txt .= "define( 'DB_TYPE', 'mysql' );\n";
        $txt .= "define( 'DB_NAME', '$database_name' );\n";
        $txt .= "define( 'DB_USER', '$database_user' );\n";
        $txt .= "define( 'DB_PASSWORD', '$database_password' );\n";
        $txt .= "define( 'DB_HOST', '$database_host' );\n";
        $txt .= "?>";
        fwrite($file, $txt);
        fclose($file);
        chmod('/var/lxdware/data/db_config.php',0600);
      }

      echo '{"status": "Ok", "status_code": 200, "metadata": "{}"}';
    }
    else {
      echo '{"status": "Bad Request", "status_code": 400, "metadata": {"error": "Database config file \'/var/lxdware/data/db_config.php\' already exists"}}';
    }

    break;
}

?>
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

function in_array_r($needle, $haystacks){
  foreach ($haystacks as $haystack){
    if (in_array($needle, $haystack)){
      return true;
    }
  }
  return false;
}
  
function establishDatabaseConnection(){

  //Require db_config.php file
  require_once('/var/lxdware/data/db_config.php');

  switch (DB_TYPE) {
    case "sqlite":
      $_SESSION['db_type'] = "SQLite";
      $conn = new PDO('sqlite:/var/lxdware/data/sqlite/lxdware.sqlite');
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //needed for catch backward compatability with PHP 7
      break;
    case "mysql":
      $_SESSION['db_type'] = "MySQL";
      $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //needed for catch backward compatability with PHP 7
      break;
  }
  
  return $conn;
}

/*
===================================================================================
Initialize Table Functions
===================================================================================
*/
function initializeLogsTable(){
  $db = establishDatabaseConnection();

  if ($_SESSION['db_type'] == "SQLite"){
    $db->exec('CREATE TABLE IF NOT EXISTS lxd_logs (id INTEGER PRIMARY KEY AUTOINCREMENT, control TEXT, remote_id INTEGER, project TEXT, object TEXT, status_code INT, message TEXT, hostname TEXT, user_id INT, date DATETIME);');
  }

  if ($_SESSION['db_type'] == "MySQL"){
    $db->exec('CREATE TABLE IF NOT EXISTS lxd_logs (id INTEGER PRIMARY KEY AUTO_INCREMENT, control VARCHAR(255), remote_id INTEGER, project VARCHAR(255), object VARCHAR(255), status_code INT, message VARCHAR(255), hostname VARCHAR(255), user_id INT, date DATE);');
  }

  $db = null;
}

function initializePreferencesTable(){
  $db = establishDatabaseConnection();

  if ($_SESSION['db_type'] == "SQLite"){
    $db->exec('CREATE TABLE IF NOT EXISTS lxd_preferences (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, value TEXT);');
  }

  if ($_SESSION['db_type'] == "MySQL"){
    $db->exec('CREATE TABLE IF NOT EXISTS lxd_preferences (id INTEGER PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255), value VARCHAR(255));');
  }

  //Default Preferences
  $logs_enabled = false;
  $logs_retrieval = false;
  
  $get_connection_timeout = false;
  $get_operation_timeout = false;
  $post_connection_timeout = false;
  $post_operation_timeout = false;
  $patch_connection_timeout = false;
  $patch_operation_timeout = false;
  $put_connection_timeout = false;
  $put_operation_timeout = false;
  $delete_connection_timeout = false;
  $delete_operation_timeout = false;

  $certificates_page_rate = false;
  $cluster_members_page_rate = false;
  $containers_page_rate = false;
  $containers_single_page_rate = false;
  $images_page_rate = false;
  $logs_page_rate = false;
  $network_acls_page_rate = false;
  $networks_page_rate = false;
  $operations_page_rate = false;
  $profiles_page_rate = false;
  $projects_page_rate = false;
  $remotes_single_page_rate = false;
  $remotes_page_rate = false;
  $simplestreams_page_rate = false;
  $storage_pools_page_rate = false;
  $storage_volumes_page_rate = false;
  $virtual_machines_page_rate = false;
  $virtual_machines_single_page_rate = false;


  //Check for default preferences
  $rows = $db->query('SELECT * from lxd_preferences');
  foreach ($rows as $row){
    if ($row['name'] == "logs_enabled")
      $logs_enabled = true;
    if ($row['name'] == "logs_retrieval")
      $logs_retrieval = true;
    if ($row['name'] == "get_connection_timeout")
      $get_connection_timeout = true;
    if ($row['name'] == "get_operation_timeout")
      $get_operation_timeout = true;
    if ($row['name'] == "post_connection_timeout")
      $post_connection_timeout = true;
    if ($row['name'] == "post_operation_timeout")
      $post_operation_timeout = true;
    if ($row['name'] == "patch_connection_timeout")
      $patch_connection_timeout = true;
    if ($row['name'] == "patch_operation_timeout")
      $patch_operation_timeout = true;
    if ($row['name'] == "put_connection_timeout")
      $put_connection_timeout = true;
    if ($row['name'] == "put_operation_timeout")
      $put_operation_timeout = true;
    if ($row['name'] == "delete_connection_timeout")
      $delete_connection_timeout = true;
    if ($row['name'] == "delete_operation_timeout")
      $delete_operation_timeout = true;
    if ($row['name'] == "certificates_page_rate")
      $certificates_page_rate = true;
    if ($row['name'] == "cluster_members_page_rate")
      $cluster_members_page_rate = true;
    if ($row['name'] == "containers_page_rate")
      $containers_page_rate = true;
    if ($row['name'] == "containers_single_page_rate")
      $containers_single_page_rate = true;
    if ($row['name'] == "images_page_rate")
      $images_page_rate = true;
    if ($row['name'] == "logs_page_rate")
      $logs_page_rate = true;
    if ($row['name'] == "network_acls_page_rate")
      $network_acls_page_rate = true;
    if ($row['name'] == "networks_page_rate")
      $networks_page_rate = true;
    if ($row['name'] == "operations_page_rate")
      $operations_page_rate = true;
    if ($row['name'] == "profiles_page_rate")
      $profiles_page_rate = true;
    if ($row['name'] == "projects_page_rate")
      $projects_page_rate = true;
    if ($row['name'] == "remotes_single_page_rate")
      $remotes_single_page_rate = true;
    if ($row['name'] == "remotes_page_rate")
      $remotes_page_rate = true;
    if ($row['name'] == "simplestreams_page_rate")
      $simplestreams_page_rate = true;
    if ($row['name'] == "storage_pools_page_rate")
      $storage_pools_page_rate = true;
    if ($row['name'] == "storage_volumes_page_rate")
      $storage_volumes_page_rate = true;
    if ($row['name'] == "virtual_machines_page_rate")
      $virtual_machines_page_rate = true;
    if ($row['name'] == "virtual_machines_single_page_rate")
      $virtual_machines_single_page_rate = true;
  }

  //Set default preferences
  if (!$logs_enabled){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("logs_enabled", "true");');
  }
  if (!$logs_retrieval){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("logs_retrieval", "100");');
  }
  if (!$get_connection_timeout){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("get_connection_timeout", "3");');
  }
  if (!$get_operation_timeout){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("get_operation_timeout", "5");');
  }
  if (!$post_connection_timeout){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("post_connection_timeout", "3");');
  }
  if (!$post_operation_timeout){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("post_operation_timeout", "5");');
  }
  if (!$patch_connection_timeout){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("patch_connection_timeout", "3");');
  }
  if (!$patch_operation_timeout){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("patch_operation_timeout", "5");');
  }
  if (!$put_connection_timeout){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("put_connection_timeout", "3");');
  }
  if (!$put_operation_timeout){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("put_operation_timeout", "5");');
  }
  if (!$delete_connection_timeout){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("delete_connection_timeout", "3");');
  }
  if (!$delete_operation_timeout){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("delete_operation_timeout", "5");');
  }
  if (!$certificates_page_rate){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("certificates_page_rate", "5");');
  }
  if (!$cluster_members_page_rate){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("cluster_members_page_rate", "5");');
  }
  if (!$containers_page_rate){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("containers_page_rate", "5");');
  }
  if (!$containers_single_page_rate){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("containers_single_page_rate", "5");');
  }
  if (!$images_page_rate){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("images_page_rate", "5");');
  }
  if (!$logs_page_rate){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("logs_page_rate", "5");');
  }
  if (!$network_acls_page_rate){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("network_acls_page_rate", "5");');
  }
  if (!$networks_page_rate){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("networks_page_rate", "5");');
  }
  if (!$operations_page_rate){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("operations_page_rate", "3");');
  }
  if (!$profiles_page_rate){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("profiles_page_rate", "5");');
  }
  if (!$projects_page_rate){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("projects_page_rate", "5");');
  }
  if (!$remotes_single_page_rate){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("remotes_single_page_rate", "10");');
  }
  if (!$remotes_page_rate){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("remotes_page_rate", "5");');
  }
  if (!$simplestreams_page_rate){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("simplestreams_page_rate", "5");');
  }
  if (!$storage_pools_page_rate){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("storage_pools_page_rate", "5");');
  }
  if (!$storage_volumes_page_rate){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("storage_volumes_page_rate", "5");');
  }
  if (!$virtual_machines_page_rate){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("virtual_machines_page_rate", "5");');
  }
  if (!$virtual_machines_single_page_rate){
    $db->exec('INSERT INTO lxd_preferences (name, value) VALUES ("virtual_machines_single_page_rate", "5");');
  }
  
  $db = null;
}

function initializeHostsTable(){
  $db = establishDatabaseConnection();

  if ($_SESSION['db_type'] == "SQLite"){
    $db->exec('CREATE TABLE IF NOT EXISTS lxd_hosts (id INTEGER PRIMARY KEY AUTOINCREMENT, host TEXT NOT NULL, port INTEGER NOT NULL, alias TEXT, protocol TEXT, external_host TEXT, external_port INTEGER, user_id INTEGER);');
    
    //If needed, upgrade database table schema from LXD Dashboard version 1.x.x and 2.x.x to 3.x.x
    $stmt = $db->query("PRAGMA table_info(lxd_hosts);");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!in_array_r('external_host', $results)){
      $stmt = $db->query("ALTER TABLE lxd_hosts ADD COLUMN external_host TEXT;");
    }
    if (!in_array_r('external_port', $results)){
      $stmt = $db->query("ALTER TABLE lxd_hosts ADD COLUMN external_port INTEGER;");
    }
    if (!in_array_r('user_id', $results)){
      $stmt = $db->query("ALTER TABLE lxd_hosts ADD COLUMN user_id INTEGER;");
      $stmt = $db->query("UPDATE lxd_hosts SET user_id = 0;");
    }
      
  }

  if ($_SESSION['db_type'] == "MySQL"){
    $db->exec('CREATE TABLE IF NOT EXISTS lxd_hosts (id INTEGER PRIMARY KEY AUTO_INCREMENT, host VARCHAR(255) NOT NULL, port INTEGER NOT NULL, alias VARCHAR(255), protocol VARCHAR(255), external_host VARCHAR(255), external_port INTEGER, user_id INTEGER);');
  }

  $db = null;
}

function initializeGroupsRolesMappingTable(){
  $db = establishDatabaseConnection();

  if ($_SESSION['db_type'] == "SQLite"){
    $db->exec('CREATE TABLE IF NOT EXISTS lxd_groups_roles_mapping (id INTEGER PRIMARY KEY AUTOINCREMENT, group_id INTEGER NOT NULL, role_id INTEGER NOT NULL);');
  }

  if ($_SESSION['db_type'] == "MySQL"){
    $db->exec('CREATE TABLE IF NOT EXISTS lxd_groups_roles_mapping (id INTEGER PRIMARY KEY AUTO_INCREMENT, group_id INTEGER NOT NULL, role_id INTEGER NOT NULL);');
  }

  //Map admin group to ADMIN role
  $group_id = retrieveGroupId('admin');
  $role_id = retrieveRoleId('ADMIN');

  $stmt = $db->prepare('SELECT COUNT(*) FROM lxd_groups_roles_mapping WHERE group_id = :group_id AND role_id = :role_id;');
  $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
  $stmt->bindValue(':role_id', $role_id, PDO::PARAM_INT);
  $stmt->execute();
  $count = $stmt->fetchColumn();

  if ($count == 0 ){
    $stmt = $db->prepare('INSERT INTO lxd_groups_roles_mapping (group_id, role_id) VALUES (:group_id, :role_id);');
    $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
    $stmt->bindValue(':role_id', $role_id, PDO::PARAM_INT);
    $stmt->execute();
    $return_val = $stmt->fetchColumn();
  }

  //Map operator group to OPERATOR role
  $group_id = retrieveGroupId('operator');
  $role_id = retrieveRoleId('OPERATOR');

  $stmt = $db->prepare('SELECT COUNT(*) FROM lxd_groups_roles_mapping WHERE group_id = :group_id AND role_id = :role_id;');
  $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
  $stmt->bindValue(':role_id', $role_id, PDO::PARAM_INT);
  $stmt->execute();
  $count = $stmt->fetchColumn();

  if ($count == 0 ){
    $stmt = $db->prepare('INSERT INTO lxd_groups_roles_mapping (group_id, role_id) VALUES (:group_id, :role_id);');
    $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
    $stmt->bindValue(':role_id', $role_id, PDO::PARAM_INT);
    $stmt->execute();
    $return_val = $stmt->fetchColumn();
  }

  //Map user group to USER role
  $group_id = retrieveGroupId('user');
  $role_id = retrieveRoleId('USER');

  $stmt = $db->prepare('SELECT COUNT(*) FROM lxd_groups_roles_mapping WHERE group_id = :group_id AND role_id = :role_id;');
  $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
  $stmt->bindValue(':role_id', $role_id, PDO::PARAM_INT);
  $stmt->execute();
  $count = $stmt->fetchColumn();

  if ($count == 0 ){
    $stmt = $db->prepare('INSERT INTO lxd_groups_roles_mapping (group_id, role_id) VALUES (:group_id, :role_id);');
    $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
    $stmt->bindValue(':role_id', $role_id, PDO::PARAM_INT);
    $stmt->execute();
    $return_val = $stmt->fetchColumn();
  }

  //Map auditor group to AUDITOR role
  $group_id = retrieveGroupId('auditor');
  $role_id = retrieveRoleId('AUDITOR');

  $stmt = $db->prepare('SELECT COUNT(*) FROM lxd_groups_roles_mapping WHERE group_id = :group_id AND role_id = :role_id;');
  $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
  $stmt->bindValue(':role_id', $role_id, PDO::PARAM_INT);
  $stmt->execute();
  $count = $stmt->fetchColumn();

  if ($count == 0 ){
    $stmt = $db->prepare('INSERT INTO lxd_groups_roles_mapping (group_id, role_id) VALUES (:group_id, :role_id);');
    $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
    $stmt->bindValue(':role_id', $role_id, PDO::PARAM_INT);
    $stmt->execute();
    $return_val = $stmt->fetchColumn();
  }


  $db = null;
}

function initializeGroupsTable(){
  $db = establishDatabaseConnection();

  if ($_SESSION['db_type'] == "SQLite"){
    $db->exec('CREATE TABLE IF NOT EXISTS lxd_groups (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL UNIQUE, description TEXT);');
  }

  if ($_SESSION['db_type'] == "MySQL"){
    $db->exec('CREATE TABLE IF NOT EXISTS lxd_groups (id INTEGER PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255) NOT NULL UNIQUE, description VARCHAR(255));');
  }

  $adminGroupExists = false;
  $operatorGroupExists = false;
  $userGroupExists = false;
  $auditorGroupExists = false;

  $rows = $db->query('SELECT * FROM lxd_groups');
  foreach ($rows as $row){
    if ($row['name'] == "admin")
      $adminGroupExists = true;

    if ($row['name'] == "operator")
      $operatorGroupExists = true;

    if ($row['name'] == "user")
      $userGroupExists = true;

    if ($row['name'] == "auditor")
      $auditorGroupExists = true;
  }

  if (!$adminGroupExists){
    $db->exec('INSERT INTO lxd_groups (name, description) VALUES ("admin", "Default group granting users the ADMIN role permissions");');
  }

  if (!$operatorGroupExists){
    $db->exec('INSERT INTO lxd_groups (name, description) VALUES ("operator", "Default group granting users the OPERATOR role permissions");');
  }

  if (!$userGroupExists){
    $db->exec('INSERT INTO lxd_groups (name, description) VALUES ("user", "Default group granting users the USER role permissions");');
  }

  if (!$auditorGroupExists){
    $db->exec('INSERT INTO lxd_groups (name, description) VALUES ("auditor", "Default group granting users the AUDITOR role permissions");');
  }

  $db = null;
}

function initializeRolesTable(){
  $db = establishDatabaseConnection();

  if ($_SESSION['db_type'] == "SQLite"){
    $db->exec('CREATE TABLE IF NOT EXISTS lxd_roles (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL UNIQUE, description TEXT);');
  }

  if ($_SESSION['db_type'] == "MySQL"){
    $db->exec('CREATE TABLE IF NOT EXISTS lxd_roles (id INTEGER PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255) NOT NULL UNIQUE, description VARCHAR(255));');
  }

  //Default Roles
  $adminRoleExists = false;
  $operatorRoleExists = false;
  $userRoleExists = false;
  $auditorRoleExists = false;

  //Extended Roles
  $certificateOperatorRoleExists = false;
  $clusterMemeberOperatorRoleExists = false;
  $imageOperatorRoleExists = false;
  $instanceOperatorRoleExists = false;
  $networkOperatorRoleExists = false;
  $operationOperatorRoleExists = false;
  $profileOperatorRoleExists = false;
  $projectOperatorRoleExists = false;
  $remoteOperatorRoleExists = false;
  $simplestreamsOperatorRoleExists = false;
  $storagePoolOperatorRoleExists = false;
  $storageVolumeOperatorRoleExists = false;

  $rows = $db->query('SELECT * from lxd_roles');
  foreach ($rows as $row){
    //Default Roles
    if ($row['name'] == "ADMIN")
      $adminRoleExists = true;

    if ($row['name'] == "OPERATOR")
      $operatorRoleExists = true;

    if ($row['name'] == "USER")
      $userRoleExists = true;

    if ($row['name'] == "AUDITOR")
      $auditorRoleExists = true;

    //Extended Roles
    if ($row['name'] == "CERTIFICATE_OPERATOR")
      $certificateOperatorRoleExists = true;

    if ($row['name'] == "CLUSTER_MEMBER_OPERATOR")
      $clusterMemeberOperatorRoleExists = true;

    if ($row['name'] == "IMAGE_OPERATOR")
      $imageOperatorRoleExists = true;

    if ($row['name'] == "INSTANCE_OPERATOR")
      $instanceOperatorRoleExists = true;

    if ($row['name'] == "NETWORK_OPERATOR")
      $networkOperatorRoleExists = true;

    if ($row['name'] == "OPERATION_OPERATOR")
      $operationOperatorRoleExists = true;

    if ($row['name'] == "PROFILE_OPERATOR")
      $profileOperatorRoleExists = true;

    if ($row['name'] == "PROJECT_OPERATOR")
      $projectOperatorRoleExists = true;

    if ($row['name'] == "REMOTE_OPERATOR")
      $remoteOperatorRoleExists = true;

    if ($row['name'] == "SIMPLESTREAMS_OPERATOR")
      $simplestreamsOperatorRoleExists = true;

    if ($row['name'] == "STORAGE_POOL_OPERATOR")
      $storagePoolOperatorRoleExists = true;

    if ($row['name'] == "STORAGE_VOLUME_OPERATOR")
      $storageVolumeOperatorRoleExists = true;
  }

  //Default Roles
  if (!$adminRoleExists){
    $db->exec('INSERT INTO lxd_roles (name, description) VALUES ("ADMIN", "Administer users, groups, and all LXD services");');
  }

  if (!$operatorRoleExists){
    $db->exec('INSERT INTO lxd_roles (name, description) VALUES ("OPERATOR", "Administer all LXD services");');
  }

  if (!$userRoleExists){
    $db->exec('INSERT INTO lxd_roles (name, description) VALUES ("USER", "Perform basic lifecycle tasks of instances");');
  }
  
  if (!$auditorRoleExists){
    $db->exec('INSERT INTO lxd_roles (name, description) VALUES ("AUDITOR", "View resources");');
  }

  //Extended Roles
  if (!$certificateOperatorRoleExists){
    $db->exec('INSERT INTO lxd_roles (name, description) VALUES ("CERTIFICATE_OPERATOR", "Permissions include adding, deleting, and updating certificates");');
  }

  if (!$clusterMemeberOperatorRoleExists){
    $db->exec('INSERT INTO lxd_roles (name, description) VALUES ("CLUSTER_MEMBER_OPERATOR", "Permissions include removing cluster members");');
  }

  if (!$imageOperatorRoleExists){
    $db->exec('INSERT INTO lxd_roles (name, description) VALUES ("IMAGE_OPERATOR", "Permissions include downloading, editing, and deleteing images");');
  }

  if (!$instanceOperatorRoleExists){
    $db->exec('INSERT INTO lxd_roles (name, description) VALUES ("INSTANCE_OPERATOR", "Permissions include creating, deleting, and updating instances");');
  }

  if (!$networkOperatorRoleExists){
    $db->exec('INSERT INTO lxd_roles (name, description) VALUES ("NETWORK_OPERATOR", "Permissions include creating, deleting, and updating networks and network ACLs");');
  }

  if (!$operationOperatorRoleExists){
    $db->exec('INSERT INTO lxd_roles (name, description) VALUES ("OPERATION_OPERATOR", "Permissions include deleting operations");');
  }

  if (!$profileOperatorRoleExists){
    $db->exec('INSERT INTO lxd_roles (name, description) VALUES ("PROFILE_OPERATOR", "Permissions include creating, deleting, and updating profiles");');
  }

  if (!$projectOperatorRoleExists){
    $db->exec('INSERT INTO lxd_roles (name, description) VALUES ("PROJECT_OPERATOR", "Permissions include creating, deleting, and updating projects");');
  }

  if (!$remoteOperatorRoleExists){
    $db->exec('INSERT INTO lxd_roles (name, description) VALUES ("REMOTE_OPERATOR", "Permissions include adding and removing remote LXD hosts");');
  }

  if (!$simplestreamsOperatorRoleExists){
    $db->exec('INSERT INTO lxd_roles (name, description) VALUES ("SIMPLESTREAMS_OPERATOR", "Permissions include adding and removing remote Simplestreams hosts");');
  }

  if (!$storagePoolOperatorRoleExists){
    $db->exec('INSERT INTO lxd_roles (name, description) VALUES ("STORAGE_POOL_OPERATOR", "Permissions include creating, deleting, and updating storage pools");');
  }

  if (!$storageVolumeOperatorRoleExists){
    $db->exec('INSERT INTO lxd_roles (name, description) VALUES ("STORAGE_VOLUME_OPERATOR", "Permissions include creating, deleting, and updating storge volumes");');
  }

  $db = null;
}

function initializeSimplestreamsTable(){
  $db = establishDatabaseConnection();

  if ($_SESSION['db_type'] == "SQLite"){
    $db->exec('CREATE TABLE IF NOT EXISTS lxd_simplestreams (id INTEGER PRIMARY KEY AUTOINCREMENT, host TEXT NOT NULL, alias TEXT, protocol TEXT, user_id INTEGER);');

    //If needed, upgrade database table schema from LXD Dashboard version 1.x.x to 2.x.x
    $stmt = $db->query("PRAGMA table_info(lxd_simplestreams)");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!in_array_r('user_id', $results)){
      $stmt = $db->query("ALTER TABLE lxd_simplestreams ADD COLUMN user_id INTEGER;");
      $stmt = $db->query("UPDATE lxd_simplestreams SET user_id = 0;");
    }
  }

  if ($_SESSION['db_type'] == "MySQL"){
    $db->exec('CREATE TABLE IF NOT EXISTS lxd_simplestreams (id INTEGER PRIMARY KEY AUTO_INCREMENT, host VARCHAR(255) NOT NULL, alias VARCHAR(255), protocol VARCHAR(255), user_id INTEGER);');
  }
  
  $imagesSimplestreamsExists = false;
  $ubuntuSimplestreamsExists = false;
  $ubuntuDailySimplestreamsExists = false;

  $rows = $db->query('SELECT * FROM lxd_simplestreams;');
  foreach ($rows as $row){
    if ($row['host'] == "https://images.linuxcontainers.org")
      $imagesSimplestreamsExists = true;

    if ($row['host'] == "https://cloud-images.ubuntu.com/releases")
      $ubuntuSimplestreamsExists = true;

    if ($row['host'] == "https://cloud-images.ubuntu.com/daily")
      $ubuntuDailySimplestreamsExists = true;
  }

  if (!$imagesSimplestreamsExists){
    $db->exec('INSERT INTO lxd_simplestreams (host, alias, protocol, user_id) VALUES ("https://images.linuxcontainers.org", "images", "simplestreams", 0);');
  }

  if (!$ubuntuSimplestreamsExists){
    $db->exec('INSERT INTO lxd_simplestreams (host, alias, protocol, user_id) VALUES ("https://cloud-images.ubuntu.com/releases", "ubuntu", "simplestreams", 0);');
  }

  if (!$ubuntuDailySimplestreamsExists){
    $db->exec('INSERT INTO lxd_simplestreams (host, alias, protocol, user_id) VALUES ("https://cloud-images.ubuntu.com/daily", "ubuntu-daily", "simplestreams", 0);');
  }

  $db = null;

}

function initializeUsersGroupsMappingTable(){
  $db = establishDatabaseConnection();

  if ($_SESSION['db_type'] == "SQLite"){
    $db->exec('CREATE TABLE IF NOT EXISTS lxd_users_groups_mapping (id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER NOT NULL, group_id INTEGER NOT NULL);');
  }

  if ($_SESSION['db_type'] == "MySQL"){
    $db->exec('CREATE TABLE IF NOT EXISTS lxd_users_groups_mapping (id INTEGER PRIMARY KEY AUTO_INCREMENT, user_id INTEGER NOT NULL, group_id INTEGER NOT NULL);');
  }
  
  $db = null;
}

function initializeUsersTable(){
  $db = establishDatabaseConnection();

  if ($_SESSION['db_type'] == "SQLite"){
    $db->exec('CREATE TABLE IF NOT EXISTS lxd_users (id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT NOT NULL UNIQUE, first_name TEXT, last_name TEXT, passwd_hash TEXT NOT NULL, email TEXT, type TEXT);');
  }
  
  if ($_SESSION['db_type'] == "MySQL"){
    $db->exec('CREATE TABLE IF NOT EXISTS lxd_users (id INTEGER PRIMARY KEY AUTO_INCREMENT, username VARCHAR(255) NOT NULL UNIQUE, first_name VARCHAR(255), last_name VARCHAR(255), passwd_hash VARCHAR(255) NOT NULL, email VARCHAR(255), type VARCHAR(255));');
  }

  $db = null;
}

function initializeAllTables(){
  initializeUsersTable();
  initializeGroupsTable();
  initializeRolesTable();
  initializeHostsTable();
  initializeSimplestreamsTable();
  initializeUsersGroupsMappingTable();
  initializeGroupsRolesMappingTable();
  initializeLogsTable();
  initializePreferencesTable();
}
/*
===================================================================================
Add Record to Table Functions
=================================================================================== 
*/

function addLogEvent($control, $remote_id, $project, $object, $status_code, $message, $hostname, $user_id){
  $db = establishDatabaseConnection();

  try{
    $stmt = null;
    if ($_SESSION['db_type'] == "SQLite"){
      $stmt = $db->prepare("INSERT INTO lxd_logs (control, remote_id, project, object, status_code, message, hostname, user_id, date) VALUES (:control, :remote_id, :project, :object, :status_code, :message, :hostname, :user_id, datetime('now'));");
    }
    
    if ($_SESSION['db_type'] == "MySQL"){
      $stmt = $db->prepare("INSERT INTO lxd_logs (control, remote_id, project, object, status_code, message, hostname, user_id, date) VALUES (:control, :remote_id, :project, :object, :status_code, :message, :hostname, :user_id, DATE(NOW()));");
    }
    $stmt->bindValue(':control', $control, PDO::PARAM_STR);
    $stmt->bindValue(':remote_id', $remote_id, PDO::PARAM_INT);
    $stmt->bindValue(':project', $project, PDO::PARAM_STR);
    $stmt->bindValue(':object', $object, PDO::PARAM_STR);
    $stmt->bindValue(':status_code', $status_code, PDO::PARAM_INT);
    $stmt->bindValue(':message', $message, PDO::PARAM_STR);
    $stmt->bindValue(':hostname', $hostname, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    if ($_SESSION['db_type'] == "SQLite"){
      $stmt = $db->prepare("INSERT INTO lxd_logs (control, remote_id, project, object, status_code, message, hostname, user_id, date) VALUES (:control, :remote_id, :project, :object, :status_code, :message, :hostname, :user_id, datetime('now'));");
    }
    
    if ($_SESSION['db_type'] == "MySQL"){
      $stmt = $db->prepare("INSERT INTO lxd_logs (control, remote_id, project, object, status_code, message, hostname, user_id, date) VALUES (:control, :remote_id, :project, :object, :status_code, :message, :hostname, :user_id, DATE(NOW()));");
    }
    $stmt->bindValue(':control', $control, PDO::PARAM_STR);
    $stmt->bindValue(':remote_id', $remote_id, PDO::PARAM_INT);
    $stmt->bindValue(':project', $project, PDO::PARAM_STR);
    $stmt->bindValue(':object', $object, PDO::PARAM_STR);
    $stmt->bindValue(':status_code', $status_code, PDO::PARAM_INT);
    $stmt->bindValue(':message', $message, PDO::PARAM_STR);
    $stmt->bindValue(':hostname', $hostname, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  $db = null;
  return $stmt;
}

function addHost($host, $port, $alias, $external_host, $external_port){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('INSERT INTO lxd_hosts (host, port, alias, protocol, external_host, external_port, user_id) VALUES (:host, :port, :alias, "lxd", :external_host, :external_port, :user_id);');
    $stmt->bindValue(':host', $host, PDO::PARAM_STR);
    $stmt->bindValue(':port', $port, PDO::PARAM_INT);
    $stmt->bindValue(':alias', $alias, PDO::PARAM_STR);
    $stmt->bindValue(':external_host', $external_host, PDO::PARAM_STR);
    $stmt->bindValue(':external_port', $external_port, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('INSERT INTO lxd_hosts (host, port, alias, protocol, external_host, external_port, user_id) VALUES (:host, :port, :alias, "lxd", :external_host, :external_port, :user_id);');
    $stmt->bindValue(':host', $host, PDO::PARAM_STR);
    $stmt->bindValue(':port', $port, PDO::PARAM_INT);
    $stmt->bindValue(':alias', $alias, PDO::PARAM_STR);
    $stmt->bindValue(':external_host', $external_host, PDO::PARAM_STR);
    $stmt->bindValue(':external_port', $external_port, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
  }

  $db = null;
  return $stmt;
}

function addSimplestreams($host, $alias){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('INSERT INTO lxd_simplestreams (host, alias, protocol, user_id) VALUES (:host, :alias, "simplestreams", :user_id);');
    $stmt->bindValue(':host', $host, PDO::PARAM_STR);
    $stmt->bindValue(':alias', $alias, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('INSERT INTO lxd_simplestreams (host, alias, protocol, user_id) VALUES (:host, :alias, "simplestreams", :user_id);');
    $stmt->bindValue(':host', $host, PDO::PARAM_STR);
    $stmt->bindValue(':alias', $alias, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
  }

  $db = null;
  return $stmt;
}

function addUser($username, $first_name, $last_name, $passwd_hash, $email){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('INSERT INTO lxd_users (username, first_name, last_name, passwd_hash, email, type) VALUES (:username, :first_name, :last_name, :passwd_hash, :email, "local");');
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
    $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
    $stmt->bindValue(':passwd_hash', $passwd_hash, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('INSERT INTO lxd_users (username, first_name, last_name, passwd_hash, email, type) VALUES (:username, :first_name, :last_name, :passwd_hash, :email, "local");');
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
    $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
    $stmt->bindValue(':passwd_hash', $passwd_hash, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
  }

  $db = null;
  return $stmt;
}

function addGroup($name, $description){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('INSERT INTO lxd_groups (name, description) VALUES (:name, :description);');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('INSERT INTO lxd_groups (name, description) VALUES (:name, :description);');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);
    $stmt->execute();
  }

  $db = null;
  return $stmt;
}

function addUserGroupMapping($user_id, $group_id) {
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('INSERT INTO lxd_users_groups_mapping (user_id, group_id) VALUES (:user_id, :group_id);');
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('INSERT INTO lxd_users_groups_mapping (user_id, group_id) VALUES (:user_id, :group_id);');
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  $db = null;
  return $stmt;
}

function addGroupRoleMapping($group_id, $role_id) {
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('INSERT INTO lxd_groups_roles_mapping (group_id, role_id) VALUES (:group_id, :role_id);');
    $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
    $stmt->bindValue(':role_id', $role_id, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('INSERT INTO lxd_groups_roles_mapping (group_id, role_id) VALUES (:group_id, :role_id);');
    $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
    $stmt->bindValue(':role_id', $role_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  $db = null;
  return $stmt;
}

function addPreference($name, $value){
  $db = establishDatabaseConnection();

  try{
    $stmt = $db->prepare("INSERT INTO lxd_preferences (name, value) VALUES (:name, :value);");
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':value', $value, PDO::PARAM_STR);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare("INSERT INTO lxd_preferences (name, value) VALUES (:name, :value);");
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':value', $value, PDO::PARAM_STR);
    $stmt->execute();
  }

  $db = null;
  return $stmt;
}

/*
===================================================================================
Delete Record from Table Functions
===================================================================================
*/

function deleteHost($id){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('DELETE FROM lxd_hosts WHERE id = :id;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('DELETE FROM lxd_hosts WHERE id = :id;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  }

  $db = null;
  return $stmt;
}

function deleteSimplestreams($id){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('DELETE FROM lxd_simplestreams WHERE id = :id;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('DELETE FROM lxd_simplestreams WHERE id = :id;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  }

  $db = null;
  return $stmt;
}

function deleteUser($id){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('DELETE FROM lxd_users WHERE id = :id;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  
    $stmt = $db->prepare('DELETE FROM lxd_users_groups_mapping WHERE user_id = :id;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('DELETE FROM lxd_users WHERE id = :id;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  
    $stmt = $db->prepare('DELETE FROM lxd_users_groups_mapping WHERE user_id = :id;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  }

  $db = null;
  return $stmt;
}

function deleteGroup($id){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('DELETE FROM lxd_groups WHERE id = :id;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  
    $stmt = $db->prepare('DELETE FROM lxd_groups_roles_mapping WHERE group_id = :id;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  
    $stmt = $db->prepare('DELETE FROM lxd_users_groups_mapping WHERE group_id = :id;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('DELETE FROM lxd_groups WHERE id = :id;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  
    $stmt = $db->prepare('DELETE FROM lxd_groups_roles_mapping WHERE group_id = :id;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  
    $stmt = $db->prepare('DELETE FROM lxd_users_groups_mapping WHERE group_id = :id;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  }

  $db = null;
  return $stmt;
}

function deleteUserGroupMapping($user_id, $group_id) {
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('DELETE FROM lxd_users_groups_mapping WHERE user_id = :user_id AND group_id = :group_id;');
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('DELETE FROM lxd_users_groups_mapping WHERE user_id = :user_id AND group_id = :group_id;');
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  $db = null;
  return $stmt;
}

function deleteGroupRoleMapping($group_id, $role_id) {
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('DELETE FROM lxd_groups_roles_mapping WHERE group_id = :group_id AND role_id = :role_id;');
    $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
    $stmt->bindValue(':role_id', $role_id, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('DELETE FROM lxd_groups_roles_mapping WHERE group_id = :group_id AND role_id = :role_id;');
    $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
    $stmt->bindValue(':role_id', $role_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  $db = null;
  return $stmt;
}

/*
===================================================================================
Retrieve Values from Table Functions
===================================================================================
*/
    
function retrieveGroupId($name){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('SELECT id FROM lxd_groups WHERE name = :name LIMIT 1;');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('SELECT id FROM lxd_groups WHERE name = :name LIMIT 1;');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
  }

  $return_val = $stmt->fetchColumn();
  $db = null;
  return $return_val;
}

function retrieveGroupRoles($group_id){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('SELECT lxd_roles.id, lxd_roles.name FROM lxd_roles, lxd_groups, lxd_groups_roles_mapping WHERE lxd_groups.id = lxd_groups_roles_mapping.group_id AND lxd_roles.id = lxd_groups_roles_mapping.role_id AND lxd_groups.id = :group_id;');
    $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('SELECT lxd_roles.id, lxd_roles.name FROM lxd_roles, lxd_groups, lxd_groups_roles_mapping WHERE lxd_groups.id = lxd_groups_roles_mapping.group_id AND lxd_roles.id = lxd_groups_roles_mapping.role_id AND lxd_groups.id = :group_id;');
    $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  $return_val = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $return_val;
}

function retrieveGroupUsers($group_id){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('SELECT DISTINCT lxd_users.username FROM lxd_users, lxd_groups, lxd_users_groups_mapping WHERE lxd_users.id = lxd_users_groups_mapping.user_id AND lxd_groups.id = lxd_users_groups_mapping.group_id AND lxd_groups.id = :group_id;');
    $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('SELECT DISTINCT lxd_users.username FROM lxd_users, lxd_groups, lxd_users_groups_mapping WHERE lxd_users.id = lxd_users_groups_mapping.user_id AND lxd_groups.id = lxd_users_groups_mapping.group_id AND lxd_groups.id = :group_id;');
    $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  $return_val = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $return_val;
}

function retrieveRoleId($name){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('SELECT id FROM lxd_roles WHERE name = :name LIMIT 1;');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('SELECT id FROM lxd_roles WHERE name = :name LIMIT 1;');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
  }

  $return_val = $stmt->fetchColumn();
  $db = null;
  return $return_val;
}

function retrieveDefaultRoles(){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('SELECT * FROM lxd_roles WHERE name IN ("ADMIN", "OPERATOR", "USER", "AUDITOR");');
    $stmt->execute();
  } 
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('SELECT * FROM lxd_roles WHERE name IN ("ADMIN", "OPERATOR", "USER", "AUDITOR");');
    $stmt->execute();
  }
  
  $return_val = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $return_val;
}

function retrieveUserGroups($user_id){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('SELECT lxd_groups.id, lxd_groups.name FROM lxd_users, lxd_groups, lxd_users_groups_mapping WHERE lxd_users.id = lxd_users_groups_mapping.user_id AND lxd_groups.id = lxd_users_groups_mapping.group_id AND lxd_users.id = :user_id');
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('SELECT lxd_groups.id, lxd_groups.name FROM lxd_users, lxd_groups, lxd_users_groups_mapping WHERE lxd_users.id = lxd_users_groups_mapping.user_id AND lxd_groups.id = lxd_users_groups_mapping.group_id AND lxd_users.id = :user_id');
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  $return_val = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $return_val;
}

function retrieveUserId($username){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('SELECT id FROM lxd_users WHERE username = :username LIMIT 1;');
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('SELECT id FROM lxd_users WHERE username = :username LIMIT 1;');
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
  }

  $return_val = $stmt->fetchColumn();
  $db = null;
  return $return_val;
}

function retrieveUserDetails($user_id){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('SELECT * FROM lxd_users WHERE id = :id LIMIT 1;');
    $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('SELECT * FROM lxd_users WHERE id = :id LIMIT 1;');
    $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  $return_val = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $return_val;
}

function retrieveUserRecord($username){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('SELECT * FROM lxd_users WHERE username = :username LIMIT 1;');
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('SELECT * FROM lxd_users WHERE username = :username LIMIT 1;');
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
  }

  $return_val = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $return_val;
}

function retrieveUserRoles($user_id){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('SELECT DISTINCT lxd_roles.name FROM lxd_roles, lxd_groups_roles_mapping, lxd_users_groups_mapping WHERE lxd_roles.id = lxd_groups_roles_mapping.role_id AND lxd_groups_roles_mapping.group_id = lxd_users_groups_mapping.group_id AND lxd_users_groups_mapping.user_id = :user_id');
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('SELECT DISTINCT lxd_roles.name FROM lxd_roles, lxd_groups_roles_mapping, lxd_users_groups_mapping WHERE lxd_roles.id = lxd_groups_roles_mapping.role_id AND lxd_groups_roles_mapping.group_id = lxd_users_groups_mapping.group_id AND lxd_users_groups_mapping.user_id = :user_id');
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  $return_val = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $return_val;
}

function retrieveHostURL($remote_id){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
    $stmt->bindValue(':id', $remote_id, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
    $stmt->bindValue(':id', $remote_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  $rows = $stmt->fetchAll();

  $base_url = "";
  foreach ($rows as $row){
    $base_url = "https://" . $row['host'] . ":" . $row['port'];
  }

  return $base_url;
}

function retrieveHostName($remote_id){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
    $stmt->bindValue(':id', $remote_id, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
    $stmt->bindValue(':id', $remote_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  $rows = $stmt->fetchAll();

  $hostname = "";
  foreach ($rows as $row){
    $hostname = $row['host'];
  }

  return $hostname;
}

function retrieveExternalHostName($remote_id){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
    $stmt->bindValue(':id', $remote_id, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
    $stmt->bindValue(':id', $remote_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  $rows = $stmt->fetchAll();

  $hostname = "";
  foreach ($rows as $row){
    $hostname = $row['external_host'];
  }

  return $hostname;
}

function retrieveHostPort($remote_id){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
    $stmt->bindValue(':id', $remote_id, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
    $stmt->bindValue(':id', $remote_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  $rows = $stmt->fetchAll();

  $port = "";
  foreach ($rows as $row){
    $port = $row['port'];
  }

  return $port;
}

function retrieveExternalHostPort($remote_id){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
    $stmt->bindValue(':id', $remote_id, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
    $stmt->bindValue(':id', $remote_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  $rows = $stmt->fetchAll();

  $port = "";
  foreach ($rows as $row){
    $port = $row['external_port'];
  }

  return $port;
}

function retrieveHostAlias($remote_id){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
    $stmt->bindValue(':id', $remote_id, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
    $stmt->bindValue(':id', $remote_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  $rows = $stmt->fetchAll();

  $alias = "";
  foreach ($rows as $row){
    $alias = $row['alias'];
  }

  return $alias;
}

function retrieveTableRows($table, $limit = 100){
  $db = establishDatabaseConnection();

  try {
    switch ($table){
      case "lxd_hosts":
        $stmt = $db->prepare('SELECT * FROM lxd_hosts');
        break;
  
      case "lxd_groups":
        $stmt = $db->prepare('SELECT * FROM lxd_groups');
        break;
  
      case "lxd_roles":
        $stmt = $db->prepare('SELECT * FROM lxd_roles');
        break;
  
      case "lxd_simplestreams":
        $stmt = $db->prepare('SELECT * FROM lxd_simplestreams');
        break;
  
      case "lxd_users":
        $stmt = $db->prepare('SELECT * FROM lxd_users');
        break;

      case "lxd_preferences":
        $stmt = $db->prepare('SELECT * FROM lxd_preferences');
        break;

      case "lxd_logs":
        $stmt = $db->prepare('SELECT * FROM lxd_logs ORDER BY id DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        break;
  
      default:
        $stmt = "";
    }
    $stmt->execute();
  } 
  catch ( PDOException $e ) {
    initializeAllTables();
    switch ($table){
      case "lxd_hosts":
        $stmt = $db->prepare('SELECT * FROM lxd_hosts');
        break;
  
      case "lxd_groups":
        $stmt = $db->prepare('SELECT * FROM lxd_groups');
        break;
  
      case "lxd_roles":
        $stmt = $db->prepare('SELECT * FROM lxd_roles');
        break;
  
      case "lxd_simplestreams":
        $stmt = $db->prepare('SELECT * FROM lxd_simplestreams');
        break;
  
      case "lxd_users":
        $stmt = $db->prepare('SELECT * FROM lxd_users');
        break;

      case "lxd_preferences":
        $stmt = $db->prepare('SELECT * FROM lxd_preferences');
        break;

      case "lxd_logs":
        $stmt = $db->prepare('SELECT * FROM lxd_logs ORDER BY id DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        break;
  
      default:
        $stmt = "";
    }
    $stmt->execute();
  }
  
  $return_val = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $return_val;
}

function retrieveHostInfo($remote_id){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
    $stmt->bindValue(':id', $remote_id, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('SELECT * FROM lxd_hosts WHERE id = :id LIMIT 1;');
    $stmt->bindValue(':id', $remote_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  $rows = $stmt->fetchAll();

  $host = array();
  foreach ($rows as $row){
    $host = $row;
  }

  return $host;
}

function retrievePreference($name){
  $db = establishDatabaseConnection();
  
  try {
    $stmt = $db->prepare('SELECT value FROM lxd_preferences WHERE name = :name LIMIT 1;');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
  } 
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('SELECT value FROM lxd_preferences WHERE name = :name LIMIT 1;');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
  }

  $return_val = $stmt->fetchColumn();
  $db = null;
  return $return_val;
}

/*
===================================================================================
Update Record in Table Functions
===================================================================================
*/

function updateUserAccount($id, $first_name, $last_name, $email){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('UPDATE lxd_users SET first_name = :first_name, last_name = :last_name, email = :email WHERE id = :id;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
    $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('UPDATE lxd_users SET first_name = :first_name, last_name = :last_name, email = :email WHERE id = :id;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
    $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
  }

  $db = null;
  return $stmt;
}

function updateUserPassword($id, $passwd_hash){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('UPDATE lxd_users SET passwd_hash = :passwd_hash WHERE id = :id;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':passwd_hash', $passwd_hash, PDO::PARAM_STR);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('UPDATE lxd_users SET passwd_hash = :passwd_hash WHERE id = :id;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':passwd_hash', $passwd_hash, PDO::PARAM_STR);
    $stmt->execute();
  }

  $db = null;
  return $stmt;
}

function updateHost($id, $host, $port, $alias, $external_host, $external_port){
  $db = establishDatabaseConnection();

  try {
    $stmt = $db->prepare('UPDATE lxd_hosts SET host = :host, port = :port, alias = :alias, external_host = :external_host, external_port = :external_port WHERE id = :id;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':host', $host, PDO::PARAM_STR);
    $stmt->bindValue(':port', $port, PDO::PARAM_INT);
    $stmt->bindValue(':alias', $alias, PDO::PARAM_STR);
    $stmt->bindValue(':external_host', $external_host, PDO::PARAM_STR);
    $stmt->bindValue(':external_port', $external_port, PDO::PARAM_INT);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare('UPDATE lxd_hosts SET host = :host, port = :port, alias = :alias, external_host = :external_host, external_port = :external_port WHERE id = :id;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':host', $host, PDO::PARAM_STR);
    $stmt->bindValue(':port', $port, PDO::PARAM_INT);
    $stmt->bindValue(':alias', $alias, PDO::PARAM_STR);
    $stmt->bindValue(':external_host', $external_host, PDO::PARAM_STR);
    $stmt->bindValue(':external_port', $external_port, PDO::PARAM_INT);
    $stmt->execute();
  }

  $db = null;
  return $stmt;
}

function updatePreference($name, $value){
  $db = establishDatabaseConnection();

  try{
    $stmt = $db->prepare("UPDATE lxd_preferences SET value = :value WHERE name = :name;");
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':value', $value, PDO::PARAM_STR);
    $stmt->execute();
  }
  catch ( PDOException $e ) {
    initializeAllTables();
    $stmt = $db->prepare("UPDATE lxd_preferences SET value = :value WHERE name = :name;");
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':value', $value, PDO::PARAM_STR);
    $stmt->execute();
  }

  $db = null;
  return $stmt;
}

/*
===================================================================================
Misc Database Functions
===================================================================================
*/

function isFirstUser(){
  $db = establishDatabaseConnection();

  /*
  The very first time at login page it will request this function to determine if the user 
  should be presented with a login or registration form. If table does not yet exist it will cause
  an error. The catch will initialize all the tables and query the users table again.
  */
  try {
    $db_results = $db->query('SELECT COUNT(*) from lxd_users;');
    $count = $db_results->fetchColumn();
  } 
  catch ( PDOException $e ) {
    initializeAllTables();
    $db_results = $db->query('SELECT COUNT(*) from lxd_users;');
    $count = $db_results->fetchColumn();
  }   

  //Determine if there are any existing records
  if ($count == 0)
    $return_val = true;
  else
    $return_val = false;

  $db = null;
  return $return_val;
}

function retrieveDatabaseTypes(){

  $datbase_types = array(
    'sqlite'
  );

  return $datbase_types;
}

?>
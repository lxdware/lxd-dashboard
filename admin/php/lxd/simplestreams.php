<?php

if (!empty($_SERVER['PHP_AUTH_USER'])) {
  
  //Instantiate the GET variables
  if (isset($_GET['host']))
    $host = filter_var(urldecode($_GET['host']), FILTER_SANITIZE_STRING);
  if (isset($_GET['alias']))
    $alias = filter_var(urldecode($_GET['alias']), FILTER_SANITIZE_STRING);
  if (isset($_GET['id']))
    $id = filter_var(urldecode($_GET['id']), FILTER_SANITIZE_STRING);
  if (isset($_GET['action']))
    $action = filter_var(urldecode($_GET['action']), FILTER_SANITIZE_STRING);


  $db = new SQLite3('/var/lxdware/data/sqlite/lxdware.sqlite');

  //Run the matching action
  switch ($action) {
    case "addSimplestreams":
      if (filter_var($host, FILTER_VALIDATE_URL))
        $valid_url = true;

      if ($valid_url){
        $db->exec('CREATE TABLE IF NOT EXISTS lxd_simplestreams (id INTEGER PRIMARY KEY AUTOINCREMENT, host TEXT NOT NULL, alias TEXT, protocol TEXT)');
        $record_added = $db->exec("INSERT INTO lxd_simplestreams (host, alias, protocol) VALUES ('$host', '$alias', 'simplestreams')");
        if ($record_added)
          echo "Connection Successful, record added";
        else 
          echo "Error: Connection was successful, error adding record to database";
      } 
      else {
        echo "Error: Invalid host or port";
      }
    break;

    case "removeSimplestreams":
      $record_removed = $db->exec("DELETE FROM lxd_simplestreams WHERE id = $id");
      if ($record_removed)
        echo "Record removed";
      else 
        echo "Error: Unable to remove record from database"; 
    break;

  }

}
else {
  echo "Error: Not Authenticated";
}

?>
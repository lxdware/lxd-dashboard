#!/bin/bash

#Set the password for the web service
echo $ADMIN_PASS | htpasswd -c -i /etc/nginx/.htpasswd admin


#Setup LXD data directory
if [ ! -d /var/lxdware/data/lxd ]
then
  mkdir -p /var/lxdware/data/lxd
fi


#Create LXC cert if necessary, because LXD dameon is not running we need to make a fake remote connection to create it
if [ ! -f /var/lxdware/data/lxd/client.crt ]
then
  #Create the new cert and key
  lxc remote add localhost

  #Copy to persistent storage location
  cp -a $HOME/.config/lxc/client.crt /var/lxdware/data/lxd/client.crt
  cp -a $HOME/.config/lxc/client.key /var/lxdware/data/lxd/client.key
fi


#Create SQLite database directory if needed
if [ ! -d /var/lxdware/data/sqlite ]
then
  mkdir -p /var/lxdware/data/sqlite
fi


#Setup LXD Host and Simplestreams table
if [ ! -f /var/lxdware/data/sqlite/lxdware.sqlite ]
then
  #Create lxd_hosts table
  cmd="CREATE TABLE IF NOT EXISTS lxd_hosts (id INTEGER PRIMARY KEY AUTOINCREMENT, host TEXT NOT NULL, port INTEGER NOT NULL, alias TEXT, protocol TEXT);"
  sqlite3 /var/lxdware/data/sqlite/lxdware.sqlite "$cmd"
  
  #Create and populate lxd_simplestreams table
  cmd="CREATE TABLE IF NOT EXISTS lxd_simplestreams (id INTEGER PRIMARY KEY AUTOINCREMENT, host TEXT NOT NULL, alias TEXT, protocol TEXT);"
  sqlite3 /var/lxdware/data/sqlite/lxdware.sqlite "$cmd"
  cmd="INSERT INTO lxd_simplestreams (host, alias, protocol) VALUES ('https://images.linuxcontainers.org', 'Linux Containers', 'simplestreams');"
  sqlite3 /var/lxdware/data/sqlite/lxdware.sqlite "$cmd"
  cmd="INSERT INTO lxd_simplestreams (host, alias, protocol) VALUES ('https://cloud-images.ubuntu.com/releases', 'Ubuntu Releases', 'simplestreams');"
  sqlite3 /var/lxdware/data/sqlite/lxdware.sqlite "$cmd"
  cmd="INSERT INTO lxd_simplestreams (host, alias, protocol) VALUES ('https://cloud-images.ubuntu.com/daily', 'Ubuntu Daily', 'simplestreams');"
  sqlite3 /var/lxdware/data/sqlite/lxdware.sqlite "$cmd"
fi

chown -R www-data:www-data /var/lxdware/data/sqlite


#Start PHP for NGINX
service php7.4-fpm start


#Clear bash history
history -c


#Start the main service
nginx -g "daemon off;"

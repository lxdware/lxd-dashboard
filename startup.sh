#!/bin/bash

#Setup LXD data directory
if [ ! -d /var/lxdware/data/lxd ]
then
  mkdir -p /var/lxdware/data/lxd
fi

#Create backups directory if needed
if [ ! -d /var/lxdware/backups ]
then
  mkdir -p /var/lxdware/backups
fi

#Create SQLite database directory if needed
if [ ! -d /var/lxdware/data/sqlite ]
then
  mkdir -p /var/lxdware/data/sqlite
fi

chown -R www-data:www-data /var/lxdware/

#Start PHP for NGINX
service php7.4-fpm start

#Start the main service
nginx -g "daemon off;"

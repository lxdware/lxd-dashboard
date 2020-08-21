FROM ubuntu:20.04

#Setting ENV variables, ADMIN_PASS can/should be overridden when running container
ENV DEBIAN_FRONTEND=noninteractive
ENV ADMIN_PASS=lxdware

#Update and Upgrade repository
RUN apt-get update
RUN apt-get upgrade -y

#Install Curl for API calls
RUN apt-get install curl -y

#Install sudo to be able to run lxc commands as www-data without password
RUN apt-get install sudo -y

#Install web server requirements
RUN apt-get install apache2-utils -y 
RUN apt-get install nginx -y
RUN apt-get install php-fpm -y

#Install database requirements
RUN apt-get install sqlite3 -y
RUN apt-get install php-sqlite3 -y

#LXD Setup. Copy compiled lxc binary from source code, version 4.02
RUN apt-get install libc6 -y
COPY lxc /usr/bin/

#Open up port 80 for web traffic
EXPOSE 80

#Set the no password option for running lxc commands
RUN echo "www-data ALL=(ALL) NOPASSWD: /usr/bin/lxc, /usr/bin/curl" >> /etc/sudoers

#Setup web directory and files
COPY default /etc/nginx/sites-available/
COPY index.html /var/www/html/
RUN mkdir -p /var/www/html/admin
ADD admin /var/www/html/admin
RUN chown -R www-data:www-data /var/www/html/
RUN service nginx restart

#Copy and run the startup script
COPY startup.sh /root
RUN chmod +x /root/startup.sh
CMD /root/startup.sh
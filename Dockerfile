FROM ubuntu:20.04

#Setting ENV variables
ENV DEBIAN_FRONTEND=noninteractive

#Update and Upgrade repository
RUN apt-get update
RUN apt-get upgrade -y

#Install web server requirements
RUN apt-get install nginx -y
RUN apt-get install php-fpm -y
RUN apt-get install php-curl -y

#Install database requirements
RUN apt-get install sqlite3 -y
RUN apt-get install php-sqlite3 -y
RUN apt-get install php-mysql -y

#Open up port 80 for web traffic
EXPOSE 80

#Setup web directory and files
COPY default /etc/nginx/sites-available/
RUN mkdir -p /var/www/html/lxd-dashboard
ADD lxd-dashboard /var/www/html/lxd-dashboard
RUN chown -R www-data:www-data /var/www/html/lxd-dashboard
RUN service nginx restart

#Copy and run the startup script
COPY startup.sh /root
RUN chmod +x /root/startup.sh
CMD /root/startup.sh
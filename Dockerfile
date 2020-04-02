FROM debian:buster-slim

EXPOSE 80 443

ADD srcs/sources.list /etc/apt/sources.list
RUN apt -y update && apt-get -y upgrade
RUN DEBIAN_FRONTEND=noninteractive apt-get -yq install php7.3 php7.3-fpm php7.3-mbstring php7.3-mysql
RUN DEBIAN_FRONTEND=noninteractive apt-get -yq install nginx default-mysql-server wget
RUN service mysql start && DEBIAN_FRONTEND=noninteractive apt-get -yq install phpmyadmin

#SETUP WORDPRESS
RUN service mysql start && mysql -e "CREATE USER 'wp_user'@'%' IDENTIFIED BY 'admin';CREATE DATABASE wp_db;GRANT ALL PRIVILEGES ON wp_db.* TO 'wp_user'@'%' WITH GRANT OPTION;FLUSH PRIVILEGES;"
COPY srcs/latest.tar.gz latest.tar.gz
RUN tar -xvf latest.tar.gz && mv wordpress /srv/website && cd /srv/website
ADD srcs/wp-config.php /srv/website
RUN chown -R www-data:www-data /srv/website
RUN ln -s /srv/website/ /var/www/html

#SETUP SSL
RUN mkdir /root/certs/
RUN mkdir /root/certs/website/
RUN openssl genpkey -genparam -algorithm DH -out /root/certs/website/dhparam4096.pem -pkeyopt dh_paramgen_prime_len:4096
RUN openssl req -new -newkey rsa:4096 -x509 -sha256 -days 365 -nodes -out website.crt -keyout website.key -subj "/CN=localhost/C=FR/ST=Lyon/L=Lyon/OU=IT/" && mv website.key /root/certs/website/ && mv website.crt /root/certs/website/
RUN chmod 400 /root/certs/website/website.key
ADD srcs/nginx.conf /etc/nginx/nginx.conf

RUN cd / && mkdir autoindex
ADD srcs/default-autooff /etc/nginx/sites-available/default
ADD srcs/default-autoon /autoindex/default-autoon
ADD srcs/default-autooff /autoindex/default-autooff
ADD srcs/menu/index.php /var/www/html
ADD srcs/menu/switch.php /var/www/html
RUN chmod -R 777 /autoindex/ && chmod -R 777 /etc/nginx/

RUN rm /var/www/html/index.nginx-debian.html

#PATCH PHPMYADMIN
ADD srcs/php/sql.lib.php /usr/share/phpmyadmin/libraries/sql.lib.php
ADD srcs/php/plugin_interface.lib.php /usr/share/phpmyadmin/libraries/plugin_interface.lib.php
RUN apt install sudo
RUN sudo echo "www-data ALL=(ALL:ALL) NOPASSWD:/usr/sbin/service nginx reload" >> /etc/sudoers
CMD service php7.3-fpm start && service mysql restart && service nginx start && sleep infinity

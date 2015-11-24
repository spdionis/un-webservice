#!/bin/bash
sudo apt-get update > /dev/null

echo ">>>>>>>>>>>>>>>>>>> Running bootstrap.sh <<<<<<<<<<<<<<<<<<"

#install mysql
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root' > /dev/null
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root' > /dev/null
sudo apt-get install -y mysql-server > /dev/null

sudo apt-get install -y apache2 php5 libapache2-mod-php5 curl php5-mysql php5-cli php5-curl php5-mysql php5-intl sqlite3 libsqlite3-dev php5-sqlite > /dev/null

echo "ServerName localhost" | sudo tee -a /etc/apache2/apache2.conf
sudo a2enmod rewrite > /dev/null

sudo cp /vagrant/vagrant/apache2/vhost.conf /etc/apache2/sites-available/000-default.conf
sudo sed -i 's/export APACHE_RUN_USER=www-data/export APACHE_RUN_USER=vagrant/g' /etc/apache2/envvars
sudo sed -i 's/export APACHE_RUN_GROUP=www-data/export APACHE_RUN_GROUP=vagrant/g' /etc/apache2/envvars


mysql -uroot -proot -e "GRANT ALL ON *.* to root@'%' IDENTIFIED BY 'root'; FLUSH PRIVILEGES;"

sudo rm -rf /var/www/html

sudo service apache2 restart
sudo service mysql restart

curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

echo "alias s='php /var/www/app/console'" | sudo tee ~/.bashrc


cd /var/www
sudo cp app/config/parameters.yml.dist app/config/parameters.yml

composer install -o

echo '----- CREATE DATABASE -----'

php app/console doctrine:database:create
php app/console doctrine:schema:update --force
php app/console doctrine:fixtures:load -n

sudo service apache2 restart
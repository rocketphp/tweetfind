#!/bin/bash

APPENV=$1

echo -e "\n--- Provisioning machine.. ---\n"

cd ~

# Update yum repositories
# sudo yum -y update

# Install Apache
echo -e "\n--- Installing Apache ---\n"
sudo yum install httpd -y

echo -e "\n--- Setting link /vagrant/public /var/www ---\n"
if ! [ -L /var/www ]; then
  sudo rm -rf /var/www
  sudo ln -fs /vagrant/public /var/www
fi

echo -e "\n--- Adding environment variables to Apache ---\n"
cat > /etc/httpd/conf.d/000-tweetfind.dev.conf <<EOF
<VirtualHost *:80>
    ServerName tweetfind.dev
    ServerAdmin webmaster@tweetfind.dev
    DocumentRoot /var/www/html
    SetEnv APPLICATION_ENV "$APPENV"
    <Directory "/var/www/html">
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
EOF

# Start Apache on Boot
sudo chkconfig httpd on

# Install PHP 5.6
echo -e "\n--- Installing PHP 5.6 ---\n"
sudo rpm -Uvh https://mirror.webtatic.com/yum/el6/latest.rpm
sudo yum install php56w php56w-opcache -y

# Install Composer
echo -e "\n--- Installing Composer ---\n"
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

# Install Java
echo -e "\n--- Installing Java 1.7.0 ---\n"
sudo yum install java-1.7.0-openjdk.i686 -y 

# Install Elasticsearch
echo -e "\n--- Updating Yum Repository for Elasticsearch ---\n"
cat > /etc/yum.repos.d/elasticsearch.repo <<EOF
[elasticsearch-1.7]
name=Elasticsearch repository for 1.7.x packages
baseurl=http://packages.elastic.co/elasticsearch/1.7/centos
gpgcheck=1
gpgkey=http://packages.elastic.co/GPG-KEY-elasticsearch
enabled=1
EOF

echo -e "\n--- Installing Elasticsearch ---\n"
sudo yum install elasticsearch -y

# Start Elasticsearch on Boot
sudo chkconfig --add elasticsearch

# curl -X GET http://127.0.0.1:9200/

# echo -e "\n--- Opening port 9200 (for http) and 9300 (for tcp) ---\n"
# sudo iptables -L -n
# sudo iptables -A INPUT -p tcp -m tcp --dport 9200 -j ACCEPT
# sudo iptables -A INPUT -p tcp -m tcp --dport 9300 -j ACCEPT
# sudo service iptables save

# Install Elasticsearch `head` plugin
# sudo /usr/local/share/elasticsearch/bin/plugin -install mobz/elasticsearch-head

# Install Git
# sudo yum install git -y

# Start Apache
echo -e "\n--- Starting Apache ---\n"
sudo service httpd start

# Start ElasticSearch
echo -e "\n--- Start Elasticsearch ---\n"
sudo service elasticsearch start

# Install PHP packages via Composer
echo -e "\n--- Installing PHP packages via Composer ---\n"
cd /vagrant/
sudo php /usr/local/bin/composer install

echo -e "\n--- Provisioning complete! ---\n"
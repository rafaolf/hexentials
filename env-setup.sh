#!/usr/bin/bash

# Update the system and patch.
sudo yum update -y
sudo yum install -y make gcc wget
sudo yum install -y patch

echo '########## Swap setup ##########'
sudo dd if=/dev/zero of=/swapfile bs=128M count=16
sudo chmod 600 /swapfile && sudo mkswap /swapfile && sudo swapon /swapfile && sudo swapon -s
sudo tee -a /etc/fstab<<EOF
/swapfile swap swap defaults 0 0
EOF

echo '########## Apache setup ##########'
sudo yum install -y httpd
sudo tee -a /etc/httpd/conf.d/001-hex.conf<<EOF
<VirtualHost *:80>
    ServerName hexentials.com.br
    ServerAlias www.hexentials.com.br
    DocumentRoot /var/www/hex/web
<Directory "/var/www/hex">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
    ErrorLog /var/log/httpd/hexentials.com.br-error.log
    CustomLog /var/log/httpd/hexentials.com.br-access.log combined
</VirtualHost>
EOF
sudo systemctl enable httpd && sudo systemctl start httpd
sudo usermod -a -G apache ec2-user
sudo chown -R ec2-user:apache /var/www
sudo chmod 2775 /var/www
find /var/www -type d -exec sudo chmod 2775 {} \;
find /var/www -type f -exec sudo chmod 0664 {} \;
sudo chkconfig httpd on # Enable Apache on system boot.
sudo yum install -y polkit

echo '########## PHP and dependencies setup ##########'
sudo amazon-linux-extras install -y php7.4
sudo yum install -y php-dom php-gd php-simplexml php-xml php-opcache php-mbstring
sudo yum install -y php-apcu php-imap php-intl php-ldap php-posix
sudo yum install -y php-bcmath # Commerce-related extension.
sudo yum install -y php-redis # If that doesn't work, use this link https://medium.com/@egorshytikov/install-magento-2-on-aws-linux-2-d6419c7abecc or the script https://gist.github.com/jpickwell/e6857da4ba17c83ef09729c5d448f6bb.

echo '########## JSMin and ImageMagick setup ##########'
sudo yum install -y php-devel php-pear # Enable pear to install JSMin library.
# Prepare the temporary directory to install with PECL.
mkdir -p /tmp/pear/cache
mkdir -p /tmp/pear/download
sudo pecl channel-update pecl.php.net
sudo pecl install jsmin
sudo yum install -y ImageMagick ImageMagick-devel ImageMagick-perl # Use instead of GD2.
sudo pecl install imagick
sudo tee -a /etc/php.ini<<EOF
[jsmin]
extension="jsmin.so"
[imagick]
extension=imagick.so
EOF
sudo systemctl restart httpd

echo '########## MariaDB setup ##########'
sudo tee -a /etc/yum.repos.d/mariadb.repo<<EOF
[mariadb]
name = MariaDB
baseurl = http://yum.mariadb.org/10.4/centos7-amd64
gpgkey=https://yum.mariadb.org/RPM-GPG-KEY-MariaDB
gpgcheck=1
EOF
sudo yum makecache
sudo yum install -y MariaDB-server MariaDB-client
sudo systemctl enable mariadb
sudo systemctl start mariadb
find /var/www -type f -exec sudo chmod 0664 {} \;
sudo mysql_secure_installation
sudo systemctl stop mariadb
sudo systemctl start mariadb
sudo chkconfig mariadb on # Enable MariaDB on system boot.

echo '########## Redis setup ##########'
sudo amazon-linux-extras install -y epel
sudo yum install -y http://rpms.remirepo.net/enterprise/remi-release-7.rpm
sudo yum-config-manager --enable remi
sudo yum install -y redis
sudo systemctl enable redis
sudo systemctl start redis
sudo chkconfig redis on # Enable Redis on system boot.

echo '########## RVM setup ##########'
sudo yum install -y curl gpg patch autoconf automake bison libffi-devel libtool patch readline-devel sqlite-devel zlib-devel openssl-devel
curl -sSL https://rvm.io/mpapis.asc | gpg2 --import -
curl -sSL https://rvm.io/pkuczynski.asc | gpg2 --import -
curl -sSL https://get.rvm.io | bash -s stable
source ~/.rvm/scripts/rvm
rvm install 2.5.1
rvm use 2.5.1 --default

echo '########## Syslog setup ##########'
sudo tee -a /etc/rsyslog.conf<<EOF
local0.* /var/log/drupal.log
EOF
sudo systemctl restart rsyslog.service

echo '########## Composer setup ##########'
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'c31c1e292ad7be5f49291169c0ac8f683499edddcfd4e42232982d0fd193004208a58ff6f353fde0012d35fdd72bc394') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer

echo '########## Drush setup ##########'
composer global require consolidation/cgr
PATH="$(composer config -g home)/vendor/bin:$PATH"
cgr drush/drush

echo '########## Git setup ##########'
sudo yum install git -y
cd /var/www
mkdir hex
cd hex
git clone --single-branch --branch master https://github.com/rafaolf/hexentials.git # Move the files to the current directory.

# Organize the repository folder and update the DocumentRoot directory from Apache and restart the service.

#echo '########## Theme compilation with Compass ##########'
cd /var/www/hex/web/themes/custom/hex
gem install compass
compass compile --force
cd /var/www/hex
composer install

# @TODO fix snap setup as it's currently not working.
# @see https://snapcraft.io/docs/installing-snap-on-centos.
# sudo yum install -y epel-release
# sudo yum update -y
# sudo yum-config-manager --enable cr
# sudo yum install -y snapd

echo '########## EPEL and LE (SSL) setup ##########'
cd /tmp
wget -O epel.rpm –nv https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
sudo yum install -y ./epel.rpm
sudo yum install -y python2-certbot-apache.noarch
sudo systemctl restart httpd
sudo certbot -i apache -a manual --preferred-challenges dns -d hexentials.com.br

# Install the Hexentials distribution and Update the robots.txt file.

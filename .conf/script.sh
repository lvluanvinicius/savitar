#!/bin/bash

apt update && \
apt install -y lsb-release ca-certificates apt-transport-https software-properties-common gnupg2 && \
echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/sury-php.list && \
wget -qO - https://packages.sury.org/php/apt.gpg | apt-key add - && \
apt update && apt install php8.0 && \
apt install php-{xml,curl,intl,mysql,zip,dom,ssh} && apt intall phpunit

cp /volume/Api-For-Zabbix/.env.example /volume/Api-For-Zabbix/.env

cp ./apachefile/api.conf /etc/apache2/sites-available/
a2enmode rewrite
service apache2 restart

FROM debian

RUN apt-get update && apt-get upgrade -y && apt-get clean

RUN apt update && apt-get -y install apache2 \
    apt install -y lsb-release ca-certificates apt-transport-https software-properties-common gnupg2 && \
    echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/sury-php.list && \
    wget -qO - https://packages.sury.org/php/apt.gpg | apt-key add - && \
    apt update && apt -y install php8.0 && \
    apt install -y php-{xml,curl,intl,mysql,zip,dom,gd,bcmath} && apt intall -y phpunit && apt-get clean

RUN chown -R www-data:www-data /var/www/html/api && chmod -R 755 /var/www/html/api && chmod -R 777 /var/www/html/api/storage

COPY ./apache/api.conf /etc/apache2/sites-available/

RUN a2dissite 000-default && a2ensite api
RUN a2enmod rewrite headers

EXPOSE 80

ENTRYPOINT ["/usr/sbin/apache2ctl"]
CMD ["-D", "FOREGROUND"]

FROM debian
USER root

RUN apt-get update && apt-get upgrade -y && apt-get clean

RUN apt-get update && apt-get -y install apache2 wget curl && apt-get clean
RUN apt-get install -y lsb-release ca-certificates apt-transport-https software-properties-common gnupg2 && apt-get clean
RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/sury-php.list
RUN wget -qO - https://packages.sury.org/php/apt.gpg | apt-key add -
RUN apt-get update && apt-get -y install php8.0 && apt-get clean
RUN apt-get install -y php8.0-ssh2 php-mysql php-xdebug php-curl phpunit php-zip php-intl php-xml php8.0-mysql && apt-get clean
RUN apt-get update && apt-get -y upgrade && apt-get install -y curl dirmngr apt-transport-https lsb-release ca-certificates && \
    curl -sL https://deb.nodesource.com/setup_12.x | bash - && apt-get -y install nodejs && apt-get install -y gcc g++ make && apt-get clean

RUN apt install python3-pip && apt-get clean

ADD ./.docker/api.conf /etc/apache2/sites-available/api.conf

RUN a2dissite 000-default
RUN a2ensite api

RUN a2enmod rewrite
RUN a2enmod headers

EXPOSE 80

ENTRYPOINT ["/usr/sbin/apache2ctl"]
CMD ["-D", "FOREGROUND"]

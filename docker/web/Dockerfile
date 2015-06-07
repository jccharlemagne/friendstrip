# Pull base image.
FROM debian:wheezy

# As we need a decent version of PHP, we first have to enable the DotDeb repository
RUN echo "\n\
# DotDeb repository: \n \
deb http://packages.dotdeb.org wheezy all \n\
deb-src http://packages.dotdeb.org wheezy all \n\
deb http://packages.dotdeb.org wheezy-php55 all \n\
deb-src http://packages.dotdeb.org wheezy-php55 all \n\
" >> /etc/apt/sources.list
RUN apt-get update && apt-get install -y curl && curl -O http://www.dotdeb.org/dotdeb.gpg && apt-key add dotdeb.gpg

# Apache + PHP install
RUN apt-get update && apt-get install -y \
        apache2 \
        php5 \
        libapache2-mod-php5 \
        php5-cli \
        php5-mysql \
        php5-curl \
        php5-redis \
        php5-imagick \
        php5-mcrypt \
        php5-intl \
        php5-dev \
        php5-sqlite \
        php5-xdebug

# Apache modules
RUN a2enmod \
        php5 \
        rewrite \
        headers \
        expires

# Apache service is stopped (we will start it with a foreground process)
RUN service apache2 stop

# Composer
RUN php -r "readfile('https://getcomposer.org/installer');" | php
RUN mv /composer.phar /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer

# Shared files
COPY container-build-resources/xdebug.ini /etc/php5/mods-available/xdebug.ini

COPY container-build-resources/container-entry-point /usr/local/bin/
RUN chmod +x /usr/local/bin/container-entry-point
COPY container-build-resources/container-start-apache-in-background /usr/local/bin/
RUN chmod +x /usr/local/bin/container-start-apache-in-background

# Define mountable directories.
VOLUME ["/etc/apache2/sites-enabled", "/var/log/apache2", "/var/www/"]

# Start!
WORKDIR /var/www/

EXPOSE 80
CMD ["container-entry-point"]

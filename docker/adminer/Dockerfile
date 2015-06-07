# Pull base image
FROM debian

# Apache + PHP install
RUN apt-get update && apt-get install -y \
        apache2 \
        php5 \
        libapache2-mod-php5 \
        php5-mysql

# Apache modules
RUN a2enmod \
        php5

# Apache service is stopped (we will start it with a foreground process)
RUN service apache2 stop

# Adminer
RUN apt-get install -y wget
RUN mkdir -p /var/www && \
    wget -O /var/www/index.php http://heanet.dl.sourceforge.net/project/adminer/Adminer/Adminer%204.2.1/adminer-4.2.1-mysql.php

# Shared files
COPY container-build-resources/container-entry-point /usr/local/bin/
RUN chmod +x /usr/local/bin/container-entry-point

# Start!
WORKDIR /var/www/

EXPOSE 80
CMD ["container-entry-point"]

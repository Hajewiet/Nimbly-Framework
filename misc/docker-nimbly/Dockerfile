FROM ubuntu:latest

# Install required software and modules
ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update \
	&& apt-get -y install apache2 \
	&& apt-get -y install php php-mbstring php-mysqlnd php-gd php-gmp \
	&& apt-get -y install libapache2-mod-php

# Add scripts and configuration files
ADD apache2.conf /etc/apache2/apache2.conf
ADD nimbly.conf /etc/apache2/sites-available/nimbly.conf
ADD run.sh /run.sh
RUN chmod 755 /*.sh

# Set required permissions
RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data
RUN mkdir /var/www/nimbly
RUN mkdir /var/www/nimbly/data
RUN chown -R www-data:www-data /var/www/nimbly/data

# Add docker ports and volumes
EXPOSE 80
VOLUME ["/var/www/nimbly"]

# Execute the run.sh
CMD ["/run.sh"]


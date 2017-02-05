FROM ubuntu:latest

# Install required software and modules
ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update \
	&& apt-get -y install apache2 \
	&& apt-get -y install php php-mbstring php-mcrypt php-mysqlnd php-gd  php-gmp \
	&& apt-get -y install libapache2-mod-php7.0

# Add scripts and configuration files
ADD test.php /var/www/html/test.php
ADD apache2.conf /etc/apache2/apache2.conf
ADD nimbly.conf /etc/apache2/sites-available/nimbly.conf
ADD run.sh /run.sh
RUN chmod 755 /*.sh

# Add docker ports and volumes
EXPOSE 80  
VOLUME ["/var/www/html"]

# Execute the run.sh 
CMD ["/run.sh"]
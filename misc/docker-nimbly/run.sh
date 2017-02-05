#!/bin/bash

echo Starting Nimbly Development Server v0.01
rm /var/www/html/index.html
a2dissite 000-default > dev/null
a2ensite nimbly > dev/null
a2enmod rewrite > dev/null
apache2ctl -k start 

echo All done!
tail -f /var/log/apache2/error.log



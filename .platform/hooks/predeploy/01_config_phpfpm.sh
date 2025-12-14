#!/usr/bin/env bash

# Configure PHP FPM based on the memory limits of this server
MAX_CHILDREN=$(free -m | awk 'FNR == 2 {print int(($2-200)/30 / 5) * 5}')
MIN_SPARE=$(($MAX_CHILDREN/5*1))
MAX_SPARE=$(($MAX_CHILDREN/5*2))
START=$(($MIN_SPARE + ($MAX_SPARE - $MIN_SPARE) / 2))

sed -i "s/^pm.max_children.*/pm.max_children = $MAX_CHILDREN/" /etc/php-fpm.d/www.conf
sed -i "s/^pm.start_servers.*/pm.start_servers = $START/" /etc/php-fpm.d/www.conf
sed -i "s/^pm.min_spare.*/pm.min_spare_servers = $MIN_SPARE/" /etc/php-fpm.d/www.conf
sed -i "s/^pm.max_spare.*/pm.max_spare_servers = $MAX_SPARE/" /etc/php-fpm.d/www.conf

exit 0
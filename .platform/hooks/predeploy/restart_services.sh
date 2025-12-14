#!/bin/sh

sudo systemctl reload php-fpm.service
sudo systemctl reload nginx.service

exit 0

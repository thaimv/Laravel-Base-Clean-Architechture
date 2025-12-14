#!/bin/bash

# Run Caches

# After the deployment, it's highly recommended
# to re-run the caches for config, routes and views.
sudo -uwebapp sh -c "php artisan config:clear"
sudo -uwebapp sh -c "php artisan optimize:clear"
sudo -uwebapp sh -c "php artisan optimize"

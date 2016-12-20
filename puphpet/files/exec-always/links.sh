#!/bin/sh
cd /var/www/pinpoint.dev/
cp config/phinx.vagrant.php config/phinx.php
composer install
bower install
gulp less
vendor/bin/phinx migrate
vendor/bin/phinx seed:run

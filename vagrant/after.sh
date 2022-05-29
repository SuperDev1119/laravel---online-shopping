#!/bin/sh

# If you would like to do some extra provisioning you may
# add any commands you wish to this file and they will
# be run after the Homestead machine is provisioned.
#
# If you have user-specific configurations you would like
# to apply, you may also create user-customizations.sh,
# which will be run after this script.


# If you're not quite ready for the latest Node.js version,
# uncomment these lines to roll back to a previous version

# Remove current Node.js version:
#sudo apt-get -y purge nodejs
#sudo rm -rf /usr/lib/node_modules/npm/lib
#sudo rm -rf //etc/apt/sources.list.d/nodesource.list

# Install Node.js Version desired (i.e. v13)
# More info: https://github.com/nodesource/distributions/blob/master/README.md#debinstall
#curl -sL https://deb.nodesource.com/setup_13.x | sudo -E bash -
#sudo apt-get install -y nodejs

echo 'Enter the code directory'
cd code

echo 'Create user role vagrant'
sudo -u postgres createuser -s -i -d -r -l -w vagrant

echo 'Create database modalova with owner vagrant'
sudo -u postgres psql < db_scripts.sql

echo 'Run Composer Install'
composer install

echo 'Run Seeder'
php artisan db:seed

echo 'Enable Source'
psql modalova vagrant < enable_source.sql

echo 'Import Products'
php artisan import:products

echo 'Run npm install'
npm install

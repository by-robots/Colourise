#!/bin/bash
# This might install as much as can be via the command line for Colourise.
# Before running this make sure Xcode is installed.
#
# Once this is completed you need to set the PHP memory and time limits to
# unlimited and increase the upload size as well.

# Install Homebrew
#/usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"

# Install Composer
cd ~
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

# Install PHP Homebrew Taps
brew tap homebrew/dupes
brew tap homebrew/versions
brew tap homebrew/homebrew-php

# Install Homebrew apps
brew install php70 php70-mcrypt mysql

# Install Torch
git clone https://github.com/torch/distro.git ~/torch --recursive
cd ~/torch; bash install-deps;
./install.sh
source ~/.profile

# Install Colourise
BASEDIR=$(dirname "$0")
cd $BASEDIR

git submodule init
git submodule update
cd lib/colorize
./download_model.sh

# Install Composer assets
php ~/composer.phar install

# Add execute privileges to the shell files
chmod u+x start.sh
chmod u+x process.sh

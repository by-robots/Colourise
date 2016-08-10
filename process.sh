#!/bin/bash
# Serve the application from the local environment
BASEDIR=$(dirname "$0")

cd $BASEDIR
php artisan colourise:process

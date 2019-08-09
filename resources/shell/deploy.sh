#!/bin/bash
cd $1
git pull
composer install
php artisan migrate
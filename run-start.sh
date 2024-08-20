#!/usr/bin/env bash

artisan="
composer install
php artisan migrate
"

docker compose up -d
docker compose exec -u laravel app bash -c "$artisan"

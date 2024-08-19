#!/usr/bin/env bash

artisan="
php artisan ide-helper:generate
php artisan ide-helper:meta
./vendor/bin/pint
./vendor/bin/phpstan analyse
php artisan test
"
docker compose exec -u laravel app bash -c "$artisan"

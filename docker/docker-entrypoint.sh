#!/bin/bash
set -e

if [ -n "$DB_HOST" ]; then
    echo "Waiting for PostgreSQL to start..."
    while ! pg_isready -h "$DB_HOST" -U "$DB_USER" -d "$DB_NAME" > /dev/null 2> /dev/null; do
        echo "PostgreSQL is unavailable - sleeping"
        sleep 1
    done
    echo "PostgreSQL is up - executing command"
fi

if [ ! -d "vendor" ]; then
    composer install --no-interaction
fi

php yii migrate --interactive=0

php-fpm -D

exec "$@"

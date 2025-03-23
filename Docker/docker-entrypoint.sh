#!/bin/sh
set -e

# Move to DockerFile
# composer install --no-interaction

# Wait for MariaDB to be ready
echo "Waiting for database to be ready..."
until nc -z -v -w30 leboncoin_mariadb 3306; do
  echo "Waiting for MariaDB..."
  sleep 2
done
echo "MariaDB is up!"
composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts
# Clear cache
php bin/console cache:clear --env=prod

# Run migrations
php bin/console doctrine:migrations:migrate --no-interaction

# Start PHP-FPM
exec php-fpm

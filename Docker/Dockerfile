# Use official PHP 8.2 FPM with Alpine for a lightweight image
FROM php:8.3.0-fpm

RUN apt-get update && apt-get install -y git

RUN docker-php-ext-install pdo_mysql
RUN apt-get install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install zip

RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN apt-get update && apt-get install -y git netcat-openbsd

# Install Composer
COPY --from=composer:2.8.5 /usr/bin/composer /usr/local/bin/composer

# Set working directory
WORKDIR /var/www
COPY app /var/www

# Set permissions
RUN chown -R www-data:www-data /var/www

# Copy and set up entrypoint script
COPY Docker/docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Install Symfony CLI
# RUN curl -sS https://get.symfony.com/cli/installer | bash
# RUN mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Install Composer dependencies
# RUN composer install --no-interaction --prefer-dist --optimize-autoloader
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Expose PHP-FPM port
EXPOSE 9000
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
# CMD ["php-fpm"]
# Set entrypoint script

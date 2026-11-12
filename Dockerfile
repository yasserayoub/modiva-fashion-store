
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev libonig-dev libxml2-dev \
    libcurl4-openssl-dev \
    && docker-php-ext-install \
    pdo pdo_pgsql mbstring bcmath exif pcntl xml curl zip \
    && a2enmod rewrite

# Configure Apache to serve Laravel's public folder
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf

RUN sed -i 's/Listen 80/Listen 10000/' /etc/apache2/ports.conf

WORKDIR /var/www/html

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 10000

CMD ["apache2-foreground"]

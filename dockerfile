FROM php:8.2-fpm

# system packages and PHP extensions required for Laravel + Postgres
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    libicu-dev \
    libxml2-dev \
    zlib1g-dev \
    && docker-php-ext-install pdo_pgsql pdo mbstring bcmath intl xml zip opcache \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Create storage and vendor folders (mounted by compose) with correct permissions
RUN mkdir -p /var/www/html/storage /var/www/html/vendor \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/vendor \
    && chmod -R 755 /var/www/html/storage

# Expose PHP-FPM socket port
EXPOSE 9000

# Default command
CMD ["php-fpm"]
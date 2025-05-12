# Use PHP 8.2 FPM as the base image
FROM php:8.2-fpm

# Install system dependencies (required for PHP extensions and other tools)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    gnupg \
    ca-certificates \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath gd

# Install Node.js (for Vue.js, Vite, etc.)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Install Composer (PHP package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory to /var/www
WORKDIR /var/www

# Copy all the application files into the container
COPY . .

# Install PHP dependencies using Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Install npm dependencies and build the assets (Vue.js + Vite)
RUN npm install && npm run build

# Set file permissions to avoid errors in storage and cache
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www/storage

# Expose the port the app will run on
EXPOSE 8000

# Run Laravel's PHP built-in server (use artisan to serve)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

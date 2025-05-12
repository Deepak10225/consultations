# Use PHP 8.2 FPM as the base image
FROM php:8.2-fpm

# Install system dependencies and PHP extensions
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

# Install Node.js for Vue.js/Vite
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory in the container
WORKDIR /var/www

# Copy project files to the container
COPY . .

# Install PHP dependencies (Composer)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Install frontend dependencies (npm for Vue.js + Vite)
RUN npm install && npm run build

# Set file permissions to avoid issues with storage/cache
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www/storage

# Expose the port the app will run on
EXPOSE 8000

# Start Laravel's PHP built-in server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

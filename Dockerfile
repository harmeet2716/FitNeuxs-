# Stage 1: Build Frontend
FROM node:20-alpine AS frontend-builder
WORKDIR /app
COPY package*.json .npmrc ./
RUN npm install --legacy-peer-deps
COPY . .
RUN npm run build

# Stage 2: Main Application
FROM php:8.3-apache

# Install System Dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    libwebp-dev \
    libavif-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    unzip \
    libssl-dev \
    pkg-config \
    libcurl4-openssl-dev

# Install PHP Extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp --with-avif
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl opcache

# Install MongoDB Extension
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Configure Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set Working Directory
WORKDIR /var/www/html

# Copy Project Files
COPY . .

# Copy Built Assets from Stage 1
COPY --from=frontend-builder /app/public/build ./public/build

# Install Backend Dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress --ignore-platform-reqs

# Set Permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Expose Port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]

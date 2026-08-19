# Stage 1: Build Dependencies (PHP + Node)
FROM php:8.4-fpm-alpine as builder

# Install system dependencies needed for build
RUN apk add --no-cache \
    curl \
    zip \
    unzip \
    git \
    libpng-dev \
    libxml2-dev \
    oniguruma-dev \
    linux-headers \
    nodejs \
    npm

# Install PHP extensions required
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd xml

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy application files
COPY . .

# Install PHP dependencies
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Install NPM dependencies and build frontend assets
RUN npm install
RUN npm run build


# Stage 2: Production Server
FROM php:8.4-fpm-alpine

# Install system dependencies for production
RUN apk add --no-cache \
    nginx \
    curl \
    zip \
    unzip \
    git \
    libpng-dev \
    libxml2-dev \
    oniguruma-dev \
    linux-headers \
    supervisor \
    bash

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd xml

# Set working directory
WORKDIR /var/www/html

# Copy the entire built app from Stage 1
COPY --from=builder /app /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Setup Nginx
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Setup Supervisor
COPY docker/supervisord.conf /etc/supervisord.conf

# Setup Run Script
COPY docker/run.sh /usr/local/bin/run.sh
RUN chmod +x /usr/local/bin/run.sh

# Expose port
EXPOSE 8080

# Run the startup script
CMD ["/usr/local/bin/run.sh"]


# Stage 1 — PHP Dependencies

FROM php:8.2-fpm-alpine AS vendor

RUN apk add --no-cache git unzip libpng-dev libzip-dev icu-dev oniguruma-dev \
    && docker-php-ext-install pdo pdo_mysql gd zip intl

WORKDIR /app

# Copy composer files first
COPY composer.json composer.lock ./

# Install dependencies without triggering Laravel scripts
RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts

# Copy app files
COPY . .

# Generate optimized autoload files safely
RUN composer dump-autoload --optimize





# Stage 2 — Node / Frontend

FROM node:20-alpine AS frontend

WORKDIR /app
COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build || echo "Skipping Vite build..."


# Stage 3 — Final Runtime Image

FROM php:8.2-fpm-alpine

# Install runtime dependencies
RUN apk add --no-cache nginx supervisor bash libpng libjpeg-turbo freetype libzip

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . .

# Copy built vendor + frontend assets
COPY --from=vendor /app/vendor /var/www/html/vendor
COPY --from=frontend /app/public/build /var/www/html/public/build

# Copy configs
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose HTTP port
EXPOSE 80

# Run Supervisor (manages Nginx + PHP-FPM)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]

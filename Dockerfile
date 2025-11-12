# # Stage 1: Composer install
# FROM composer:2 AS vendor
# WORKDIR /app
# COPY composer.json composer.lock ./
# RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# # Stage 2: Laravel runtime
# FROM php:8.2-fpm

# # Install system dependencies and PHP extensions
# RUN apt-get update && apt-get install -y \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     libzip-dev \
#     zip \
#     unzip \
#     git \
#     && docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install gd pdo pdo_mysql zip exif \
#     && docker-php-ext-enable gd

# WORKDIR /var/www/html

# # Copy vendor from build stage
# COPY --from=vendor /app/vendor /var/www/html/vendor

# # Copy app source code
# COPY . /var/www/html

# # Set permissions 
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# # Expose port 9000 for php-fpm
# EXPOSE 9000

# CMD ["php-fpm"]

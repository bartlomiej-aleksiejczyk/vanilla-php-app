# Use the official PHP Apache image
FROM php:8.2-apache

# Enable Apache mod_rewrite for clean URLs
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy application files into the container
COPY components/ /var/www/html/components/
COPY config/ /var/www/html/config/
COPY public/ /var/www/html/public/
COPY src/ /var/www/html/src/
COPY composer.json composer.lock /var/www/html/

# Install dependencies with Composer (optimized for production)
RUN composer install --no-dev --optimize-autoloader

# Change the Apache document root to the public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Adjust Apache configuration to use the custom document root
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Expose port 80 for the application
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]

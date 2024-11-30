FROM php:8.2-apache

RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY components/ /var/www/html/components/
COPY config/ /var/www/html/config/
COPY public/ /var/www/html/public/
COPY src/ /var/www/html/src/
COPY composer.json composer.lock /var/www/html/

RUN composer install --no-dev --optimize-autoloader

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

EXPOSE 80

CMD ["apache2-foreground"]

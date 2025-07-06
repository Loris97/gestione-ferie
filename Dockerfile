# Usa immagine PHP 8.2 con Apache
FROM php:8.2-apache

# Installa dipendenze di sistema e PHP extensions per Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git \
    && docker-php-ext-install zip pdo_mysql

# Abilita mod_rewrite di Apache (importante per Laravel)
RUN a2enmod rewrite

# Copia tutto il progetto nella root web di Apache
COPY . /var/www/html

# Imposta la directory di lavoro
WORKDIR /var/www/html

# Copia composer dalla immagine ufficiale composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installa le dipendenze PHP di Laravel
RUN composer install --no-dev --optimize-autoloader

# Setta permessi per storage e cache di Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Espone la porta 80
EXPOSE 80

# Comando per avviare Apache in foreground
CMD ["apache2-foreground"]
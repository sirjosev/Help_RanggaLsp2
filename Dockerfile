FROM php:8.2-apache

# Install ekstensi PHP yang umum dibutuhkan (misal: mysqli untuk DB)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Aktifkan modul rewrite Apache (penting untuk routing/htaccess)
RUN a2enmod rewrite

# Tentukan direktori kerja di dalam container
WORKDIR /var/www/html

FROM php:8.1-fpm

RUN docker-php-ext-install pdo pdo_mysql
# RUN docker-compose exec php apt update; docker-compose exec php apt install -y net-tools

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias
RUN composer install --no-dev --optimize-autoloader

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]

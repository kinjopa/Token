# Этап 1: Установка зависимостей и расширений PHP
FROM php:8.2-fpm

RUN apt-get update && \
    apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    unzip \
    git \
    curl

RUN docker-php-ext-install pdo_mysql zip gd pgsql pdo_pgsql

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Этап 2: Копирование файлов в рабочую директорию
WORKDIR /var/www/html

COPY . .

# Этап 3: Установка зависимостей проекта с помощью Composer, оптимизация автозагрузчика и исключение разработочных пакетов
RUN composer install --optimize-autoloader --no-dev

# Этап 4: Открытие порта 8080 для доступа к приложению
EXPOSE 8081

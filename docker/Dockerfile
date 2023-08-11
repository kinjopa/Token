FROM php:8.2-apache

# Установка зависимостей и расширений PHP
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Копирование файлов проекта в контейнер
COPY . .

# Установка рабочей директории приложения
COPY ../ /var/www

# Копирование файла artisan
COPY ../artisan /var/www

# Установка зависимостей Laravel с помощью Composer
RUN composer install --optimize-autoloader --no-dev

# Назначение прав доступа к директории хранения сессий и кэша
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Запуск Apache сервера
CMD apache2-foreground

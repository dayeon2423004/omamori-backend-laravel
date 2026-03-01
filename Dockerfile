FROM php:8.3-fpm

# 필수 패키지 및 라이브러리 설치
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libpq-dev libicu-dev

# PHP 확장 설치
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd intl

# Composer 설치
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# 의존성 설치
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# 권한 설정
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000

# 최적화 명령어 실행 후 서버 시작
CMD php artisan config:clear && \
    php artisan cache:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan serve --host=0.0.0.0 --port=8000
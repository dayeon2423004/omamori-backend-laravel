# 1. PHP 8.2 FPM 기반 (docker-compose의 php 설정을 가져옴)
FROM php:8.2-fpm

# 2. 필수 패키지 및 PostgreSQL 확장 설치
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libpq-dev

RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd

# 3. Composer 설치
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. 소스 복사 및 권한 설정
WORKDIR /var/www/html
COPY . .

# 5. 의존성 설치
RUN composer install --no-dev --optimize-autoloader

# 6. 권한 부여 (Laravel 필수)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 7. 실행 (Nginx 없이 PHP 내장 서버로 포트 연결)
EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000

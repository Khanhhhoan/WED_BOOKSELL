# Dockerfile triển khai website BookStore lên Render.com
FROM php:8.1-apache

# Cài đặt extension PDO MySQL và GD xử lý ảnh
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql \
    && a2enmod rewrite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Cấu hình DocumentRoot Apache trỏ vào public/
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy mã nguồn vào container
WORKDIR /var/www/html
COPY . /var/www/html/

# Phân quyền thư mục uploads
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/public/assets/images

EXPOSE 80

CMD ["apache2-foreground"]

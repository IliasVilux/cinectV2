FROM php:8.1-apache

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
       libpng-dev \
       libjpeg-dev \
       libfreetype6-dev \
       libonig-dev \
       libxml2-dev \
       zip \
       unzip \
       git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl gd xml \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

RUN if [ -f composer.json ]; then \
    composer install --no-dev --optimize-autoloader --verbose || { \
        echo "Error en composer install, mostrando detalles:"; \
        composer diagnose; \
        composer check-platform-reqs; \
        exit 1; \
    }; \
else \
    echo "Archivo composer.json no encontrado. Verifica que se haya copiado correctamente."; \
    exit 1; \
fi

RUN a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80

CMD ["apache2-foreground"]

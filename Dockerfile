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
       curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl gd xml \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

RUN if [ -f package.json ]; then \
    npm install || { \
        echo "Error en npm install, revisa las configuraciones del proyecto."; \
        exit 1; \
    }; \
    if [ -f vite.config.js ]; then \
        npm run build || { \
            echo "Error al construir los assets con npm run build."; \
            exit 1; \
        }; \
    fi; \
else \
    echo "Archivo package.json no encontrado. Verifica que se haya copiado correctamente."; \
    exit 1; \
fi

RUN a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80

CMD ["apache2-foreground"]

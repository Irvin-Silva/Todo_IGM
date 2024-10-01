# Utiliza una imagen base de PHP
FROM php:8.0-fpm

# Instala las extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Establece el directorio de trabajo
WORKDIR /app

# Copia los archivos de tu proyecto al contenedor
COPY . .

# Instala las dependencias de Composer
RUN composer install --ignore-platform-reqs

# Cambia al usuario appuser
RUN useradd -ms /bin/bash appuser
USER appuser

# Ejecuta los comandos necesarios para Laravel
RUN php artisan key:generate && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force

# Instala las dependencias de NPM
RUN npm install

# Expone el puerto que la aplicación usará
EXPOSE 8000

# Comando para iniciar el servidor (ajusta según tus necesidades)
CMD ["php-fpm"]

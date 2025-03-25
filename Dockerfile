#Uso de la imagen base de php con apache
FROM php:apache

#intala las extensiones de php-mysql
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar configuración SSL de Apache
COPY ./default-ssl.conf /etc/apache2/sites-available/default-ssl.conf

#Se crean certificados
RUN openssl req -nodes -x509 -newkey rsa:2048 \
    -keyout /etc/ssl/private/sabores_peruanos.key \
    -out /etc/ssl/certs/sabores_peruanos.crt \
    -days 365 \
    -subj "/CN=sabores_peruanos" 

#Se habilitan los modulos ssl y Rewrite en apache
RUN a2enmod ssl && \
    a2enmod rewrite && \
    a2ensite default-ssl

#se copian los archivos de la app desde el directorio local al contenedor
COPY ./paginaWeb /var/www/html

#puerto http y https
EXPOSE 80 443

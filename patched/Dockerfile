# Use an official PHP image with Apache
FROM php:8.3-apache

# Install necessary PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libonig-dev \
    && docker-php-ext-install pdo pdo_mysql

# Copy project files into the container
COPY . /var/www/html

# Set the working directory
WORKDIR /var/www/html

# Grant permissions for Apache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80 for the web server
EXPOSE 80

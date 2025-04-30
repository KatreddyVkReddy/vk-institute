FROM php:8.1-cli

# Install PostgreSQL extension
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pgsql

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy all project files into the container
COPY . .

# Expose port for PHP built-in server
EXPOSE 10000

# Start PHP server
CMD ["php", "-S", "0.0.0.0:10000"]

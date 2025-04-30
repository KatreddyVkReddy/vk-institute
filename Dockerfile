FROM php:8.1-cli

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy all your project files into the container
COPY . .

# Expose the PHP port
EXPOSE 10000

# Start the PHP server
CMD ["php", "-S", "0.0.0.0:10000"]

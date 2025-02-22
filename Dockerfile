# Use the official PHP 8.1 Apache image
FROM php:8.1-apache

# Install dependencies and MSSQL drivers
RUN apt-get update && apt-get install -y \
    gnupg2 \
    lsb-release \
    unixodbc-dev \
    apt-transport-https \
    curl \
    build-essential \
    autoconf \
    ca-certificates \
    && mkdir -p /etc/apt/keyrings \
    && curl https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor -o /etc/apt/keyrings/microsoft.gpg \
    && curl https://packages.microsoft.com/config/debian/$(lsb_release -rs)/prod.list -o /etc/apt/sources.list.d/mssql-release.list \
    && sed -i 's/^\(deb \[[^]]*\)\]/\1 signed-by=\/etc\/apt\/keyrings\/microsoft.gpg]/' /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql17 mssql-tools \
    && pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv \
    && apt-get clean -y && rm -rf /var/lib/apt/lists/*

# Add MSSQL tools to PATH
ENV PATH="${PATH}:/opt/mssql-tools/bin"

# Enable Apache rewrite module
RUN a2enmod rewrite

# Update Apache configuration to allow .htaccess overrides
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Set working directory to Apache document root
WORKDIR /var/www/html

# Copy project files into the container
COPY . /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]

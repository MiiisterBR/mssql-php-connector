
# MSSQL PHP Connector

Demo URL: https://mssql.misterbr.ir

This tool lets you connect to MS SQL databases via a dockerized PHP web application. It uses:
- PHP 8.1
- Apache Web Server
- MS SQL Server ODBC Driver (msodbcsql17)
- MS SQL Server Tools (mssql-tools)
- PHP Extensions: sqlsrv, pdo_sqlsrv
- Docker

## Usage

### Option 1: Using Docker Commands

1. Build the Docker image: ```docker build -t mssql-php-app .```

2. Run the container: ```docker run -d -p 80:80 mssql-php-app```

   *Note:* Ensure the port is available and avoid duplicate container names if running multiple instances.

3. Open your browser and go to: [http://localhost](http://localhost)

### Option 2: Using Docker Compose

To run the container on a custom port, create a file named `docker-compose.yml` with the following content:

```yaml
version: '3.8'

services:
  mssql-php:
    build: .
    container_name: mssql-php-container
    ports:
      - "8875:80"
    volumes:
      - .:/var/www/html
    restart: always
```

Then run:
```
docker-compose up -d --build
```

This maps port 80 in the container to port 8875 on your host. Access the application at: [http://localhost:8875](http://localhost:8875)

## For increased security, make sure to change the keys in the files inside the config folder.

Enjoy using this tool for connecting to your MS SQL databases!
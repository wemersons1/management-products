# Use a imagem oficial do PHP com Apache como base
FROM php:7.1-apache

# Atualize a lista de pacotes e instale dependências necessárias
RUN apt-get update && apt-get install -y \
    git \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Instale extensões PHP necessárias
RUN docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install gd mysqli pdo_mysql zip

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Exponha a porta 80 do Apache
EXPOSE 80

# Copie os arquivos do projeto para o contêiner
COPY . /var/www/html

# Defina o diretório de trabalho como o diretório do projeto
WORKDIR /var/www/html

# Execute o Composer para instalar as dependências do projeto
RUN composer install --no-interaction

# Instalação e configuração do MySQL
RUN apt-get update && apt-get install -y \
    mysql-server \
    && rm -rf /var/lib/apt/lists/*

# Criação de um usuário no MySQL com a senha "rede"
RUN service mysql start \
    && mysql -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'rede';" \
    && mysql -e "CREATE USER 'yiiuser'@'localhost' IDENTIFIED WITH mysql_native_password BY 'rede';" \
    && mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'yiiuser'@'localhost' WITH GRANT OPTION;" \
    && service mysql stop

# Comando padrão para iniciar o Apache
CMD ["apache2-foreground"]

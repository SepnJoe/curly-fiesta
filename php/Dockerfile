FROM php:8.2-cli

# Installiere mysqli
RUN docker-php-ext-install mysqli

WORKDIR /app
COPY . /app
EXPOSE 8000
CMD ["php", "-S", "0.0.0.0:8000"]

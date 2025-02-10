# README - Módulo de Solicitud de Inicio de PPS

## Introducción

Este proyecto es el resultado del TPI realizado en la materia electiva Entornos Gráficos (plan 2008). El sistema está diseñado para gestionar de manera eficiente y efectiva el proceso de Prácticas Profesionales Supervisadas (PPS) de los alumnos.

## Definición del Sitio Web

Este sitio web permite a los alumnos solicitar el inicio de sus Prácticas Profesionales Supervisadas de manera sencilla a través de una aplicación. Proporciona una plataforma para gestionar el seguimiento, aprobación y registro de avances en las PPS.

## Configuración del Proyecto

### Requisitos

-   XAMPP (PHP ≥ 8.0, MySQL, Apache)
-   Composer
-   Node.js y NPM (para assets y frontend)

### Instalación y Configuración en XAMPP

1. Descargar e instalar [XAMPP](https://www.apachefriends.org/index.html).
2. Clonar el repositorio:
    ```bash
    git clone https://github.com/cappll-lucia/TP_EntornosGraficos.git
    cd tp_v2
    ```
3. Instalar dependencias:
    ```bash
    composer install
    npm install && npm run build && npm run dev
    ```
4. Generar la clave de la aplicación:
    ```bash
    php artisan key:generate
    ```
5. Configurar el `.env`:

    ```ini
    APP_NAME=Laravel
    APP_ENV=local
    APP_KEY=<key-previamente-generada>
    APP_DEBUG=true
    APP_URL=http://localhost

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=<nombre-de-tu-bd>
    DB_USERNAME=<tu-nombre-usuario>
    DB_PASSWORD=<tu-clave>

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=<tu-email>
    MAIL_PASSWORD=<tu-clave-de-aplicaciones-terceras>
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=<tu-mail>
    MAIL_FROM_NAME="${APP_NAME}"
    ```

6. Iniciar los servicios de **Apache** y **MySQL** desde el Panel de Control de XAMPP.
7. Crear la base de datos en phpMyAdmin (`http://localhost/phpmyadmin/`).
8. Ejecutar migraciones:

    ```bash
    php artisan migrate
    ```

9. Iniciar el servidor de desarrollo:

    ```bash
    php artisan serve
    ```

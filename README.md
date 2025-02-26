# docfav
PASOS PARA EJECUTAR EL PROYECTO:

    1. descarga o clona el proyecto docfac desde githud

    2. destro del poyecto en la ruta raiz abre un cmd o PowerShell

    3. ejecuta para instalar orm de doctrime
        - docker-compose exec php composer require doctrine/orm

    4. ejecuta para crear los servicios en docker de MySql y Php
        - docker-compose up -d --build

    5. una vez que se crea la instancia de MySql crear la base de datos a utilizar
        - CREATE DATABASE test_database;

    6. ejecutar los sfuientes para ejecutar las migraciones de Doctrine
        - docker-compose exec php php vendor/bin/doctrine orm:generate-proxies
        - docker-compose exec php php vendor/bin/doctrine orm:schema-tool:update --force

UNA VEZ EJECUTADO CORRECTAMENTE EL PROYECTO
Si prefieres usar Postman:
    1. Abre Postman.
    2. Crea una nueva petición POST.
    3. URL: http://localhost:8000/register
    4. En Body, selecciona raw y JSON:
        json a enviar

        {
            "name": "Juan Perez",
            "email": "juanperez@example.com",
            "password": "Password@123"
        }
    6.Presiona Send.

EJECUTAR UNIT TEST E INTEGRACION
    - docker-compose exec php vendor/bin/phpunit
    - docker-compose exec php vendor/bin/phpunit --testsuite Integration
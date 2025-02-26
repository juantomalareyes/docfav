# Levantar los contenedores
docker-compose up -d --build

# Apagar los contenedores
docker-compose down

# Ejecutar migraciones de Doctrine
docker-compose exec php php vendor/bin/doctrine orm:schema-tool:update --force

# Ejecutar pruebas con PHPUnit
docker-compose exec php vendor/bin/phpunit
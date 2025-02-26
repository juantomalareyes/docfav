# Levantar los contenedores
up:
	docker-compose up -d --build

# Apagar los contenedores
down:
	docker-compose down

# Ejecutar las migraciones de Doctrine
migrate:
	docker-compose exec php php vendor/bin/doctrine orm:schema-tool:update --force

# Ejecutar las pruebas con PHPUnit
test:
	docker-compose exec php vendor/bin/phpunit
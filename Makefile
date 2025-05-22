# пересобирает контейнеры подготавливает базу для дев разработки
init: down rebuild composer-install fresh-migrate db-seed
# пересобирает контейнеры подготавливает базу и запускает все тесты
test: down rebuild tests-prepare run-tests
# считает покрытие тестов
test-coverage: rebuild tests-prepare run-tests-coverage

# собирает контейнеры
up:
	docker compose -f docker-compose.yml up -d
# Останавливает контейнеры и удаляет контейнеры, сети, тома и образы, созданные через up
down:
	docker compose -f docker-compose.yml down --remove-orphans
# пересобрать или перезапустить контейнеры
rebuild:
	docker compose -f docker-compose.yml up -d --build
# перейти в консоль контейнера с php
bash:
	docker exec -it slotegrator-api-php bash
# только для пересборок где появился кэш
rebuildNoCache:
	docker compose build --no-cache

tests-prepare:  composer-install  tests-fresh  tests-migrate seed-test

composer-install:
	docker exec -t  slotegrator-api-php composer install
# команды для тестов
tests-fresh:
	docker exec -t  slotegrator-api-php php artisan migrate:fresh --env=testing
tests-migrate:
	docker exec -t  slotegrator-api-php php artisan migrate --env=testing
test-reset-migrations:
	docker exec -t  slotegrator-api-php php artisan migrate:reset --env=testing
seed-test:
	docker exec -t  slotegrator-api-php php artisan db:seed --env=testing
run-tests:
	docker exec -t  slotegrator-api-php php artisan test
run-tests-coverage:
	docker exec -t --env XDEBUG_MODE=coverage slotegrator-api-php php artisan test --coverage
# Run specific test, example: make run-tests-specific test="/Tests/ExampleTest.php"
run-tests-specific:
	docker exec -t  slotegrator-api-php  php artisan test $(test)

# команды для инициализации dev среды
fresh-migrate:
	docker exec -t  slotegrator-api-php php artisan migrate:fresh
db-seed:
	docker exec -t  slotegrator-api-php php artisan db:seed

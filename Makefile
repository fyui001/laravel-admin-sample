CONTAINER_ID = `docker-compose ps -q app`

init:
	@cp .env.example .env

setup:
	@make build
	@make up
	@make composer_install
	@docker compose exec app php artisan key:generate
	@make migrate_seed
	@make cache_clear
	@make test_seed
	@make permission
	@docker compose exec app php artisan storage:link

build:
	@docker compose build

composer_install:
	@docker compose exec app composer install --ignore-platform-reqs

cache_clear:
	@docker compose exec app php artisan cache:clear
	@docker compose exec app php artisan view:clear
	@docker compose exec app php artisan route:clear
	@docker compose exec app php artisan config:clear

permission:
	@docker compose exec app chmod -R 777 /code/storage bootstrap/cache

migrate:
	@docker compose exec app php artisan migrate

migrate_seed:
	@docker compose exec app php artisan migrate:fresh --seed --drop-views

test_seed:
	@docker compose exec app php artisan migrate:fresh --seed --drop-views --env=testing

test_feature:
	@docker compose exec app bash -c "vendor/bin/phpunit --testsuite Feature --testdox --colors=always"

test_unit:
	@docker compose exec app bash -c "vendor/bin/phpunit --testsuite Unit --testdox --colors=always"

bash:
	@docker compose exec app bash

ide_helper:
	@docker compose exec app php artisan ide-helper:generate

ide_helper_models:
	@docker compose exec app php artisan ide-helper:models --dir="infra/EloquentModels"

up:
	@docker compose up -d

down:
	@docker compose down

cp_vendor:
	rm -rf vendor/*
	docker cp $(CONTAINER_ID):/code/vendor ./vendor
	@echo '"one sync vendor!'

phpstan:
	@docker compose exec app bash -c "vendor/bin/phpstan analyse"

phpcs_domain:
	@docker compose exec app bash -c "vendor/bin/phpcs --config-set show_warnings 0 && vendor/bin/phpcs domain"

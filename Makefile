init:
	@cp .env.example .env
	@cp docker-compose.example.yml @docker-compose.yml

build:
	@docker-compose build

cache_clear:
	@docker-compose exec app php artisan cache:clear
	@docker-compose exec app php artisan view:clear
	@docker-compose exec app php artisan route:clear
	@docker-compose exec app php artisan config:clear

migrate:
	@docker-compose exec app php artisan migrate

migrate_seed:
	@docker-compose exec app php artisan migrate:fresh --seed --drop-views

test_seed:
	@docker-compose exec app php artisan migrate:fresh --seed --drop-views --env=testing

test:
	@docker-compose exec app ./vendor/bin/phpunit

ssh:
	@docker-compose exec app ash

up:
	@docker-compose up -d

setup:
	@docker-compose exec app php artisan key:generate
	@make cache_clear
	@make migrate_seed
	@make test_seed
	@docker-compose exec app php artisan storage:link


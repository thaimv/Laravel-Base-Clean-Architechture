ifneq ($(shell command -v docker compose),)
	DC := docker compose
else
	DC := docker-compose
endif

build:
	$(DC) up -d --build

up:
	$(DC) up -d

php:
	$(DC) exec php bash

down:
	$(DC) down

ps:
	$(DC) ps

migrate:
	$(DC) exec php php artisan migrate

seed:
	$(DC) exec php php artisan db:seed

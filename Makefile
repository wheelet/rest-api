DOCKER_COMPOSE = docker-compose
PHP_CONTAINER = app
DOCKER_EXEC = $(DOCKER_COMPOSE) exec $(PHP_CONTAINER)
YII = php yii

.PHONY: setup
setup: env docker-up composer-install migrate

.PHONY: env
env:
	@if [ ! -f .env ]; then \
		echo "Creating .env file..."; \
		cp .env.example .env; \
		echo ".env file created."; \
	else \
		echo ".env file already exists."; \
	fi

.PHONY: docker-up
docker-up:
	$(DOCKER_COMPOSE) up -d

.PHONY: docker-down
docker-down:
	$(DOCKER_COMPOSE) down

.PHONY: docker-build
docker-build:
	$(DOCKER_COMPOSE) up -d --build

.PHONY: docker-restart
docker-restart: docker-down docker-up

.PHONY: docker-logs
docker-logs:
	$(DOCKER_COMPOSE) logs -f

.PHONY: composer-install
composer-install:
	$(DOCKER_EXEC) composer install

.PHONY: composer-update
composer-update:
	$(DOCKER_EXEC) composer update

.PHONY: migrate
migrate:
	$(DOCKER_EXEC) $(YII) migrate

.PHONY: migrate-fresh
migrate-fresh:
	$(DOCKER_EXEC) $(YII) migrate/fresh --interactive=0

.PHONY: migrate-create
migrate-create:
	@read -p "Enter migration name: " name; \
	$(DOCKER_EXEC) $(YII) migrate/create $$name

.PHONY: clear-cache
clear-cache:
	$(DOCKER_EXEC) $(YII) cache/flush-all

# Помощь
.PHONY: help
help:
	@echo "Доступные команды:"
	@echo ""
	@echo "setup              - Полная настройка проекта (env, docker-up, composer-install, migrate)"
	@echo "env                - Создать .env файл из .env.example"
	@echo "docker-up          - Запустить Docker-контейнеры"
	@echo "docker-down        - Остановить Docker-контейнеры"
	@echo "docker-build       - Пересобрать и запустить Docker-контейнеры"
	@echo "docker-restart     - Перезапустить Docker-контейнеры"
	@echo "docker-logs        - Показать логи Docker-контейнеров"
	@echo "composer-install   - Установить зависимости через Composer"
	@echo "composer-update    - Обновить зависимости через Composer"
	@echo "migrate            - Применить все миграции"
	@echo "migrate-fresh      - Сбросить БД и применить все миграции заново"
	@echo "migrate-create     - Создать новую миграцию"
	@echo "clear-cache        - Очистить кэш приложения"
	@echo "help               - Показать эту справку"

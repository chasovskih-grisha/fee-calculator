CONSOLE = bin/console
DOCKER_CONTAINER_PHP = fee-calculator-php
DOCKER_EXEC = docker exec $(DOCKER_CONTAINER_PHP)
DOCKER_CONSOLE = $(DOCKER_EXEC) $(CONSOLE)
DOCKER_EXEC_D = docker exec -d $(DOCKER_CONTAINER_PHP)
GIT_BRANCH := $(shell git rev-parse --abbrev-ref HEAD)

test: phpunit
deploy: git-pull-origin composer start
start: docker-up composer
stop: docker-down
restart: stop start

## Docker ##

docker-up:
	docker-compose up -d --build --remove-orphans

docker-down:
	docker-compose down -v --remove-orphans

docker-ps:
	docker-compose ps

docker-logs:
	docker-compose logs -t -f --tail="all"

enter:
	docker exec -it $(DOCKER_CONTAINER_PHP) sh

## Composer ##

composer:
	$(DOCKER_EXEC) composer install

composer-update:
	$(DOCKER_EXEC) composer update

### Cache ###

cache: cache-clear

cache-clear:
	$(DOCKER_EXEC) rm -rf var/cache/*
	$(DOCKER_CONSOLE) cache:clear -v

clear-logs:
	$(DOCKER_EXEC) rm -f var/log/*.log
	$(DOCKER_EXEC) rm -f var/log/**/*.log
	$(DOCKER_EXEC) rm -f var/log/**/**/*.log

## GIT ##

git-pull-origin:
	git pull origin

## PHP CS FIXER ##

FIXER_OPTIONS = --diff --config=config/tools/php-cs-fixer.php --cache-file=var/tmp/php-cs-fixer.cache

fixer:
	$(DOCKER_EXEC) vendor/bin/php-cs-fixer fix src $(FIXER_OPTIONS)

fixer-test:
	$(DOCKER_EXEC) vendor/bin/php-cs-fixer --dry-run --verbose fix src $(FIXER_OPTIONS)

psalm:
	$(DOCKER_EXEC) vendor/bin/psalm

## TESTS ##

phpunit:
	$(DOCKER_EXEC) bin/phpunit src

## PHP Metrics ##

metrics:
	$(DOCKER_EXEC) ./vendor/bin/phpmetrics --report-html=./public/metrics .

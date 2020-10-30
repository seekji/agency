#!/usr/bin/make -f

help:
	@echo ""
	@echo "usage: make COMMAND"
	@echo ""
	@echo "Commands:"
	@echo "  app-init                   Install project"
	@echo "  app-run                    Run app"
	@echo "  app-restart                Restart app"
	@echo "  app-stop                   Stop app"
	@echo "  app-cache-clear            Clear app cache"
	@echo "  database-migrate           Apply app migrations"
	@echo "  database-diff              Show diff in migrations"
	@echo "  database-load-fixtures     Load database fixtures"
	@echo "  database-rollback          Rollback to previous migration version"
	@echo "  database-drop              Drop database"
	@echo "  database-create            Create database"
	@echo "  database-create            Recreate database (helpful for switching git branches)"

app-init:
	./build/run-dev.sh

app-run:
	docker-compose up -d

app-restart:
	docker-compose restart

app-stop:
	docker-compose down -v

# @primer make ENV=prod app-cache-clear
app-cache-clear: app-run
	docker-compose exec --user www-data app php bin/console cache:clear -e "${ENV}"

database-migrate: app-run
	docker-compose exec --user www-data app php bin/console doctrine:migration:migrate -n

database-diff: app-run
	docker-compose exec --user www-data app php bin/console doctrine:migration:diff

database-load-fixtures: app-run
	docker-compose exec --user www-data app php bin/console doctrine:fixtures:load -n

database-drop: app-run
	docker-compose exec --user www-data app php bin/console doctrine:database:drop --force

database-create: app-run
	docker-compose exec --user www-data app php bin/console doctrine:database:create

database-rollback: app-run
	docker-compose exec --user www-data app php bin/console doctrine:migration:migrate prev -n

database-recreate: app-run database-drop database-create database-migrate database-load-fixtures
.PHONY: init-project update-database-schema load-fixtures-data run-tests

init-project:
	docker compose up --build -d
	docker exec server_lluis php bin/console --no-interaction assets:install

update-database-schema:
	docker exec server_lluis php bin/console --no-interaction doctrine:database:create
	docker exec server_lluis php bin/console --no-interaction doctrine:migrations:migrate
	docker exec server_lluis php bin/console --no-interaction --env=test doctrine:database:create
	docker exec server_lluis php bin/console --no-interaction --env=test doctrine:migrations:migrate
	docker exec server_lluis php bin/console --no-interaction --env=test hautelook:fixtures:load

load-fixtures-data:
	docker exec server_lluis php bin/console --no-interaction hautelook:fixtures:load

run-tests:
	docker exec server_lluis php bin/phpunit

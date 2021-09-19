#Makefile

install:
	composer install
validate:
	composer validate
lint:
	composer run-script phpcs -- --standard=PSR12 app
test_phpunit:
	composer exec --verbose phpunit tests
test:
	php artisan test
test-coverage:
	composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml
setup:
	composer install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	touch database/database.sqlite
	php artisan migrate
	php artisan db:seed
	npm install
start:
	php artisan serve
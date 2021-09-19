#Makefile

install:
	composer install
lint:
	composer run-script phpcs -- --standard=PSR12 app tests
test:
	php artisan test
test-coverage:
	composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml
setup:
	composer install
	php -r "file_exists('.env') || copy('.env.example', '.env');"
	php artisan key:generate
start:
	php artisan serve
deploy:
	git push heroku main

test_phpunit:
	composer exec --verbose phpunit tests
validate:
	composer validate
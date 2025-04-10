install:
	composer install

lint:
	./vendor/bin/phpcs -- -v --standard=PSR12  routes/web.php  app/Http/Controllers/TaskController.php
test:
	composer exec --verbose phpunit tests

test-coverage:
	composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml

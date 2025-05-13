install:
	touch ./database/database.sqlite
	composer install
	npm i
	npm run build

lint:
	./vendor/bin/phpcs -- -v --standard=PSR12  routes/web.php  app/Http/Controllers/TaskController.php app/Http/Controllers/TaskStatusController.php app/Http/Controllers/LabelController.php
test:
	composer exec --verbose phpunit tests

#test-coverage:
#	composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml

test-coverage:
	composer exec --verbose phpunit tests -- --coverage-text

seeders:
	php artisan db:seed --class=TaskStatusSeeder

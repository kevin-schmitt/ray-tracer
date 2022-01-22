functional:
	vendor/bin/behat

analyse:
	composer validate --strict
	php vendor/bin/phpstan analyse src -l 9
	php vendor/bin/php-cs-fixer fix
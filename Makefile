functional:
	vendor/bin/behat

analyse:
	composer validate --strict
	php vendor/bin/phpstan analyse src -l 9
	vendor/bin/phpcpd src
	php vendor/bin/php-cs-fixer fix

.PHONY: test

install:
	rm -rf app/cache/dev/*
	composer install -o
	app/console doc:da:drop --force
	app/console doc:da:cr
	app/console doc:sc:cr
	app/console doc:fix:load -n

test:
	rm -rf app/cache/test/*
	app/console doc:da:drop --force --env=test
	app/console doc:da:cr --env=test
	app/console doc:sc:cr --env=test
	app/console doc:fix:load -n --env=test
	bin/phpunit -c app src

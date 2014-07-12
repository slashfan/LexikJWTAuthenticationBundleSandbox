.PHONY: test

test:
	rm -rf app/cache/test/*
	bin/phpunit -c app src

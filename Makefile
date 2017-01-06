install:
	composer install

update:
	composer update

run:
	cd docker; docker-compose up -d

stop:
	cd docker; docker-compose stop

test:
	./vendor/bin/codecept run

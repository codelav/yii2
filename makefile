#todo make own build image to avoid using noname images
composer-install:
	docker run --rm \
	--volume $(PWD):/app \
	--user $(id -u):$(id -g) \
	koutsoumpos89/composer-php7.1 \
	install \
	--optimize-autoloader \
	--no-interaction \
	--prefer-dist \

migrate:
	docker exec americor-php php yii migrate --interactive=0

#------------------------------------------------------------------------------
# PHPUnit Makefile
#------------------------------------------------------------------------------

PHPUNIT_IMAGE_NAME=flo/phpunit

PHPUNIT_DOCKER_CMD = docker run --rm \
	-v ${HOST_SOURCE_PATH}:/var/www/app \
	-u ${USER_ID}:${GROUP_ID} \
	-w /var/www/app \
	--network="docker_flo" \
	${PHPUNIT_IMAGE_NAME} \
	vendor/bin/simple-phpunit ${1}

#------------------------------------------------------------------------------

phpunit: ##@phpunit launch PHPUnit tests
	$(call PHPUNIT_DOCKER_CMD, )

phpunit-debug: ##@phpunit launch PHPUnit tests
	$(call PHPUNIT_DOCKER_CMD, > /tmp/debug.html)

phpunit-image-build: ##@phpunit build PHPUnit docker container
	docker build --force-rm -t ${PHPUNIT_IMAGE_NAME} docker/images/phpunit

#------------------------------------------------------------------------------

clean-phpunit: ##@phpunit clean PHPUnit docker container
	docker rmi ${PHPUNIT_IMAGE_NAME}

#------------------------------------------------------------------------------

.PHONY: phpunit phpunit-image-build clean-phpunit

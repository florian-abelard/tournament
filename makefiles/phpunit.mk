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

phpunit: phpunit-test-environment ##@phpunit launch PHPUnit tests
	$(call PHPUNIT_DOCKER_CMD, --verbose)

phpunit-image-build: docker/images/phpunit/Dockerfile ##@phpunit build PHPUnit docker container
	docker build --force-rm -t ${PHPUNIT_IMAGE_NAME} docker/images/phpunit

phpunit-test-environment: vendor/bin/simple-phpunit phpunit-image-build

vendor/bin/simple-phpunit: composer-install

#------------------------------------------------------------------------------

clean-phpunit: ##@phpunit clean PHPUnit docker container
	docker rmi ${PHPUNIT_IMAGE_NAME}

#------------------------------------------------------------------------------

.PHONY: phpunit phpunit-image-build phpunit-test-environment clean-phpunit

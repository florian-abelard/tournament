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

phpunit: phpunit-prepare-environment ##@phpunit launch PHPUnit tests
	$(call PHPUNIT_DOCKER_CMD, --verbose)

phpunit-build-image: ##@phpunit build PHPUnit docker image
	docker build --force-rm -t ${PHPUNIT_IMAGE_NAME} docker/images/phpunit

phpunit-prepare-environment: vendor/bin/simple-phpunit phpunit-build-image-if-needed

phpunit-build-image-if-needed:
	@if [ -z "`docker images -q ${PHPUNIT_IMAGE_NAME}`" ]; then \
		make phpunit-build-image;\
	fi;

vendor/bin/simple-phpunit: composer-install

#------------------------------------------------------------------------------

clean-phpunit: ##@phpunit clean PHPUnit docker container
	docker rmi ${PHPUNIT_IMAGE_NAME}

#------------------------------------------------------------------------------

.PHONY: phpunit phpunit-build-image phpunit-build-image-if-needed phpunit-prepare-environment clean-phpunit

#------------------------------------------------------------------------------
# floTournoi Makefile
#------------------------------------------------------------------------------

USER_ID=$(shell id -u)
GROUP_ID=$(shell id -g)
HOST_SOURCE_PATH=$(shell pwd)
DOCKER_COMPOSE_FILE?=docker/docker-compose.yml

export USER_ID
export GROUP_ID

$(foreach var,$(shell cat .env),$(eval export ${var}))

#------------------------------------------------------------------------------

docker-compose-exec = docker-compose -f ${DOCKER_COMPOSE_FILE} exec -T --user www-data web ${1}
docker-compose-exec-db = docker-compose -f ${DOCKER_COMPOSE_FILE} exec -T --user root ${DATABASE_HOST} ${1}

#------------------------------------------------------------------------------

include makefiles/composer.mk
include makefiles/docker.mk
include makefiles/help.mk
include makefiles/mariadb.mk
include makefiles/phpunit.mk
include makefiles/webpack.mk

#------------------------------------------------------------------------------

init: composer-install webpack-install webpack-build db-init ## install project dependencies, create database

test:
	echo ${APP_SECRET}

#------------------------------------------------------------------------------

clean: clean-docker clean-composer clean-webpack clean-built-assets clean-phpunit ## clean project dependencies, docker containers...

#------------------------------------------------------------------------------

.PHONY: init help

#------------------------------------------------------------------------------

.DEFAULT_GOAL := help

help:
	@echo "================================================================================"
	@echo "floTournoi Makefile"
	@echo "================================================================================"
	@echo
	@perl -e '$(HELP_FUNC)' $(MAKEFILE_LIST)
	@echo "================================================================================"

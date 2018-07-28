#------------------------------------------------------------------------------
# floTournoi Makefile
#------------------------------------------------------------------------------

USER_ID=$(shell id -u)
GROUP_ID=$(shell id -g)
HOST_SOURCE_PATH=$(shell pwd)
DOCKER_COMPOSE_FILE?=docker/docker-compose.yml

export USER_ID
export GROUP_ID

#------------------------------------------------------------------------------

.env: .env.dist
	@if [ -f .env ]; \
	then\
		echo "The .env.dist file has changed. Please check your .env file.";\
		touch .env;\
		exit 1;_\
	else\
		echo "Create and configure your .env file to continue.";\
	fi

$(foreach var,$(shell cat .env),$(eval export ${var}))

#------------------------------------------------------------------------------

include makefiles/composer.mk
include makefiles/docker.mk
include makefiles/help.mk
include makefiles/mariadb.mk
include makefiles/phpunit.mk
include makefiles/webpack.mk

#------------------------------------------------------------------------------

init: .env composer-install webpack-install webpack-build db-init ## install project dependencies, create database

#------------------------------------------------------------------------------

clean: clean-docker clean-composer clean-webpack clean-built-assets clean-phpunit ## clean project dependencies, docker containers...

#------------------------------------------------------------------------------

.DEFAULT_GOAL := help

help:
	@echo "================================================================================"
	@echo "floTournoi Makefile"
	@echo "================================================================================"
	@echo
	@perl -e '$(HELP_FUNC)' $(MAKEFILE_LIST)
	@echo "================================================================================"

#------------------------------------------------------------------------------

.PHONY: init clean help

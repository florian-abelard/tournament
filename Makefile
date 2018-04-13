#------------------------------------------------------------------------------
# floTournoi Makefile
#------------------------------------------------------------------------------

USER_ID=$(shell id -u)
GROUP_ID=$(shell id -g)
HOST_SOURCE_PATH=$(shell pwd)

export USER_ID
export GROUP_ID

#------------------------------------------------------------------------------

include makefiles/composer.mk
include makefiles/docker.mk
include makefiles/help.mk
include makefiles/webpack.mk

#------------------------------------------------------------------------------

init: ## install project dependencies
	install-dependencies

install-dependencies: composer-install

test: ## this is a test
	@echo TEST

#------------------------------------------------------------------------------

clean: ## clean project dependencies, docker containers...
	clean-docker clean-composer clean-webpack clean-built-assets

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

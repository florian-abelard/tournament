#------------------------------------------------------------------------------
# floTournoi Makefile
#------------------------------------------------------------------------------

USER_ID=$(shell id -u)
GROUP_ID=$(shell id -g)

export USER_ID
export GROUP_ID

#------------------------------------------------------------------------------

include makefiles/help.mk
include makefiles/docker.mk
include makefiles/composer.mk

#------------------------------------------------------------------------------

init: ## install project dependencies
	install-dependencies

install-dependencies: composer-install

test: ## this is a test
	@echo TEST

#------------------------------------------------------------------------------

clean: ## clean project dependencies, docker containers...
	clean-docker clean-composer

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

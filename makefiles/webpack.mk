#------------------------------------------------------------------------------
# Webpack Makefile
#------------------------------------------------------------------------------

NPM_DOCKER_CMD = docker run --rm \
	-v ${HOST_SOURCE_PATH}:/var/app \
	-v ${HOME}/.npm:/opt/.npm \
	-w /var/app \
	node:8 \
	npm ${1}

#------------------------------------------------------------------------------

webpack-install: ##@webpack install webpack-encore node package
	$(call NPM_DOCKER_CMD, install --silent)

webpack-build: ##@webpack build assets for development environment
	$(call NPM_DOCKER_CMD, run dev)

webpack-build-production: ##@webpack build assets for production environment
	$(call NPM_DOCKER_CMD, run build)

webpack-watch: ##@webpack run webpack watch
	$(call NPM_DOCKER_CMD, run watch)

#------------------------------------------------------------------------------

clean-webpack: ##@webpack clean webpack node module
	test ! -e node_modules || -rm -rf node_modules

clean-built-assets: ##@webpack clean built assets
	test ! -e public/build || rm -rf public/build

#------------------------------------------------------------------------------

.PHONY: webpack-install webpack-build webpack-build-production webpack-watch clean-webpack clean-built-assets

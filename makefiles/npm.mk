#------------------------------------------------------------------------------
# Webpack Makefile
#------------------------------------------------------------------------------

NPM_DOCKER_CMD = docker run --rm \
	-v ${HOST_SOURCE_PATH}:/var/www/app \
	-v ${HOME}/.npm:/opt/.npm \
	-u ${USER_ID}:${GROUP_ID} \
	-w /var/www/app \
	node:8 \
	npm ${1}

#------------------------------------------------------------------------------

npm-install: package-lock.json ##@npm install npm dependencies
	$(call NPM_DOCKER_CMD, install --silent)

npm-update: package.json ##@npm update npm dependencies
	$(call NPM_DOCKER_CMD, update)

#------------------------------------------------------------------------------

webpack-build: ##@npm build assets for development environment
	$(call NPM_DOCKER_CMD, run dev)

webpack-build-production: ##@npm build assets for production environment
	$(call NPM_DOCKER_CMD, run build)

webpack-watch: ##@npm run webpack watch
	$(call NPM_DOCKER_CMD, run watch)

#------------------------------------------------------------------------------

clean-npm: ##@npm clean npm dependencies
	test ! -e node_modules || rm -rf node_modules

clean-built-assets: ##@npm clean built assets
	test ! -e public/build || rm -rf public/build

#------------------------------------------------------------------------------

.PHONY: webpack-build webpack-build-production webpack-watch clean-npm clean-built-assets

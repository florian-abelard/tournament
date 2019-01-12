#------------------------------------------------------------------------------
# Composer Makefile
#------------------------------------------------------------------------------

COMPOSER_BIN := composer

#------------------------------------------------------------------------------

composer-install: ##@composer install composer dependencies
	$(COMPOSER_BIN) install --ignore-platform-reqs

composer-update: ##@composer update composer dependencies
	$(COMPOSER_BIN) update --ignore-platform-reqs

composer-dump-autoload: ##@composer dump autoloading
	$(COMPOSER_BIN) dump-autoload

#------------------------------------------------------------------------------

clean-composer:##@composer clean composer
	test ! -e vendor || rm -r vendor

#------------------------------------------------------------------------------

.PHONY: composer-install composer-update clean-composer

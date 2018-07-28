#------------------------------------------------------------------------------
# Composer Makefile
#------------------------------------------------------------------------------

COMPOSER_BIN := composer

#------------------------------------------------------------------------------

composer-install: composer.lock ##@composer install composer
	$(COMPOSER_BIN) install --ignore-platform-reqs

composer-update: composer.json ##@composer update composer
	$(COMPOSER_BIN) update --ignore-platform-reqs

#------------------------------------------------------------------------------

clean-composer:##@composer clean composer
	test ! -e vendor || rm -r vendor

#------------------------------------------------------------------------------

.PHONY: clean-composer

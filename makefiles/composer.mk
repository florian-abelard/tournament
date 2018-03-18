#------------------------------------------------------------------------------
# Composer Makefile
#------------------------------------------------------------------------------

COMPOSER_BIN := composer

#------------------------------------------------------------------------------

composer-install:
	composer install --ignore-platform-reqs

composer-update:
	$(COMPOSER_BIN) update --ignore-platform-reqs

#------------------------------------------------------------------------------

clean-composer:
	test ! -e vendor || rm -r vendor

#------------------------------------------------------------------------------

.PHONY: composer-install composer-update clean-composer

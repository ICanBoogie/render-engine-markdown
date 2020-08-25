# customization

PACKAGE_NAME = icanboogie/render-engine-markdown
PACKAGE_VERSION = 0.3
PHPUNIT_VERSION = phpunit-8.phar
PHPUNIT_FILENAME = build/$(PHPUNIT_VERSION)
PHPUNIT = php $(PHPUNIT_FILENAME)
XDEBUG_BASE=/usr/local/etc/php/conf.d/docker-php-ext-xdebug

# do not edit the following lines

usage:
	@echo "test:  Runs the test suite.\ndoc:   Creates the documentation.\nclean: Removes the documentation, the dependencies and the Composer files."

vendor:
	@COMPOSER_ROOT_VERSION=$(PACKAGE_VERSION) composer install

update:
	@COMPOSER_ROOT_VERSION=$(PACKAGE_VERSION) composer update

# testing

test-dependencies: vendor $(PHPUNIT_FILENAME)

$(PHPUNIT_FILENAME):
	mkdir -p build
	curl -sL https://phar.phpunit.de/$(PHPUNIT_VERSION) -o $(PHPUNIT_FILENAME)
	chmod +x $(PHPUNIT_FILENAME)

test: test-dependencies xdebug-disable
	@$(PHPUNIT)

test-coverage: test-dependencies xdebug-disable
	@mkdir -p build/coverage
	@$(PHPUNIT) --coverage-html ../build/coverage --coverage-text

test-coveralls: test-dependencies xdebug-disable
	@mkdir -p build/logs
	COMPOSER_ROOT_VERSION=$(PACKAGE_VERSION) composer require php-coveralls/php-coveralls
	@$(PHPUNIT) --coverage-clover ../build/logs/clover.xml
	php vendor/bin/php-coveralls -v

xdebug-enable:
	@if [ -f  $(XDEBUG_BASE).txt ]; then \
		mv  $(XDEBUG_BASE).txt  $(XDEBUG_BASE).ini; \
		echo "Enabled Xdebug"; \
	fi

xdebug-disable:
	@if [ -f  $(XDEBUG_BASE).ini ]; then \
		mv  $(XDEBUG_BASE).ini  $(XDEBUG_BASE).txt; \
		echo "Disabled Xdebug"; \
	fi

#doc

doc: vendor
	@mkdir -p build/docs
	@apigen generate \
	--source lib \
	--destination build/docs/ \
	--title "$(PACKAGE_NAME) v$(PACKAGE_VERSION)" \
	--template-theme "bootstrap"

# utils

clean:
	@rm -fR build
	@rm -fR vendor
	@rm -f composer.lock

.PHONY: all autoload doc clean test test-coverage test-coveralls test-dependencies update

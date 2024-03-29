# customization

PACKAGE_NAME = icanboogie/render-engine-markdown
PHPUNIT = vendor/bin/phpunit

# do not edit the following lines

.PHONY: usage
usage:
	@echo "test:  Runs the test suite.\ndoc:   Creates the documentation.\nclean: Removes the documentation, the dependencies and the Composer files."

vendor:
	@composer install

# testing

.PHONY: test-dependencies
test-dependencies: vendor

.PHONY: test
test: test-dependencies
	@$(PHPUNIT)

.PHONY: test-coverage
test-coverage: test-dependencies xdebug-disable
	@mkdir -p build/coverage
	@XDEBUG_MODE=coverage $(PHPUNIT) --coverage-html ../build/coverage --coverage-text

.PHONY: test-coveralls
test-coveralls: test-dependencies xdebug-disable
	@mkdir -p build/logs
	@$(PHPUNIT) --coverage-clover ../build/logs/clover.xml

.PHONY: test-container
test-container:
	@docker-compose run --rm app bash
	@docker-compose down -v

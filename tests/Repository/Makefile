TEST_APP_BASENAME=app
TEST_APP_DIR?=${TEST_APP_BASENAME}

.PHONY: create-test-application
create-test-application: remove-test-application install-skeleton add-requirements copy-recipe

.PHONY: remove-test-application
remove-test-application:
	rm -rf ${TEST_APP_BASENAME}

.PHONY: install-skeleton
install-skeleton:
	symfony new ${TEST_APP_BASENAME}

.PHONY: add-requirements
add-requirements:
	(cd ${TEST_APP_BASENAME} && composer require doctrine/orm)
	(cd ${TEST_APP_BASENAME} && composer require pagerfanta/core)
	(cd ${TEST_APP_BASENAME} && composer require --dev phpunit/phpunit)

.PHONY: copy-recipe
copy-recipe:
	cp -R ./../../monofony/repository-domain-meta/0.1/* ${TEST_APP_DIR}
	cp -R ./../../monofony/repository-infrastracture-meta/0.1/* ${TEST_APP_DIR}

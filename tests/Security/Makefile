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
	(cd ${TEST_APP_BASENAME} && composer require doctrine/orm "2.*" doctrine/doctrine-bundle --no-interaction)
	(cd ${TEST_APP_BASENAME} && composer require symfony/messenger symfony/security-core symfony/security-bundle)
	(cd ${TEST_APP_BASENAME} && composer require sylius/resource-bundle sylius/grid-bundle --no-interaction)
	(cd ${TEST_APP_BASENAME} && composer require pagerfanta/core)
	(cd ${TEST_APP_BASENAME} && composer require --dev phpunit/phpunit)

.PHONY: copy-recipe
copy-recipe:
	cp -R ./../../monofony/cqrs-application-meta/0.1/* ${TEST_APP_DIR}
	cp -R ./../../monofony/cqrs-infrastructure-meta/0.1/* ${TEST_APP_DIR}
	cp -R ./../../monofony/repository-domain-meta/0.1/* ${TEST_APP_DIR}
	cp -R ./../../monofony/repository-infrastructure-meta/0.1/* ${TEST_APP_DIR}
	cp -R ./../../monofony/security-domain-meta/0.1/* ${TEST_APP_DIR}
	cp -R ./../../monofony/security-application-meta/0.1/* ${TEST_APP_DIR}
	cp -R ./../../monofony/security-infrastructure-meta/0.1/* ${TEST_APP_DIR}
	cp -R ./../../monofony/security-admin-meta/0.1/* ${TEST_APP_DIR}

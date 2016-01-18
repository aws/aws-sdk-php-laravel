test: remove-deps
	make test-laravel
	make test-lumen

test-laravel:
	composer require laravel/framework
	vendor/bin/phpunit
	make uninstall-laravel

test-lumen:
	composer require laravel/lumen-framework
	vendor/bin/phpunit
	make uninstall-lumen

remove-deps:
	rm -rf vendor

uninstall-laravel: remove-deps
	composer remove laravel/framework

uninstall-lumen: remove-deps
	composer remove laravel/lumen-framework

# Ensures that the TAG variable was passed to the make command
check-tag:
	$(if $(TAG),,$(error TAG is not defined. Pass via "make tag TAG=4.2.1"))

# Creates a release but does not push it. This task updates the changelog
# with the TAG environment variable, replaces the VERSION constant, ensures
# that the source is still valid after updating, commits the changelog and
# updated VERSION constant, creates an annotated git tag using chag, and
# prints out a diff of the last commit.
tag: check-tag
	@echo Tagging $(TAG)
	chag update $(TAG)
	sed -i '' -e "s/VERSION = '.*'/VERSION = '$(TAG)'/" src/AwsServiceProvider.php
	php -l src/AwsServiceProvider.php
	git commit -a -m '$(TAG) release'
	chag tag
	@echo "Release has been created. Push using 'make release'"
	@echo "Changes made in the release commit"
	git diff HEAD~1 HEAD

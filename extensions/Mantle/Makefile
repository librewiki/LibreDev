MW_INSTALL_PATH ?= ../..

remotes:
	wget http://builds.handlebarsjs.com.s3.amazonaws.com/handlebars-latest.js -O javascripts/externals/handlebars.js

jshint: nodecheck
	@node_modules/.bin/jshint javascripts/* tests/javascripts* --config .jshintrc

nodecheck:
	@scripts/nodecheck.sh

phpunit:
	cd ${MW_INSTALL_PATH}/tests/phpunit && php phpunit.php --configuration ${MW_INSTALL_PATH}/extensions/Mantle/tests/suite.xml --group=Mantle

qunit:
	@scripts/qunit.sh Mantle

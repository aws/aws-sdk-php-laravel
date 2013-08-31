<?php

// Make sure Composer has been run
if (!file_exists(__DIR__ . '/../composer.lock')) {
    die('You must do a Composer install before running the tests.');
}

// Include Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Include the base test class that doesn't get autoloaded
require_once __DIR__ . '/Aws/Laravel/Test/AwsServiceProviderTestCase.php';

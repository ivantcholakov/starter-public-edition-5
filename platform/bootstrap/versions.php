<?php

/**
 * Platform (Application Starter) Version
 * @var    string
 */
define('PLATFORM_VERSION', '5.0.0-alpha.8');


/**
 * The Whole End-Product Version, Set Accordingly
 * @var    string
 */
define('PRODUCT_VERSION', '1.0.0');


/**
 * Minimum Required PHP Version
 * @var    string
 */
define('PLATFORM_PHP_VERSION_MIN', '7.2.5');


if (! is_php(PLATFORM_PHP_VERSION_MIN)) {

    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'PHP '.PLATFORM_PHP_VERSION_MIN.' or newer is required.';
    exit(3); // EXIT_CONFIG
}

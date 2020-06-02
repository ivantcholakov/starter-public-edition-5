<?php

/*
 *---------------------------------------------------------------
 * The Bootstrap folder, for a custom initialization.
 *---------------------------------------------------------------
 */
define('BOOTSTRAPPATH', rtrim(str_replace('\\', '/', realpath(dirname(__FILE__).'/bootstrap')), '/').'/');

if (BOOTSTRAPPATH == '' || BOOTSTRAPPATH == '/' || !is_dir(BOOTSTRAPPATH)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your bootstrap folder path (BOOTSTRAPPATH) does not appear to be set correctly. Please, make corrections within the following file: '.__FILE__;
    exit(3);
}

/*
 *---------------------------------------------------------------
 * Get version data.
 *---------------------------------------------------------------
 */
require BOOTSTRAPPATH.'versions.php';

if (version_compare(PHP_VERSION, PLATFORM_PHP_VERSION_MIN, '<')) {

    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'PHP '.PLATFORM_PHP_VERSION_MIN.' or newer is required.';
    exit(3);
}

/*
 *---------------------------------------------------------------
 * Do our custom initialization first.
 *---------------------------------------------------------------
 */
require_once BOOTSTRAPPATH.'bootstrap.php';


// Location of the Paths config file.
// This is the line that might need to be changed, depending on your folder structure.
$pathsPath = realpath(APPPATH . 'Config/Paths.php');
// ^^^ Change this if you move your application folder

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */


// Load our paths config file
require $pathsPath;
$paths = new Config\Paths();

// Location of the framework bootstrap file.
$app = require rtrim($paths->systemDirectory, '/ ') . '/bootstrap.php';

/*
 *---------------------------------------------------------------
 * LAUNCH THE APPLICATION
 *---------------------------------------------------------------
 * Now that everything is setup, it's time to actually fire
 * up the engines and make this app do its thang.
 */
$app->run();

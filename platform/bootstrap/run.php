<?php

/*
 *---------------------------------------------------------------
 * The Bootstrap folder, for our custom initialization.
 *---------------------------------------------------------------
 */
define('BOOTSTRAPPATH', rtrim(str_replace('\\', '/', realpath(dirname(__FILE__))), '/').'/');

if (BOOTSTRAPPATH == '' || BOOTSTRAPPATH == '/' || !is_dir(BOOTSTRAPPATH)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your bootstrap folder path (BOOTSTRAPPATH) does not appear to be set correctly. Please, make corrections within the following file: '.__FILE__;
    exit(3); // EXIT_* constants not yet defined; 3 is EXIT_CONFIG.
}

/*
 *---------------------------------------------------------------
 * Do our custom initialization first.
 *---------------------------------------------------------------
 */
require_once BOOTSTRAPPATH.'bootstrap.php';

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

$app = require BOOTSTRAPPATH.'bootstrap_ci.php';

if (defined('SPARKED') && SPARKED) {

    /*
     *---------------------------------------------------------------
     * SPARK CLI
     *---------------------------------------------------------------
     * Now that everything is setup, it's time to actually fire
     * up the engines and make this app do its thang.
     */

    // Grab our Console
    $console = new \CodeIgniter\CLI\Console($app);

    // We want errors to be shown when using it from the CLI.
    error_reporting(-1);
    ini_set('display_errors', 1);

    // Show basic information before we do anything else.
    $console->showHeader();

    // Fire off the command in the main framework.
    $response = $console->run();

    if ($response->getStatusCode() >= 300)
    {
        exit($response->getStatusCode());
    }

}
else
{

    /*
     *---------------------------------------------------------------
     * LAUNCH THE APPLICATION
     *---------------------------------------------------------------
     * Now that everything is setup, it's time to actually fire
     * up the engines and make this app do its thang.
     */

    $app->run();

}

<?php defined('BOOTSTRAPPATH') OR exit('No direct script access allowed');

/**
 * A Custom Bootstrap File
 * @author Ivan Tcholakov <ivantcholakov@gmail.com>, 2020
 * @license The MIT License, http://opensource.org/licenses/MIT
 */


/*
 * --------------------------------------------------------------------
 * Environment and request type detection
 * --------------------------------------------------------------------
 */

define('IS_WINDOWS_OS', strtolower(substr(php_uname('s'), 0, 3 )) == 'win');
define('IS_CLI', (PHP_SAPI == 'cli') or defined('STDIN'));
define('IS_AJAX_REQUEST', isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

require BOOTSTRAPPATH.'is_php.php';

// Fix $_SERVER['REQUEST_URI'] if it is missing.
if (!isset($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] == '') {
    $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
    if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '') {
        $_SERVER['REQUEST_URI'] .= '?'.$_SERVER['QUERY_STRING'];
    }
}


/*
 * --------------------------------------------------------------------
 * Debugging
 * --------------------------------------------------------------------
 */

require BOOTSTRAPPATH.'preg_error_message.php';
require BOOTSTRAPPATH.'print_d.php';


/*
 * --------------------------------------------------------------------
 * Essential functions to serve bootstrap process further
 * --------------------------------------------------------------------
 */

require BOOTSTRAPPATH.'str_to_bool.php';
require BOOTSTRAPPATH.'resolve_path.php';
require BOOTSTRAPPATH.'merge_paths.php';
require BOOTSTRAPPATH.'detect_https.php';
require BOOTSTRAPPATH.'detect_host.php';
require BOOTSTRAPPATH.'detect_url.php';


/*
 * --------------------------------------------------------------------
 * Other possibly missing functions (PHP, PECL)
 * --------------------------------------------------------------------
 */

if (!function_exists('http_build_str') || !function_exists('http_build_url')) {
    require BOOTSTRAPPATH.'http_build_url.php';
}


/*
 * --------------------------------------------------------------------
 * Fundamental functions.
 * --------------------------------------------------------------------
 */
require BOOTSTRAPPATH.'arrays.php';
require BOOTSTRAPPATH.'is_serialized.php';
require BOOTSTRAPPATH.'str_replace_limit.php';


/*
 *---------------------------------------------------------------
 * URL-based detection, stored within a global variable.
 *---------------------------------------------------------------
 */
define('DETECTED_URL', detect_url()['current_url']);

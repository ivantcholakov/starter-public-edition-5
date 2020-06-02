<?php defined('BOOTSTRAPPATH') OR exit('No direct script access allowed');

/**
 * A Custom Bootstrap File
 * @author Ivan Tcholakov <ivantcholakov@gmail.com>, 2020
 * @license The MIT License, http://opensource.org/licenses/MIT
 */

/*
 *---------------------------------------------------------------
 * Get and check version data
 *---------------------------------------------------------------
 */
require BOOTSTRAPPATH.'versions.php';


/*
 * --------------------------------------------------------------------
 * Environment and request type detection
 * --------------------------------------------------------------------
 */

require BOOTSTRAPPATH.'is_php.php';

define('IS_WINDOWS_OS', strtolower(substr(php_uname('s'), 0, 3 )) == 'win');
define('IS_CLI', (PHP_SAPI == 'cli') or defined('STDIN'));
define('IS_AJAX_REQUEST', isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

// Fix $_SERVER['REQUEST_URI'] if it is missing.
if (!isset($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] == '') {
    $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
    if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '') {
        $_SERVER['REQUEST_URI'] .= '?'.$_SERVER['QUERY_STRING'];
    }
}


/*
 * --------------------------------------------------------------------
 * Setting and validation of platform paths.
 * --------------------------------------------------------------------
 */

if (isset($FCPATH)) {
    define('FCPATH', rtrim(str_replace('\\', '/', realpath($FCPATH)), '/').'/');
} else {
    define('FCPATH', '');
}

// Check the path to the front controller.
if (FCPATH == '' || FCPATH == '/' || !is_dir(FCPATH)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your front controller directory path (FCPATH) does not appear to be set correctly.';
    exit(3);
}

if (isset($DEFAULTFCPATH)) {
    define('DEFAULTFCPATH', rtrim(str_replace('\\', '/', realpath($DEFAULTFCPATH)), '/').'/');
} else {
    define('DEFAULTFCPATH', '');
}

// Check the path to the front controller of the default site.
if (DEFAULTFCPATH == '' || DEFAULTFCPATH == '/' || !is_dir(DEFAULTFCPATH)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your front controller directory path of the default site (DEFAULTFCPATH) does not appear to be set correctly.';
    exit(3);
}

// Ensure the current directory is pointing to the default front controller's directory
chdir(DEFAULTFCPATH);

if (isset($PLATFORMPATH)) {
    define('PLATFORMPATH', rtrim(str_replace('\\', '/', realpath($PLATFORMPATH)), '/').'/');
} else {
    define('PLATFORMPATH', '');
}

// Check the path to the "platform" directory.
if (PLATFORMPATH == '' || PLATFORMPATH == '/' || !is_dir(PLATFORMPATH)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your platform directory ($PLATFORMPATH) does not appear to be set correctly.';
    exit(3);
}

if (isset($PLATFORMRUN)) {
    define('PLATFORMRUN', str_replace('\\', '/', realpath($PLATFORMRUN)));
} else {
    define('PLATFORMRUN', '');
}

// Check the path to the platform "run" file.
if (PLATFORMRUN == '' || !is_file(PLATFORMRUN)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your platform starter file ($PLATFORMRUN) does not appear to be set correctly.';
    exit(3);
}

define('APPSPATH', PLATFORMPATH.'applications/');

// Check the path to the "applications" directory.
if (!is_dir(APPSPATH)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your application root directory path (APPSPATH) does not appear to be set correctly. Please, make corrections within the following file: '.__FILE__;
    exit(3);
}

if (isset($APPNAME)) {
    define('APPNAME', trim(str_replace(array('\\', '-'), array('/', '_'), $APPNAME), ' /'));
} else {
    define('APPNAME', '');
}

// Check validance of the application name.
if (APPNAME == '') {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your application name ($APPNAME) does not appear to be set correctly.';
    exit(3);
}

if (isset($DEFAULTAPPNAME)) {
    define('DEFAULTAPPNAME', trim(str_replace(array('\\', '-'), array('/', '_'), $DEFAULTAPPNAME), ' /'));
} else {
    define('DEFAULTAPPNAME', '');
}

// Check validance of the default application name.
if (DEFAULTAPPNAME == '') {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your default application name ($DEFAULTAPPNAME) does not appear to be set correctly.';
    exit(3);
}

// The url segment of the application, counted from the root public directory of the site.
define('APPSEGMENT', rtrim(str_replace(DEFAULTFCPATH, '', FCPATH), '/'));

// Is this application default (i.e. at the root public directory of the site)?
define('ISDEFAULTAPP', APPSEGMENT == '');

// The path to the application.
define('APPPATH', APPSPATH.APPNAME.'/');

// Check the path to the application directory.
if (!is_dir(APPPATH)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your application name ($APPNAME) does not appear to be set correctly.';
    exit(3);
}

// Path to the system directory
define('BASEPATH', rtrim(str_replace('\\', '/', realpath(dirname(__FILE__).'/../vendor/codeigniter4/framework/system')), '/').'/');

// Is the system path correct?
if (BASEPATH == '' || BASEPATH == '/' || !is_dir(BASEPATH)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your system directory path (BASEPATH) does not appear to be set correctly. Please, make corrections within the following file: '.__FILE__;
    exit(3);
}

// The path to the "Views" directory
define('VIEWPATH', APPPATH.'Views/');

// The path to the "common" directory
define('COMMONPATH', rtrim(str_replace('\\', '/', realpath(dirname(__FILE__).'/../common')), '/').'/');

if (COMMONPATH == '' || COMMONPATH == '/' || !is_dir(COMMONPATH)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your common directory path (COMMONPATH) does not appear to be set correctly. Please, make corrections within the following file: '.__FILE__;
    exit(3);
}

// This is the common writable directory to be used by this platform.
define('WRITABLEPATH', rtrim(str_replace('\\', '/', realpath(dirname(__FILE__).'/../writable')), '/').'/');

if (WRITABLEPATH == '' || WRITABLEPATH == '/' || !is_dir(WRITABLEPATH)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your writable directory path (WRITABLEPATH) does not appear to be set correctly. Please, make corrections within the following file: '.__FILE__;
    exit(3);
}

// This is the common writable directory to be used by this platform.
define('TESTSPATH', rtrim(str_replace('\\', '/', realpath(dirname(__FILE__).'/../tests')), '/').'/');


/*
 * --------------------------------------------------------------------
 * Config\Paths seems to needs directories without trailing slash
 * --------------------------------------------------------------------
 */

define('PATHS_SYSTEM_DIRECTORY', realpath(BASEPATH));
define('PATHS_COMMON_DIRECTORY', realpath(COMMONPATH));
define('PATHS_APP_DIRECTORY', realpath(APPPATH));
define('PATHS_WRITABLE_DIRECTORY', realpath(WRITABLEPATH));
define('PATHS_TESTS_DIRECTORY', realpath(TESTSPATH));
define('PATHS_VIEW_DIRECTORY', realpath(VIEWPATH));


/*
 * --------------------------------------------------------------------
 * Making sure PEAR packages are to be searched in this site first
 * --------------------------------------------------------------------
 */

set_include_path(COMMONPATH.'ThirdParty/Pear'.PATH_SEPARATOR.get_include_path());


/*
 * --------------------------------------------------------------------
 * Debugging
 * --------------------------------------------------------------------
 */

require BOOTSTRAPPATH.'print_d.php';


/*
 * --------------------------------------------------------------------
 * Essential functions to serve bootstrap process further
 * --------------------------------------------------------------------
 */

require BOOTSTRAPPATH.'resolve_path.php';
require BOOTSTRAPPATH.'merge_paths.php';
require BOOTSTRAPPATH.'detect_https.php';
require BOOTSTRAPPATH.'detect_host.php';
require BOOTSTRAPPATH.'detect_url.php';


/*
 *---------------------------------------------------------------
 * Base URL detection
 *---------------------------------------------------------------
 */
define('DETECTED_URL', detect_url()['base_url']);


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
 * Common purpose functions
 * --------------------------------------------------------------------
 */

require BOOTSTRAPPATH.'str_to_bool.php';
require BOOTSTRAPPATH.'arrays.php';
require BOOTSTRAPPATH.'is_serialized.php';
require BOOTSTRAPPATH.'str_replace_limit.php';


/*
 * --------------------------------------------------------------------
 * A custom PHP5-style autoloader
 * --------------------------------------------------------------------
 */
require BOOTSTRAPPATH.'autoload.php';

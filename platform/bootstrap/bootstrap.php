<?php defined('BOOTSTRAPPATH') OR exit('No direct script access allowed');

/**
 * A Custom Bootstrap File
 * @author Ivan Tcholakov <ivantcholakov@gmail.com>, 2013 - 2020
 * @license The MIT License, http://opensource.org/licenses/MIT
 */

if ( ! function_exists('is_php'))
{
    /**
     * Determines if the current version of PHP is equal to or greater than the supplied value
     *
     * @param       string
     * @return      bool        TRUE if the current version is $version or higher
     */
    function is_php($version)
    {
        static $_is_php;
        $version = (string) $version;

        if ( ! isset($_is_php[$version]))
        {
            $_is_php[$version] = version_compare(PHP_VERSION, $version, '>=');
        }

        return $_is_php[$version];
    }
}

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

define('IS_WINDOWS_OS', stripos(PHP_OS, 'WIN') === 0);
define('IS_CLI', (PHP_SAPI == 'cli') || defined('STDIN'));
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
    unset($FCPATH);
} else {
    define('FCPATH', '');
}

// Check the path to the front controller.
if (FCPATH == '' || FCPATH == '/' || !is_dir(FCPATH)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your front controller directory path (FCPATH) does not appear to be set correctly.';
    exit(3); // EXIT_CONFIG
}

if (isset($DEFAULTFCPATH)) {
    define('DEFAULTFCPATH', rtrim(str_replace('\\', '/', realpath($DEFAULTFCPATH)), '/').'/');
    unset($DEFAULTFCPATH);
} else {
    define('DEFAULTFCPATH', '');
}

// Check the path to the front controller of the default site.
if (DEFAULTFCPATH == '' || DEFAULTFCPATH == '/' || !is_dir(DEFAULTFCPATH)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your front controller directory path of the default site (DEFAULTFCPATH) does not appear to be set correctly.';
    exit(3); // EXIT_CONFIG
}

if (isset($PLATFORMPATH)) {
    define('PLATFORMPATH', rtrim(str_replace('\\', '/', realpath($PLATFORMPATH)), '/').'/');
    unset($PLATFORMPATH);
} else {
    define('PLATFORMPATH', '');
}

// Check the path to the "platform" directory.
if (PLATFORMPATH == '' || PLATFORMPATH == '/' || !is_dir(PLATFORMPATH)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your platform directory ($PLATFORMPATH) does not appear to be set correctly.';
    exit(3); // EXIT_CONFIG
}

if (isset($PLATFORMRUN)) {
    define('PLATFORMRUN', str_replace('\\', '/', realpath($PLATFORMRUN)));
    unset($PLATFORMRUN);
} else {
    define('PLATFORMRUN', '');
}

// Check the path to the platform "run" file.
if (PLATFORMRUN == '' || !is_file(PLATFORMRUN)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your platform starter file ($PLATFORMRUN) does not appear to be set correctly.';
    exit(3); // EXIT_CONFIG
}

define('APPSPATH', PLATFORMPATH.'applications/');

// Check the path to the "applications" directory.
if (!is_dir(APPSPATH)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your application root directory path (APPSPATH) does not appear to be set correctly. Please, make corrections within the following file: '.__FILE__;
    exit(3); // EXIT_CONFIG
}

if (isset($APPNAME)) {
    define('APPNAME', trim(str_replace(array('\\', '-'), array('/', '_'), $APPNAME), ' /'));
    unset($APPNAME);
} else {
    define('APPNAME', '');
}

// Check validance of the application name.
if (APPNAME == '') {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your application name ($APPNAME) does not appear to be set correctly.';
    exit(3); // EXIT_CONFIG
}

if (isset($DEFAULTAPPNAME)) {
    define('DEFAULTAPPNAME', trim(str_replace(array('\\', '-'), array('/', '_'), $DEFAULTAPPNAME), ' /'));
    unset($DEFAULTAPPNAME);
} else {
    define('DEFAULTAPPNAME', '');
}

// Check validance of the default application name.
if (DEFAULTAPPNAME == '') {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your default application name ($DEFAULTAPPNAME) does not appear to be set correctly.';
    exit(3); // EXIT_CONFIG
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
    exit(3); // EXIT_CONFIG
}

// The path to the Composer loader file.
define('COMPOSER_PATH', PLATFORMPATH.'vendor/autoload.php');

if (!is_file(COMPOSER_PATH)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your path to the Composer loader file (COMPOSER_PATH) does not appear to be set correctly. Please, make corrections within the following file: '.__FILE__;
    exit(3); // EXIT_CONFIG
}

define('VENDORPATH', rtrim(str_replace('\\', '/', realpath(dirname(COMPOSER_PATH))), '/').'/');

// Path to the system directory
define('BASEPATH', VENDORPATH.'codeigniter4/framework/system/');

// Is the system path correct?
if (BASEPATH == '' || BASEPATH == '/' || !is_dir(BASEPATH)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your system directory path (BASEPATH) does not appear to be set correctly. Please, make corrections within the following file: '.__FILE__;
    exit(3); // EXIT_CONFIG
}

// The path to the "Views" directory
define('VIEWPATH', APPPATH.'Views/');

// The path to the "common" directory
define('COMMONPATH', rtrim(str_replace('\\', '/', realpath(dirname(__FILE__).'/../common')), '/').'/');

if (COMMONPATH == '' || COMMONPATH == '/' || !is_dir(COMMONPATH)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your common directory path (COMMONPATH) does not appear to be set correctly. Please, make corrections within the following file: '.__FILE__;
    exit(3); // EXIT_CONFIG
}

// This is the common writable directory to be used by this platform.
define('WRITABLEPATH', rtrim(str_replace('\\', '/', realpath(dirname(__FILE__).'/../writable')), '/').'/');

if (WRITABLEPATH == '' || WRITABLEPATH == '/' || !is_dir(WRITABLEPATH)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your writable directory path (WRITABLEPATH) does not appear to be set correctly. Please, make corrections within the following file: '.__FILE__;
    exit(3); // EXIT_CONFIG
}

// This is the common writable directory to be used by this platform.
define('TESTSPATH', rtrim(str_replace('\\', '/', realpath(dirname(__FILE__).'/../tests')), '/').'/');

// Making sure PEAR packages are to be searched in this site first
set_include_path(COMMONPATH.'ThirdParty/Pear'.PATH_SEPARATOR.get_include_path());

// Ensure the current directory is pointing to the front controller's directory
chdir(FCPATH);


/*
 * --------------------------------------------------------------------
 * Various helper functions
 * --------------------------------------------------------------------
 */

require BOOTSTRAPPATH.'print_d.php';
require BOOTSTRAPPATH.'helpers.php';

if (!function_exists('http_build_str') || !function_exists('http_build_url')) {
    require BOOTSTRAPPATH.'http_build_url.php';
}


/*
 *---------------------------------------------------------------------
 * Base URL detection
 *---------------------------------------------------------------------
 */
define('DETECTED_BASE_URL', detect_url('base_url'));


/*
 * --------------------------------------------------------------------
 * A custom PHP5-style autoloader
 * --------------------------------------------------------------------
 */
require BOOTSTRAPPATH.'autoload.php';


/*
 * --------------------------------------------------------------------
 * Load Customized source of CodeIgniter if exists
 * --------------------------------------------------------------------
 */

if (is_file(COMMONPATH.'System/CodeIgniter.php'))
{
    require_once COMMONPATH.'System/CodeIgniter.php';
}


/*
 * --------------------------------------------------------------------
 * Initialize Config\Paths
 * Config\Paths seems to need directories without trailing slash
 * --------------------------------------------------------------------
 */

define('PATHS_SYSTEM_DIRECTORY', realpath(BASEPATH));
define('PATHS_COMMON_DIRECTORY', realpath(COMMONPATH));
define('PATHS_APP_DIRECTORY', realpath(APPPATH));
define('PATHS_WRITABLE_DIRECTORY', realpath(WRITABLEPATH));
define('PATHS_TESTS_DIRECTORY', realpath(TESTSPATH));
define('PATHS_VIEW_DIRECTORY', realpath(VIEWPATH));

// Load our paths config file

require_once COMMONPATH.'Config/Paths.php';

if (file_exists(APPPATH . 'Config/Paths.php'))
{
    // In this case Config\Paths should extend Common\Config\Paths
    require_once APPPATH . 'Config/Paths.php';
}

if (! class_exists('Config\Paths', false))
{
    class_alias('Common\Config\Paths', 'Config\Paths');
}

// Don't delete or rename the variable $paths.
$paths = new Config\Paths();

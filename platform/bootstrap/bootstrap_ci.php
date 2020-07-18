<?php

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014-2019 British Columbia Institute of Technology
 * Copyright (c) 2019-2020 CodeIgniter Foundation
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package    CodeIgniter
 * @author     CodeIgniter Dev Team
 * @copyright  2019-2020 CodeIgniter Foundation
 * @license    https://opensource.org/licenses/MIT    MIT License
 * @link       https://codeigniter.com
 * @since      Version 4.0.0
 * @filesource
 */

/*
 * ---------------------------------------------------------------
 * SETUP OUR PATH CONSTANTS
 * ---------------------------------------------------------------
 *
 * The path constants provide convenient access to the folders
 * throughout the application. We have to setup them up here
 * so they are available in the config files that are loaded.
 */

/**
 * The path to the application directory.
 */
if (! defined('APPPATH'))
{
    define('APPPATH', realpath($paths->appDirectory) . DIRECTORY_SEPARATOR);
}

/**
 * The path to the project root directory.
 */
if (! defined('ROOTPATH'))
{
    define('ROOTPATH', realpath(APPPATH . '../../') . DIRECTORY_SEPARATOR);
}

/**
 * The path to the system directory.
 */
if (! defined('SYSTEMPATH'))
{
    define('SYSTEMPATH', realpath($paths->systemDirectory) . DIRECTORY_SEPARATOR);
}

/**
 * The path to the writable directory.
 */
if (! defined('WRITEPATH'))
{
    define('WRITEPATH', realpath($paths->writableDirectory) . DIRECTORY_SEPARATOR);
}

/**
 * The path to the tests directory
 */
if (! defined('TESTPATH'))
{
    define('TESTPATH', realpath($paths->testsDirectory) . DIRECTORY_SEPARATOR);
}

/*
 * ---------------------------------------------------------------
 * GRAB OUR CONSTANTS & COMMON
 * ---------------------------------------------------------------
 */
if (file_exists(APPPATH . 'Config/Constants.php'))
{
    require_once APPPATH . 'Config/Constants.php';
}

if (file_exists(COMMONPATH . 'Config/Constants.php'))
{
    require_once COMMONPATH . 'Config/Constants.php';
}

// Let's see if an app/Common.php file exists
if (file_exists(APPPATH . 'Common.php'))
{
    require_once APPPATH . 'Common.php';
}

if (file_exists(COMMONPATH . 'Common.php'))
{
    require_once COMMONPATH . 'Common.php';
}

// Require system/Common.php
require_once SYSTEMPATH . 'Common.php';

/*
 * ---------------------------------------------------------------
 * LOAD OUR AUTOLOADER
 * ---------------------------------------------------------------
 *
 * The autoloader allows all of the pieces to work together
 * in the framework. We have to load it here, though, so
 * that the config files can use the path constants.
 */

if (! class_exists(Config\Autoload::class, false))
{
    require_once SYSTEMPATH . 'Config/AutoloadConfig.php';
    require_once COMMONPATH . 'Config/Autoload.php';

    if (file_exists(APPPATH . 'Config/Autoload.php'))
    {
        // In this case Config\Autoload should extend Common\Config\Autoload
        require_once APPPATH . 'Config/Autoload.php';
    }

    if (! class_exists(Config\Autoload::class, false))
    {
        class_alias('Common\Config\Autoload', 'Config\Autoload');
    }

    require_once SYSTEMPATH . 'Modules/Modules.php';
    require_once COMMONPATH . 'Config/Modules.php';

    if (file_exists(APPPATH . 'Config/Modules.php'))
    {
        // In this case Config\Modules should extend Common\Config\Modules
        require_once APPPATH . 'Config/Modules.php';
    }

    if (! class_exists(Config\Modules::class, false))
    {
        class_alias('Common\Config\Modules', 'Config\Modules');
    }
}

require_once COMMONPATH . 'System/Autoloader/Autoloader.php';
require_once COMMONPATH . 'System/Autoloader/FileLocator.php';

require_once SYSTEMPATH . 'Config/BaseService.php';
require_once COMMONPATH . 'System/Config/Services.php';
require_once COMMONPATH . 'Config/Services.php';

if (file_exists(APPPATH . 'Config/Services.php'))
{
    // In this case Config\Modules should extend Common\Config\Services
    require_once APPPATH . 'Config/Services.php';
}

// Use Config\Services as CodeIgniter\Services
if (! class_exists('CodeIgniter\Services', false))
{
    if (! class_exists('Config\Services', false))
    {
        class_alias('Common\Config\Services', 'CodeIgniter\Services');
        class_alias('Common\Config\Services', 'Config\Services');
    }
    else
    {
        class_alias('Config\Services', 'CodeIgniter\Services');
    }
}

$loader = CodeIgniter\Services::autoloader();
$loader->initialize(new Config\Autoload(), new Config\Modules());
$loader->register();    // Register the loader with the SPL autoloader stack.

// Now load Composer
require_once COMPOSER_PATH;

// Load environment settings from .env files
// into $_SERVER and $_ENV
require_once SYSTEMPATH . 'Config/DotEnv.php';

$env = new \CodeIgniter\Config\DotEnv(APPPATH);
$env->load();

// Always load the URL helper -
// it should be used in 90% of apps.
helper('url');

/*
 * ---------------------------------------------------------------
 * GRAB OUR CODEIGNITER INSTANCE
 * ---------------------------------------------------------------
 *
 * The CodeIgniter class contains the core functionality to make
 * the application run, and does all of the dirty work to get
 * the pieces all working together.
 */

require_once COMMONPATH.'Config/App.php';

if (file_exists(APPPATH . 'Config/App.php'))
{
    // In this case Config\App should extend Common\Config\App
    require_once APPPATH . 'Config/App.php';
}

if (! class_exists('Config\App', false))
{
    class_alias('Common\Config\App', 'Config\App');
}

$appConfig = config(\Config\App::class);

// For supporting legacy code.
if (!defined('IS_UTF8_CHARSET')) {
    define('IS_UTF8_CHARSET', strtolower($appConfig->charset) === 'utf-8');
}

if (!empty($appConfig->restrictAccessToTrustedHostsOnly) && !is_cli())
{
    $detectedHost = detect_url('server_name');
    $trustedHosts = $appConfig->trustedHosts ?? null;

    if (empty($trustedHosts) || !is_array($trustedHosts))
    {
        $trustedHosts = ['localhost'];
    }

    $trustedHostFound = false;

    foreach ($trustedHosts as $trustedHost)
    {
        if (!is_string($trustedHost))
        {
            continue;
        }

        if (strpos($trustedHost, '/') === 0)
        {
            // The setting is a pattern.
            if (preg_match($trustedHost, $detectedHost))
            {
                $trustedHostFound = true;
                break;
            }
        }
        else
        {
            // The setting is a string to be matched exactly.
            if ($trustedHost === $detectedHost)
            {
                $trustedHostFound = true;
                break;
            }
        }
    }

    if (!$trustedHostFound)
    {
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'Not trusted host/server/domain name.';
        exit;
    }

    unset($detectedHost);
    unset($trustedHosts);
    unset($trustedHostFound);
    unset($trustedHost);
}

file_exists(TMP_PATH) OR @mkdir(TMP_PATH, DIR_WRITE_MODE, TRUE);

$app = new \CodeIgniter\CodeIgniter($appConfig);
$app->initialize();

return $app;

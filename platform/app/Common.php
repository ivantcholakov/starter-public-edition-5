<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @link: https://codeigniter4.github.io/CodeIgniter4/
 */

define('BOOTSTRAPPATH', rtrim(str_replace('\\', '/', realpath(__DIR__.'/../bootstrap')), '/').'/');

if (BOOTSTRAPPATH == '' || BOOTSTRAPPATH == '/' || !is_dir(BOOTSTRAPPATH)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your bootstrap folder path (BOOTSTRAPPATH) does not appear to be set correctly. Please, make corrections within the following file: '.__FILE__;
    exit(3);
}

require BOOTSTRAPPATH.'bootstrap.php';

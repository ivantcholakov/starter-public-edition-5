<?php

spl_autoload_register('_common_autoloader');

/**
 * Automatically loads classes in PHP5 way, using SPL.
 * @param   string      $class              The class name, no namespaces are supported.
 * @return  bool                            TRUE if a class have been found and loaded, FALSE otherwise.
 * @author  Ivan Tcholakov, 2013-2020
 * @license The MIT License
 */
function _common_autoloader($class) {

    $class = (string) $class;

    // No class name? Abort.
    if ($class == '') {
        return false;
    }

    // Autoload custom classes, non-standard way.

    if (is_file($location = APPPATH."Classes/$class.php")) {
        require $location;
        return true;
    }

    if (is_file($location = COMMONPATH."Classes/$class.php")) {
        require $location;
        return true;
    }

    // PSR-0 autoloading.

    if (is_file($location = APPPATH.'Classes/'.str_replace(array('_', '\\'), DIRECTORY_SEPARATOR, $class).'.php')) {
        require $location;
        return true;
    }

    if (is_file($location = COMMONPATH.'Classes/'.str_replace(array('_', '\\'), DIRECTORY_SEPARATOR, $class).'.php')) {
        require $location;
        return true;
    }

    // Autoload PEAR packages that are integrated in this platform.
    if (is_file($location = COMMONPATH.'ThirdParty/Pear/'.str_replace('_', DIRECTORY_SEPARATOR, $class).'.php')) {
        require $location;
        return true;
    }

    return false;
}

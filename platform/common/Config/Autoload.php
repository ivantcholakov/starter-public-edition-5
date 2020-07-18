<?php

namespace Common\Config;

use CodeIgniter\Config\AutoloadConfig;

/**
 * -------------------------------------------------------------------
 * AUTO-LOADER
 * -------------------------------------------------------------------
 * This file defines the namespaces and class maps so the Autoloader
 * can find the files as needed.
 */
class Autoload extends AutoloadConfig
{
    public $psr4 = [];

    public $classmap = [];

    //--------------------------------------------------------------------

    /**
     * Collects the application-specific autoload settings and merges
     * them with the framework's required settings.
     *
     * NOTE: If you use an identical key in $psr4 or $classmap, then
     * the values in this file will overwrite the framework's values.
     */
    public function __construct()
    {
        parent::__construct();

        /**
         * -------------------------------------------------------------------
         * Namespaces
         * -------------------------------------------------------------------
         * This maps the locations of any namespaces in your application to
         * their location on the file system. These are used by the autoloader
         * to locate files the first time they have been instantiated.
         *
         * The '/app' and '/system' directories are already mapped for you.
         * You may change the name of the 'App' namespace if you wish,
         * but this should be done prior to creating any namespaced classes,
         * else you will need to modify all of those classes for this to work.
         *
         * Prototype:
         *
         *   $psr4 = [
         *       'CodeIgniter' => SYSTEMPATH,
         *       'App'         => APPPATH
         *   ];
         *
         * @var array
         */
        $psr4 = [
            'Common'        => COMMONPATH,
            'Common\Config' => COMMONPATH . 'Config',

            APP_NAMESPACE   => APPPATH,                // For custom app namespace
            'Config'        => APPPATH . 'Config',

            'Common\Modules\System' => COMMONPATH . 'Modules/System',
        ];

        /**
         * -------------------------------------------------------------------
         * Class Map
         * -------------------------------------------------------------------
         * The class map provides a map of class names and their exact
         * location on the drive. Classes loaded in this manner will have
         * slightly faster performance because they will not have to be
         * searched for within one or more directories as they would if they
         * were being autoloaded through a namespace.
         *
         * Prototype:
         *
         *   $classmap = [
         *       'MyClass'   => '/path/to/class/file.php'
         *   ];
         *
         * @var array
         */
        $classmap = [
            'CodeIgniter\View\View' => COMMONPATH.'System/View/View.php',
            'CodeIgniter\Debug\Toolbar\Collectors\BaseCollector' => COMMONPATH.'System/Debug/Toolbar/Collectors/BaseCollector.php',
        ];

        //--------------------------------------------------------------------
        // Do Not Edit Below This Line
        //--------------------------------------------------------------------

        $this->psr4     = array_merge($this->psr4, $psr4);
        $this->classmap = array_merge($this->classmap, $classmap);

        unset($psr4, $classmap);
    }

    //--------------------------------------------------------------------

}

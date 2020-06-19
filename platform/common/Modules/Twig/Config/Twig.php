<?php namespace Common\Modules\Twig\Config;

use CodeIgniter\Config\BaseConfig;

class Twig extends BaseConfig
{
    public $config = [];

    public function __construct()
    {
        parent::__construct();

        // Twig Environment --------------------------------------------------

        $this->config['debug'] = ENVIRONMENT !== 'production';
        $this->config['charset'] = 'UTF-8';
        $this->config['strict_variables'] = false;
        $this->config['autoescape'] = 'html';
        $this->config['cache'] = false;
        $this->config['auto_reload'] = null;
        $this->config['optimizations'] = -1;

        // Filesystem Loader -------------------------------------------------

        $this->config['paths'] = [
            APPPATH . 'Views',
            COMMONPATH . 'Views',
            // [MYPATH, 'add'],      // An alternative way, 'add' is by default;
            // [MYPATH, 'prepend'],  // Or this way.
        ];

        // Twig Extensions ---------------------------------------------------

        $this->config['extensions'] = [
            ['\Twig\Extension\StringLoaderExtension' => true],
            ['\Twig\Extra\String\StringExtension' => true],
        ];

        // Load Helpers ------------------------------------------------------

        $this->config['helpers'] = [
            'text',
        ];

        // Functions ---------------------------------------------------------

        $this->config['functions'] = [
            'base_url',
            'site_url',
        ];

        // Filters -----------------------------------------------------------

        $this->config['filters'] = [
            // PHP
            'base64_decode',
            ['base64_encode', 'base64_encode', ['is_safe' => ['html', 'html_attr', 'js']]],
            'ellipsize',
        ];

        // Tests (is * operators) --------------------------------------------

        $this->config['tests'] = [
            ['array', 'is_array'],
            ['bool', 'is_bool'],
            ['boolean', 'is_bool'],
            ['float', 'is_float'],
            ['int', 'is_int'],
            ['integer', 'is_integer'],
            ['numeric', 'is_numeric'],
            ['object', 'is_object'],
            ['scalar', 'is_scalar'],
            ['string', 'is_string'],
            //['zero', ['Parser_Twig_Extension_Php', 'php_empty']],
        ];

        // Global Variables --------------------------------------------------

        // [ ['_debug', false], ... ]  // An enxample.

        $this->config['globals'] = [];

        // Sandbox policy ----------------------------------------------------

        $this->config['sandbox_tags'] = [];

        $this->config['sandbox_filters'] = [];

        $this->config['sandbox_methods'] = [];

        $this->config['sandbox_properties'] = [];

        $this->config['sandbox_functions'] = [];
    }
}

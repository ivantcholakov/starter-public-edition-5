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
        ];

        // Load Helpers ------------------------------------------------------

        $this->config['helpers'] = [

        ];

        // Extra-Functions ---------------------------------------------------

        $this->config['functions'] = [
            'base_url',
            'site_url',
        ];

        // Filters -----------------------------------------------------------

        $this->config['filters'] = [
            // PHP
            'base64_decode',
            ['base64_encode', 'base64_encode', ['is_safe' => ['html', 'html_attr', 'js']]],
        ];

        // Sandbox policy ----------------------------------------------------

        $this->config['sandbox_tags'] = [];

        $this->config['sandbox_filters'] = [];

        $this->config['sandbox_methods'] = [];

        $this->config['sandbox_properties'] = [];

        $this->config['sandbox_functions'] = [];
    }
}

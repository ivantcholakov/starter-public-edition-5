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

        // Twig Extensions ---------------------------------------------------

        $this->config['extensions'] = [
            ['\Twig\Extension\StringLoaderExtension' => true],
        ];

        // Sandbox policy ----------------------------------------------------

        $this->config['sandbox_tags'] = [];

        $this->config['sandbox_filters'] = [];

        $this->config['sandbox_methods'] = [];

        $this->config['sandbox_properties'] = [];

        $this->config['sandbox_functions'] = [];
    }
}

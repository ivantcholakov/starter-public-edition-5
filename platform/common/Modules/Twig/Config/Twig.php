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
            // Static Class Methods and Properties
            ['call_static', ['\Common\Modules\Twig\Extension\StaticExtension', 'call_static']],
            ['get_static', ['\Common\Modules\Twig\Extension\StaticExtension', 'get_static']],

            'base_url',
            'site_url',
        ];

        // Filters -----------------------------------------------------------

        $this->config['filters'] = [
            // Type Casting
            ['boolean', ['\Common\Modules\Twig\Extension\TypeCastingExtension', 'boolean'], ['is_safe' => ['html']]],
            ['bool', ['\Common\Modules\Twig\Extension\TypeCastingExtension', 'boolean'], ['is_safe' => ['html']]],
            ['integer', ['\Common\Modules\Twig\Extension\TypeCastingExtension', 'integer'], ['is_safe' => ['html']]],
            ['int', ['\Common\Modules\Twig\Extension\TypeCastingExtension', 'integer'], ['is_safe' => ['html']]],
            ['float', ['\Common\Modules\Twig\Extension\TypeCastingExtension', 'float'], ['is_safe' => ['html']]],
            ['double', ['\Common\Modules\Twig\Extension\TypeCastingExtension', 'float'], ['is_safe' => ['html']]],
            ['real', ['\Common\Modules\Twig\Extension\TypeCastingExtension', 'float'], ['is_safe' => ['html']]],
            ['string', ['\Common\Modules\Twig\Extension\TypeCastingExtension', 'string']],
            ['array', ['\Common\Modules\Twig\Extension\TypeCastingExtension', 'twig_array']],
            ['object', ['\Common\Modules\Twig\Extension\TypeCastingExtension', 'object']],
            ['null', ['\Common\Modules\Twig\Extension\TypeCastingExtension', 'null'], ['is_safe' => ['html']]],
            // PHP
            'base64_decode',
            ['base64_encode', 'base64_encode', ['is_safe' => ['html', 'html_attr', 'js']]],
            ['count', 'count', ['is_safe' => ['html']]],
            ['gettype', 'gettype', ['is_safe' => ['html']]],
            ['ltrim', ['\Common\Modules\Twig\Extension\PHPExtension', 'ltrim']],
            ['rtrim', ['\Common\Modules\Twig\Extension\PHPExtension', 'rtrim']],
            'sprintf',
            'str_repeat',
            ['stripos', 'stripos', ['is_safe' => ['html']]],
            ['strpos', 'strpos', ['is_safe' => ['html']]],
            ['wordwrap', ['\Common\Modules\Twig\Extension\PHPExtension', 'wordwrap']],
            ['array_plus', ['\Common\Modules\Twig\Extension\PHPExtension', 'array_plus']],
            ['array_replace', ['\Common\Modules\Twig\Extension\PHPExtension', 'array_replace']],
            ['ord', 'ord', ['is_safe' => ['html', 'html_attr', 'js', 'css']]],
            'chr',
            // CodeIgniter's Helpers
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
            ['zero', ['\Common\Modules\Twig\Extension\PHPExtension', 'php_empty']],
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

    //------------------------------------------------------------------------

}

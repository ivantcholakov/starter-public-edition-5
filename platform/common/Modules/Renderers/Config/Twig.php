<?php namespace Common\Modules\Renderers\Config;

use CodeIgniter\Config\BaseConfig;

class Twig extends BaseConfig
{
    public $config = [];

    public function __construct()
    {
        parent::__construct();

        // Twig Environment --------------------------------------------------

        // See https://twig.symfony.com/doc/3.x/api.html

        // "When set to true, the generated templates have a __toString() method
        // that you can use to display the generated nodes (default to false)."
        $this->config['debug'] = ENVIRONMENT !== 'production';

        // "The charset used by the templates."
        $this->config['charset'] = 'UTF-8';

        // "An absolute path where to store the compiled templates, or false
        // to disable caching (which is the default)."
        $this->config['cache'] = ENVIRONMENT === 'production' ? TWIG_CACHE : false;

        // "When developing with Twig, it’s useful to recompile the template whenever
        // the source code changes. If you don’t provide a value for the auto_reload
        // option, it will be determined automatically based on the debug value."
        $this->config['auto_reload'] = null;

        // "If set to false, Twig will silently ignore invalid variables (variables
        // and or attributes/methods that do not exist) and replace them with
        // a null value. When set to true, Twig throws an exception instead
        // (default to false)."
        $this->config['strict_variables'] = false;

        // "Sets the default auto-escaping strategy (name, html, js, css, url, html_attr,
        // or a PHP callback that takes the template “filename” and returns the escaping
        // strategy to use – the callback cannot be a function name to avoid collision
        // with built-in escaping strategies); set it to false to disable auto-escaping.
        // The name escaping strategy determines the escaping strategy to use for a template
        // based on the template filename extension (this strategy does not incur any
        // overhead at runtime as auto-escaping is done at compilation time.)"
        $this->config['autoescape'] = 'html';

        // "A flag that indicates which optimizations to apply
        // (default to -1 – all optimizations are enabled; set it to 0 to disable)."
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
            'file_type_icons',
        ];

        // Functions ---------------------------------------------------------

        $this->config['functions'] = [
            // Static Class Methods and Properties
            ['call_static', ['\Common\Modules\Renderers\TwigExtension\StaticExtension', 'call_static']],
            ['get_static', ['\Common\Modules\Renderers\TwigExtension\StaticExtension', 'get_static']],
            // URL/URI Handling
            'base_url',
            'site_url',
            'http_build_url',
            'http_build_query',
            // Platform Routines
            'registry',
            'render',
            'render_string',
            'locate',
            'source',
            ['file_type_icon', 'file_type_icon', ['is_safe' => ['html', 'html_attr', 'js']]],
            ['file_type_icon_fa', 'file_type_icon_fa', ['is_safe' => ['html', 'html_attr', 'js']]],
        ];

        // Filters -----------------------------------------------------------

        $this->config['filters'] = [
            // Type Casting
            ['boolean', ['\Common\Modules\Renderers\TwigExtension\TypeCastingExtension', 'boolean'], ['is_safe' => ['html']]],
            ['bool', ['\Common\Modules\Renderers\TwigExtension\TypeCastingExtension', 'boolean'], ['is_safe' => ['html']]],
            ['integer', ['\Common\Modules\Renderers\TwigExtension\TypeCastingExtension', 'integer'], ['is_safe' => ['html']]],
            ['int', ['\Common\Modules\Renderers\TwigExtension\TypeCastingExtension', 'integer'], ['is_safe' => ['html']]],
            ['float', ['\Common\Modules\Renderers\TwigExtension\TypeCastingExtension', 'float'], ['is_safe' => ['html']]],
            ['double', ['\Common\Modules\Renderers\TwigExtension\TypeCastingExtension', 'float'], ['is_safe' => ['html']]],
            ['real', ['\Common\Modules\Renderers\TwigExtension\TypeCastingExtension', 'float'], ['is_safe' => ['html']]],
            ['string', ['\Common\Modules\Renderers\TwigExtension\TypeCastingExtension', 'string']],
            ['array', ['\Common\Modules\Renderers\TwigExtension\TypeCastingExtension', 'twig_array']],
            ['object', ['\Common\Modules\Renderers\TwigExtension\TypeCastingExtension', 'object']],
            ['null', ['\Common\Modules\Renderers\TwigExtension\TypeCastingExtension', 'null'], ['is_safe' => ['html']]],
            // PHP
            'base64_decode',
            ['base64_encode', 'base64_encode', ['is_safe' => ['html', 'html_attr', 'js']]],
            ['count', 'count', ['is_safe' => ['html']]],
            ['gettype', 'gettype', ['is_safe' => ['html']]],
            ['ltrim', ['\Common\Modules\Renderers\TwigExtension\PHPExtension', 'ltrim']],
            ['rtrim', ['\Common\Modules\Renderers\TwigExtension\PHPExtension', 'rtrim']],
            'sprintf',
            'str_repeat',
            ['stripos', 'stripos', ['is_safe' => ['html']]],
            ['strpos', 'strpos', ['is_safe' => ['html']]],
            ['wordwrap', ['\Common\Modules\Renderers\TwigExtension\PHPExtension', 'wordwrap']],
            ['array_plus', ['\Common\Modules\Renderers\TwigExtension\PHPExtension', 'array_plus']],
            ['array_replace', ['\Common\Modules\Renderers\TwigExtension\PHPExtension', 'array_replace']],
            ['ord', 'ord', ['is_safe' => ['html', 'html_attr', 'js', 'css']]],
            'chr',
            // CodeIgniter's Helpers
            'ellipsize',
            ['stringify_attributes', 'stringify_attributes', ['is_safe' => ['html', 'html_attr', 'js']]],
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
            ['zero', ['\Common\Modules\Renderers\TwigExtension\PHPExtension', 'php_empty']],
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

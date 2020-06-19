<?php namespace Common\Config;

class Twig extends \Common\Modules\Twig\Config\Twig
{
    // Twig Environment ------------------------------------------------------

    public $charset = 'UTF-8';

    public $strict_variables = false;

    public $autoescape = 'html';

    public $cache = false;

    public $auto_reload = null;

    public $optimizations = -1;

    // Filesystem Loader -----------------------------------------------------

    public $paths = [
        APPPATH . 'Views',
        COMMONPATH . 'Views',
        // [MYPATH, 'add'],      // An alternative way, 'add' is by default;
        // [MYPATH, 'prepend'],  // Or this way.
    ];

    //------------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        $this->debug = ENVIRONMENT !== 'production';

        // Twig Extensions ---------------------------------------------------

        $this->extensions = [
            ['\Twig\Extension\DebugExtension' => $this->debug],
        ];

        //--------------------------------------------------------------------
        // Do Not Edit Below This Line
        //--------------------------------------------------------------------

        $this->config = array_merge_recursive_distinct(
            $this->config,
            array_except(get_object_vars($this), array_keys(get_class_vars(parent::class)))
        );
    }

    //--------------------------------------------------------------------

}

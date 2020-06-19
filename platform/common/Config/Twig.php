<?php namespace Common\Config;

class Twig extends \Common\Modules\Twig\Config\Twig
{
    public function __construct()
    {
        parent::__construct();

        // Twig Environment --------------------------------------------------

        $this->debug = ENVIRONMENT !== 'production';

        $this->charset = 'UTF-8';

        $this->strict_variables = false;

        $this->autoescape = 'html';

        $this->cache = false;

        $this->auto_reload = null;

        $this->optimizations = -1;

        // Filesystem Loader -------------------------------------------------

        $this->paths = [
            APPPATH . 'Views',
            COMMONPATH . 'Views',
            // [MYPATH, 'add'],      // An alternative way, 'add' is by default;
            // [MYPATH, 'prepend'],  // Or this way.
        ];

        // Twig Extensions ---------------------------------------------------

        $this->extensions = [
            ['\Twig\Extension\DebugExtension' => $this->debug], // true - enabled.
        ];

        // Sandbox policy ----------------------------------------------------

        $this->sandbox_tags = [];

        $this->sandbox_filters = [];

        $this->sandbox_methods = [];

        $this->sandbox_properties = [];

        $this->sandbox_functions = [];

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

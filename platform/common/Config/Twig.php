<?php namespace Common\Config;

class Twig extends \Common\Modules\Renderers\Config\Twig
{
    public function __construct()
    {
        parent::__construct();

        // Do not edit the following statement.
        $parent_vars = array_except(
            get_object_vars($this), array_merge(
                array_keys(get_class_vars(parent::class)),
                ['config']
            )
        );

        //--------------------------------------------------------------------
        // Configuration Options, You May Edit Them
        //--------------------------------------------------------------------

        // Twig Environment --------------------------------------------------

        $this->debug = ENVIRONMENT !== 'production';

        $this->cache = ENVIRONMENT === 'production' ? TWIG_CACHE : false;

        // Filesystem Loader -------------------------------------------------

        // APPPATH.'Views' and COMMONPATH.'Views' have been already added.

        $this->paths = [
            // [MYPATH, 'add'],      // An alternative way, 'add' is by default;
            // [MYPATH, 'prepend'],  // Or this way.
        ];

        // Twig Extensions ---------------------------------------------------

        $this->extensions = [];

        // Load Helpers ------------------------------------------------------

        $this->helpers = [];

        // Functions ---------------------------------------------------------

        $this->functions = [];

        // Filters -----------------------------------------------------------

        $this->filters = [];

        // Tests (is * operators) --------------------------------------------

        $this->tests = [];

        // Global Variables --------------------------------------------------

        $this->globals = [];

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
            $this->config, $parent_vars,
            array_except(
                get_object_vars($this), array_merge(
                    array_keys(get_class_vars(parent::class)),
                    ['config']
                )
            )
        );
    }

    //------------------------------------------------------------------------

}

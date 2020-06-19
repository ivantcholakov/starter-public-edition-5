<?php namespace Common\Config;

class Twig extends \Common\Modules\Twig\Config\Twig
{
    public function __construct()
    {
        parent::__construct();

        // Twig Environment --------------------------------------------------

        $this->debug = ENVIRONMENT !== 'production';

        $this->cache = false;

        // Filesystem Loader -------------------------------------------------

        $this->paths = [
            APPPATH . 'Views',
            COMMONPATH . 'Views',
            // [MYPATH, 'add'],      // An alternative way, 'add' is by default;
            // [MYPATH, 'prepend'],  // Or this way.
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

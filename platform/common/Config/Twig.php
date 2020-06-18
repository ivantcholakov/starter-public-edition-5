<?php namespace Common\Config;

class Twig extends \Common\Modules\System\Config\Twig
{
    public $debug = false;

    public $charset = 'UTF-8';

    public $strict_variables = false;

    public $autoescape = 'html';

    public $cache = false;

    public $auto_reload = null;

    public $optimizations = -1;

    public function __construct()
    {
        parent::__construct();

        //--------------------------------------------------------------------
        // Do Not Edit Below This Line
        //--------------------------------------------------------------------

        $this->config = array_merge(
            $this->config, array_except(get_object_vars($this),
            array_keys(get_class_vars(parent::class)))
        );
    }

    //--------------------------------------------------------------------

}

<?php namespace Common\Config;

class Views extends \Common\Modules\System\Config\Views
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

        // Enable/Disable View Drivers ---------------------------------------

        $this->validDrivers = [
            ['twig' => true],
        //    ['mustache' => true],
        //    ['handlebars' => true],
        //    ['markdown' => true],
        //    ['textile' => true],
        ];

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

    //--------------------------------------------------------------------

}

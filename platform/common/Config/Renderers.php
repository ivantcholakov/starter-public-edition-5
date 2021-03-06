<?php namespace Common\Config;

class Renderers extends \Common\Modules\Renderers\Config\Renderers
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
            ['mustache' => true],
            ['handlebars' => true],
            ['markdown' => true],
            ['textile' => true],
            ['markdownify' => true],
            ['less' => true],
            ['scss' => true],
            ['autoprefixer' => true],
            ['cssmin' => true],
            ['jsmin' => true],
            ['jsonmin' => true],
            ['highlight' => true],
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

<?php namespace Common\Config;

class Less extends \Common\Modules\Renderers\Config\Less
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

        // For less.js - the compiler's executable path.
        $this->lessc_path = 'lessc';

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

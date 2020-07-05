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

        // Be verbose.
        $this->verbose = false;

        //--------------------------------------------------------------------
        // Do Not Edit Below This Line
        //--------------------------------------------------------------------

        $this->config = array_merge(
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

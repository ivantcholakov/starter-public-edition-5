<?php namespace Common\Config;

class Scss extends \Common\Modules\Renderers\Config\Scss
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

        // Import Paths
        $this->import_paths = [''];

        // Number Precision
        $this->number_precision = 5;

        // Output Formatting
        // 'expanded', 'nested', 'compressed', 'compact', or 'crunched'
        $this->formatter = 'expanded';

        // Line Number Style
        $this->line_number_style = null;

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

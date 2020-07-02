<?php namespace Common\Config;

class Autoprefixer extends \Common\Modules\Renderers\Config\Autoprefixer
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

        // Rules about selecting supported browsers.
        // See https://github.com/ai/browserslist
        // Examples:
        // $this->config['browsers'] = ['last 2 versions', 'ie 6-8', 'Firefox > 20'];
        // $this->config['browsers'] = ['> 1%', 'last 2 versions', 'Firefox ESR', 'Opera 12.1'];
        $this->browsers = array('> 1%', 'last 2 versions', 'Firefox ESR');

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

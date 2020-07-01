<?php namespace Common\Config;

class Handlebars extends \Common\Modules\Renderers\Config\Handlebars
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

        $this->cache = ENVIRONMENT === 'production' ? HANDLEBARS_CACHE : null;

        //--------------------------------------------------------------------
        // Do Not Edit Below This Line
        //--------------------------------------------------------------------

        if (isset($this->config['escapeArgs']) && isset($this->escapeArgs)) {
            unset($this->config['escapeArgs']);
        }

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

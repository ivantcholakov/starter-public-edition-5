<?php namespace Common\Config;

class Markdownify extends \Common\Modules\Renderers\Config\Markdownify
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

        // Whether or not to flush stacked links after each paragraph.
        // 0 - after content;
        // 1 - after each paragraph;
        // 2 - in paragraph.
        $this->linkPosition = 0;

        // Whether or not to wrap the output to the given width.
        $this->bodyWidth = false;

        // Whether to keep non markdownable HTML or to discard it.
        $this->keepHTML = false;

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

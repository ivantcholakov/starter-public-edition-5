<?php namespace Common\Modules\Renderers\Config;

use CodeIgniter\Config\BaseConfig;

class Markdownify extends BaseConfig
{
    public $config = [];

    public function __construct()
    {
        parent::__construct();

        // Whether or not to flush stacked links after each paragraph.
        // 0 - after content;
        // 1 - after each paragraph;
        // 2 - in paragraph.
        $this->config['linkPosition'] = 0;

        // Whether or not to wrap the output to the given width.
        $this->config['bodyWidth'] = false;

        // Whether to keep non markdownable HTML or to discard it.
        $this->config['keepHTML'] = false;
    }

    //------------------------------------------------------------------------

}

<?php namespace Common\Modules\Renderers\Config;

use CodeIgniter\Config\BaseConfig;

class Scss extends BaseConfig
{
    public $config = [];

    public function __construct()
    {
        parent::__construct();

        // Import Paths
        $this->config['import_paths'] = [''];

        // Number Precision
        $this->config['number_precision'] = 5;

        // Output Formatting
        // 'expanded', 'nested', 'compressed', 'compact', or 'crunched'
        $this->config['formatter'] = 'expanded';

        // Line Number Style
        $this->config['line_number_style'] = null;
    }

    //------------------------------------------------------------------------

}

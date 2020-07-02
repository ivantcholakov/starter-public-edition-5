<?php namespace Common\Modules\Renderers\Config;

use CodeIgniter\Config\BaseConfig;

class Autoprefixer extends BaseConfig
{
    public $config = [];

    public function __construct()
    {
        parent::__construct();

        // The compiler's executable path.
        // See https://github.com/postcss/autoprefixer
        // Install it globally, for example on Ubuntu:
        // sudo npm install --global postcss-cli autoprefixer
        $this->config['postcss_path'] = 'postcss';

        // A directory for storing temporary files.
        $this->config['tmp_dir'] = TMP_PATH;

        // Rules about selecting supported browsers.
        // See https://github.com/ai/browserslist
        // Examples:
        // $this->config['browsers'] = ['last 2 versions', 'ie 6-8', 'Firefox > 20'];
        // $this->config['browsers'] = ['> 1%', 'last 2 versions', 'Firefox ESR', 'Opera 12.1'];
        $this->config['browsers'] = ['> 1%', 'last 2 versions', 'Firefox ESR'];
    }

    //------------------------------------------------------------------------

}

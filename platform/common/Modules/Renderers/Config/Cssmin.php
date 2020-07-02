<?php namespace Common\Modules\Renderers\Config;

use CodeIgniter\Config\BaseConfig;

class Cssmin extends BaseConfig
{
    public $config = [];

    public function __construct()
    {
        parent::__construct();

        // Which CSS minifier is to be used:
        // 'cssnano'            - http://cssnano.co
        // 'minifycss'          - https://github.com/matthiasmullie/minify
        $this->config['implementation'] = 'cssnano';

        // Options for 'cssnano':

        // The compiler's executable path.
        // Install cssnano and postcss-cli globally, for example on Ubuntu:
        // sudo npm install --global postcss-cli cssnano
        $this->config['postcss_path'] = 'postcss';

        // A directory for storing temporary files.
        $this->config['tmp_dir'] = TMP_PATH;

        // Set this to true to disable advanced optimisations that are not always safe.
        $this->config['safe'] = true;
    }

    //------------------------------------------------------------------------

}

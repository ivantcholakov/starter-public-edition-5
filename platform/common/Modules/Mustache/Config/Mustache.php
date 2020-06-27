<?php namespace Common\Modules\Mustache\Config;

use CodeIgniter\Config\BaseConfig;

class Mustache extends BaseConfig
{
    public $config = [];

    public function __construct()
    {
        parent::__construct();

        // Mustache Environment ----------------------------------------------

        $this->config['template_class_prefix'] = '__Mustache_';

        $this->config['cache'] = ENVIRONMENT === 'production' ? MUSTACHE_CACHE : null;

        $this->config['cache_file_mode'] = 0666;

        $this->config['cache_lambda_templates'] = null;

        $this->config['loader'] = null;

        $this->config['partials_loader'] = null;

        $this->config['partials'] = null;

        $this->config['helpers'] = null;

        $this->config['escape'] = null;

        $this->config['entity_flags'] = ENT_QUOTES;

        $this->config['charset'] = 'UTF-8';

        $this->config['logger'] = null;

        $this->config['strict_callables'] = false;

        $this->config['delimiters'] = null;

        $this->config['pragmas'] = [];
    }

    //------------------------------------------------------------------------

}

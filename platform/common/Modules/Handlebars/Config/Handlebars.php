<?php namespace Common\Modules\Handlebars\Config;

use CodeIgniter\Config\BaseConfig;

class Handlebars extends BaseConfig
{
    public $config = [];

    public function __construct()
    {
        parent::__construct();

        // Handlebars Environment --------------------------------------------

        $this->config['cache'] = ENVIRONMENT === 'production' ? HANDLEBARS_CACHE : null;


    }

    //------------------------------------------------------------------------

}

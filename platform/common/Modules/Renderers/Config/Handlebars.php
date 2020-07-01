<?php namespace Common\Modules\Renderers\Config;

use CodeIgniter\Config\BaseConfig;

class Handlebars extends BaseConfig
{
    public $config = [];

    public function __construct()
    {
        parent::__construct();

        // Handlebars Environment --------------------------------------------

        // Filesystem path to the disk cache location.
        $this->config['cache'] = ENVIRONMENT === 'production' ? HANDLEBARS_CACHE : null;

        // Cache file prefix, defaults to empty string.
        $this->config['cache_file_prefix'] = '';

        // Cache file extension, defaults to empty string.
        $this->config['cache_file_suffix'] = '';

        // A Handlebars template loader instance. Uses a StringLoader if not specified.
        $this->config['loader'] = null;

        // A Handlebars loader instance for partials. Uses a StringLoader if not specified.
        $this->config['partials_loader'] = null;

        // An array of alliases of partial names: [['initial_name' => 'alias'], ...]
        // The loader for partials would try to locate them by aliases only, if defined.
        $this->config['partials_alias'] = [];

        // An array of helper functions. Normally a function like
        // function ($sender, $name, $arguments), $arguments is unscaped arguments and
        // is a string, not an array.
        $this->config['helpers'] = null;

        // A callable escape function to use.
        $this->config['escape'] = 'htmlspecialchars';

        // Parametes to pass to the escape function.
        $this->config['escapeArgs'] = [ENT_QUOTES, 'UTF-8'];

        // Enables @data variables (boolean, default: false).
        $this->config['enableDataVariables'] = false;
    }

    //------------------------------------------------------------------------

}

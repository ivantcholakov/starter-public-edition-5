<?php namespace Common\Modules\Renderers\Config;

use CodeIgniter\Config\BaseConfig;

class Textile extends BaseConfig
{
    public $config = [];

    public function __construct()
    {
        parent::__construct();

        $this->config['doctype'] = 'html5';   // 'xhtml' or 'html5'

        // This option should be used locally for any untrusted user input,
        // including comments or forum posts.
        $this->config['restricted_mode'] = false;

        $this->config['lite'] = false;

        $this->config['encode'] = false;

        $this->config['noimage'] = false;

        $this->config['strict'] = false;

        $this->config['rel'] = '';
    }

    //------------------------------------------------------------------------

}

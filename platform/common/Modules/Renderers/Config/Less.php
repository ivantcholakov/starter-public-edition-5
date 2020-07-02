<?php namespace Common\Modules\Renderers\Config;

use CodeIgniter\Config\BaseConfig;

class Less extends BaseConfig
{
    public $config = [];

    public function __construct()
    {
        parent::__construct();

        // Javascript LESS compiler is to be used, called internaly through CLI.
        // 'less.js'  - https://github.com/less/less.js
        //              Install less.js globally, for example on Ubuntu:
        //              sudo npm install -g less

        // For less.js - the compiler's executable path.
        $this->config['lessc_path'] = 'lessc';

        // A directory for storing temporary files.
        $this->config['tmp_dir'] = TMP_PATH;

        // Wether or not to compress the output css content. Deprecated.
        $this->config['compress'] = FALSE;

        // Turning off attempts to guess at the output unit when maths is to be done.
        // When this option is on, the following example would be treated as an error:
        // .class {
        //   property: 1px * 2px; /* This is an area? There is no such feature in CSS. */
        //   /* On $this->config['strictUnits'] = FALSE the property would be evaluated to 2px. */
        // }
        $this->config['strictUnits'] = FALSE;

        // URI root the be added as a suffix to relative URLs.
        $this->config['uri_root'] = '';

        // URI root the be added as a suffix to relative URLs.
        $this->config['relativeUrls'] = TRUE;

        // Indentation characters for the output css content, if it is not to be compressed.
        $this->config['indentation'] = '  ';
    }

    //------------------------------------------------------------------------

}

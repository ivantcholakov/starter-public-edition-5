<?php namespace Common\Modules\Renderers\Config;

use CodeIgniter\Config\BaseConfig;

class Highlight extends BaseConfig
{
    public $config = [];

    public function __construct()
    {
        parent::__construct();

        // highlight.php is a server-side syntax highlighter written in PHP
        // that currently supports 185 languages. It's a port of highlight.js
        // by Ivan Sagalaev that makes full use of the language and style
        // definitions of the original JavaScript project.
        // See https://github.com/scrivo/highlight.php

        // Pointing out which languages to be used for syntax highlighting.
        // If none are set - language autodetection is going to be applied.
        // If only one language is set - it will be assumed explicitly.
        $this->config['languages'] = [];
    }

    //------------------------------------------------------------------------

}

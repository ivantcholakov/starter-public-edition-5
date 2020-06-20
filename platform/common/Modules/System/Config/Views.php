<?php namespace Common\Modules\System\Config;

use CodeIgniter\Config\BaseConfig;

class Views extends BaseConfig
{
    public $config = [];

    public function __construct()
    {
        parent::__construct();

        $this->config['validDrivers'] = [
            'twig',
//            'mustache',
//            'handlebars',
//            'markdown',
//            'textile',
        ];

        $this->config['fileExtensions'] = [
            'twig' => ['html.twig', 'twig'],
//            'mustache' => 'mustache',
//            'handlebars' => ['handlebars', 'hbs'],
//            'markdown' => ['md', 'markdown', 'fbmd'],
//            'textile' => 'textile',
        ];

        $this->config['driverTypes'] = [
            'twig' => 'renderer',
//            'mustache' => 'renderer',
//            'handlebars' => 'renderer',
//            'markdown' => 'parser',
//            'textile' => 'parser',
        ];

        $this->config['driverClasses'] = [
            'twig' => '\Common\Modules\Twig\Twig',
        ];
    }

}

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
            'mustache',
            'handlebars',
            'markdown',
            'textile',
        ];

        $this->config['fileExtensions'] = [
            'twig' => ['twig', 'html.twig'],
            'mustache' => 'mustache',
            'handlebars' => ['handlebars', 'hbs'],
            'markdown' => ['md', 'markdown', 'fbmd'],
            'textile' => 'textile',
        ];

        // 'renderer', 'parser' - Engines that use templates with standard file extensions.
        //                        PHP is not allowed as predecessor renderer.
        // 'filter'             - Simple text post-processors, no standard file extensions.
        //                        PHP is allowed if there is no predecessor renderer.
        $this->config['driverTypes'] = [
            'twig' => 'renderer',
            'mustache' => 'renderer',
            'handlebars' => 'renderer',
            'markdown' => 'parser',
            'textile' => 'parser',
        ];

        $this->config['driverClasses'] = [
            'twig' => '\Common\Modules\Twig\Twig',
            'mustache' => '\Common\Modules\Mustache\Mustache',
            'handlebars' => '\Common\Modules\Handlebars\Handlebars',
            'markdown' => '\Common\Modules\Markdown\Markdown',
            'textile' => '\Common\Modules\Textile\Textile',
        ];
    }

}

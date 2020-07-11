<?php namespace Common\Modules\Renderers\Config;

use CodeIgniter\Config\BaseConfig;

class Renderers extends BaseConfig
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
            'markownify',
            'less',
            'scss',
            'autoprefixer',
            'cssmin',
            'jsmin',
            'jsonmin',
            'highlight',
        ];

        // PHP in views is not allowed as predecessor renderer,
        // if there is a file extension here.
        $this->config['fileExtensions'] = [
            'twig' => ['twig', 'html.twig'],
            'mustache' => 'mustache',
            'handlebars' => ['handlebars', 'hbs'],
            'markdown' => ['md', 'markdown', 'fbmd'],
            'textile' => 'textile',
            'less' => 'less',
            'scss' => 'scss',
        ];

        // 'renderer', 'parser'
        $this->config['driverTypes'] = [
            'twig' => 'renderer',
            'mustache' => 'renderer',
            'handlebars' => 'renderer',
            'markdown' => 'parser',
            'textile' => 'parser',
            'markdownify' => 'parser',
            'less' => 'parser',
            'scss' => 'parser',
            'autoprefixer' => 'parser',
            'cssmin' => 'parser',
            'jsmin' => 'parser',
            'jsonmin' => 'parser',
            'highlight' => 'parser',
        ];

        $this->config['driverClasses'] = [
            'twig' => '\Common\Modules\Renderers\Twig',
            'mustache' => '\Common\Modules\Renderers\Mustache',
            'handlebars' => '\Common\Modules\Renderers\Handlebars',
            'markdown' => '\Common\Modules\Renderers\Markdown',
            'textile' => '\Common\Modules\Renderers\Textile',
            'markdownify' => '\Common\Modules\Renderers\Markdownify',
            'less' => '\Common\Modules\Renderers\Less',
            'scss' => '\Common\Modules\Renderers\Scss',
            'autoprefixer' => '\Common\Modules\Renderers\Autoprefixer',
            'cssmin' => '\Common\Modules\Renderers\Cssmin',
            'jsmin' => '\Common\Modules\Renderers\Jsmin',
            'jsonmin' => '\Common\Modules\Renderers\Jsonmin',
            'highlight' => '\Common\Modules\Renderers\Highlight',
        ];
    }

}

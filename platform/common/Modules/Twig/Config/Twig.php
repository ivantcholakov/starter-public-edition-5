<?php namespace Common\Modules\Twig\Config;

use CodeIgniter\Config\BaseConfig;

class Twig extends BaseConfig
{
    public $config = [
        'debug' => false,
        'charset' => 'UTF-8',
        'strict_variables' => false,
        'autoescape' => 'html',
        'cache' => false,
        'auto_reload' => null,
        'optimizations' => -1,
    ];

    public function __construct()
    {
        parent::__construct();

        $this->config['extensions'] = [
            ['\Twig\Extension\DebugExtension' => false],
        ];

    }
}

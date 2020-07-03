<?php namespace Common\Config;

use CodeIgniter\Config\BaseConfig;

class AssetsCompile extends BaseConfig
{
    public $tasks;

    public function __construct() {

        // The following command-line runs all the tasks:
        // php spark assets:compile

        $this->tasks = [

            // php spark assets:compile welcome_message_css_min
            [
                'name' => 'welcome_message_css_min',
                'type' => 'autoprefixer',
                'source' => DEFAULTFCPATH.'assets/welcome_message.css',
                'destination' => DEFAULTFCPATH.'assets/welcome_message.min.css',
                'autoprefixer' => ['browsers' => ['> 1%', 'last 2 versions', 'Firefox ESR', 'Safari >= 7', 'iOS >= 7', 'ie >= 10', 'Edge >= 12', 'Android >= 4']],
                'cssmin' => [],
            ],

            // php spark assets:compile welcome_message_js_min
            [
                'name' => 'welcome_message_js_min',
                'type' => 'jsmin',
                'source' => DEFAULTFCPATH.'assets/welcome_message.js',
                'destination' => DEFAULTFCPATH.'assets/welcome_message.min.js',
            ],

        ];
    }
}

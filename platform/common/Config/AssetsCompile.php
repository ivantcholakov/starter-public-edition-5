<?php namespace Common\Config;

use CodeIgniter\Config\BaseConfig;

class AssetsCompile extends BaseConfig
{
    public $tasks;

    public function __construct() {

        // The following command-line runs all the tasks:
        // php spark assets:compile

        $this->tasks = [
/*
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
*/
            // php spark assets:compile welcome_message_css
            [
                'name' => 'welcome_message_css',
                'type' => 'merge_css',
                'destination' => DEFAULTFCPATH.'assets/welcome_message.min.css',
                'sha384' => true,
                'sha384.base64' => true,
                'sources' => [
                    [
                        'source' => DEFAULTFCPATH.'assets/welcome_message.css',
                        'type' => 'autoprefixer',
                        'autoprefixer' => ['browsers' => ['> 1%', 'last 2 versions', 'Firefox ESR', 'Safari >= 7', 'iOS >= 7', 'ie >= 10', 'Edge >= 12', 'Android >= 4']],
                        'cssmin' => [],
                    ],
                    [
                        'source' => DEFAULTFCPATH.'assets/welcome_message_2.css',
                        'type' => 'autoprefixer',
                        'autoprefixer' => ['browsers' => ['> 1%', 'last 2 versions', 'Firefox ESR', 'Safari >= 7', 'iOS >= 7', 'ie >= 10', 'Edge >= 12', 'Android >= 4']],
                        'cssmin' => [],
                    ],
                ]
            ],

            // php spark assets:compile welcome_message_js
            [
                'name' => 'welcome_message_js',
                'type' => 'merge_js',
                'destination' => DEFAULTFCPATH.'assets/welcome_message.min.js',
                'sha384' => true,
                'sha384.base64' => true,
                'sources' => [
                    [
                        'source' => DEFAULTFCPATH.'assets/npm-asset/jquery/dist/jquery.min.js',
                        'type' => 'copy',
                    ],
                    [
                        'source' => DEFAULTFCPATH.'assets/welcome_message.js',
                        'type' => 'jsmin',
                    ],
                ],
            ],

            // php spark assets:compile front_default_css
            [
                'name' => 'front_default_css',
                'type' => 'merge_css',
                'destination' => DEFAULTFCPATH.'themes/front_default/css/front.min.css',
                'sha384' => true,
                'sha384.base64' => true,
                'sources' => [
                    [
                        'source' => DEFAULTFCPATH.'themes/front_default/src/front.less',
                        'type' => 'less',
                        'less' => [
                            'include_path' => [
                                DEFAULTFCPATH.'themes/front_default/src/definitions/include_path/',
                            ],
                            'rewrite_urls' => 'all'
                        ],
                        'autoprefixer' => ['browsers' => ['> 1%', 'last 2 versions', 'Firefox ESR', 'Safari >= 7', 'iOS >= 7', 'ie >= 10', 'Edge >= 12', 'Android >= 4']],
                        'cssmin' => [],
                    ],
                ]
            ],

        ];
    }
}

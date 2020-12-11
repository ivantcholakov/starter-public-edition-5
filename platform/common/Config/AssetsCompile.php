<?php namespace Common\Config;

use CodeIgniter\Config\BaseConfig;

class AssetsCompile extends BaseConfig
{
    public $tasks;

    public function __construct() {

        // An autoprefixer option: Supported browsers.

        $this->autoprefixer_browsers = [
            '>= 0.1%',
            'last 2 versions',
            'Firefox ESR',
            'Safari >= 7',
            'iOS >= 7',
            'ie >= 10',
            'Edge >= 12',
            'Android >= 4',
        ];

        // The following command-line runs all the tasks:
        // php spark assets:compile

        $this->tasks = [

            // Compiling visual themes with Semantic/Fomantic UI might require a lot
            // of memory for node.js. In such case try from a command line this:
            // export NODE_OPTIONS=--max-old-space-size=8192

            // php spark assets:compile front-default-min
            [
                'name' => 'front-default-min',
                'type' => 'merge_css',
                'destination' => DEFAULTFCPATH.'themes/front_default/css/front.min.css',
                'sources' => [
                    [
                        'source' => DEFAULTFCPATH.'themes/front_default/less/index.less',
                        'type' => 'less',
                        'less' => [],
                        'autoprefixer' => ['browsers' => $this->autoprefixer_browsers],
                        'cssmin' => [],
                    ],
                ],
                'after' => [
                    [$this, 'create_sha384'],
                    [$this, 'create_sha384_base64'],
                ],
            ],

        ];
    }

    public function create_sha384($task) {

        $destination_hash = $task['destination'].'.sha384';
        $hash = hash('sha384', $task['result']);
        write_file($destination_hash, $hash);
        @chmod($destination_hash, FILE_WRITE_MODE);
    }

    public function create_sha384_base64($task) {

        $destination_hash = $task['destination'].'.sha384.base64';
        $hash = base64_encode(hash('sha384', $task['result']));
        write_file($destination_hash, $hash);
        @chmod($destination_hash, FILE_WRITE_MODE);
    }

}

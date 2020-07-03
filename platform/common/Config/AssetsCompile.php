<?php namespace Common\Config;

use CodeIgniter\Config\BaseConfig;

class AssetsCompile extends BaseConfig
{
    public $tasks;

    public function __construct() {

        // The following command-line runs all the tasks:
        // php spark assets:compile

        $this->tasks = [

            // php spark assets:compile test-less-min
            [
                'name' => 'test-less-min',
                'type' => 'less',
                'source' => DEFAULTFCPATH.'assets/test-less.less',
                'destination' => DEFAULTFCPATH.'assets/test-less.min.css',
                'less' => ['relativeUrls' => false],
                'autoprefixer' => ['browsers' => ['> 1%', 'last 2 versions', 'Firefox ESR', 'Safari >= 7', 'iOS >= 7', 'ie >= 10', 'Edge >= 12', 'Android >= 4']],
                'cssmin' => [],
            ],

            // php spark assets:compile test-scss-min
            [
                'name' => 'test-scss-min',
                'type' => 'scss',
                'source' => DEFAULTFCPATH.'assets/test-scss.scss',
                'destination' => DEFAULTFCPATH.'assets/test-scss.min.css',
                'autoprefixer' => ['browsers' => ['> 1%', 'last 2 versions', 'Firefox ESR', 'Safari >= 7', 'iOS >= 7', 'ie >= 10', 'Edge >= 12', 'Android >= 4']],
                'cssmin' => [],
            ],

            // php spark assets:compile test-jsmin
            [
                'name' => 'test-jsmin',
                'type' => 'jsmin',
                'source' => DEFAULTFCPATH.'assets/test-jsmin.js',
                'destination' => DEFAULTFCPATH.'assets/test-jsmin.min.js',
            ],

        ];
    }
}

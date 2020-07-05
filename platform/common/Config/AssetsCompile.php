<?php namespace Common\Config;

use CodeIgniter\Config\BaseConfig;

class AssetsCompile extends BaseConfig
{
    public $tasks;

    public function __construct() {

        // The following command-line runs all the tasks:
        // php spark assets:compile

        $this->tasks = [

            // Compiling visual themes with Semantic/Fomantic UI might require a lot
            // of memory for node.js. In such case try from a command line this:
            // export NODE_OPTIONS=--max-old-space-size=8192

            // php spark assets:compile front_default_css
            [
                'name' => 'front_default_css',
                'type' => 'merge_css',
                'destination' => DEFAULTFCPATH.'themes/front_default/css/front.min.css',
                'sources' => [
                    [
                        'source' => DEFAULTFCPATH.'themes/front_default/src/front.less',
                        'type' => 'less',
                        'less' => [
                            'rewrite_urls' => 'all',
                        ],
                        'autoprefixer' => ['browsers' => ['> 1%', 'last 2 versions', 'Firefox ESR', 'Safari >= 7', 'iOS >= 7', 'ie >= 10', 'Edge >= 12', 'Android >= 4']],
                        'cssmin' => [],
                    ],
                ],
                'before' => [$this, 'prepare_semantic_source'],
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

    public function prepare_semantic_source($task) {

        $semantic_file = DEFAULTFCPATH.'assets/composer-asset/fomantic/ui/src/semantic.less';

        file_put_contents($semantic_file, <<<'EOT'
@theme-loader-path: ''; // Added by Ivan Tcholakov, 05-JUL-2020.

/*

███████╗███████╗███╗   ███╗ █████╗ ███╗   ██╗████████╗██╗ ██████╗    ██╗   ██╗██╗
██╔════╝██╔════╝████╗ ████║██╔══██╗████╗  ██║╚══██╔══╝██║██╔════╝    ██║   ██║██║
███████╗█████╗  ██╔████╔██║███████║██╔██╗ ██║   ██║   ██║██║         ██║   ██║██║
╚════██║██╔══╝  ██║╚██╔╝██║██╔══██║██║╚██╗██║   ██║   ██║██║         ██║   ██║██║
███████║███████╗██║ ╚═╝ ██║██║  ██║██║ ╚████║   ██║   ██║╚██████╗    ╚██████╔╝██║
╚══════╝╚══════╝╚═╝     ╚═╝╚═╝  ╚═╝╚═╝  ╚═══╝   ╚═╝   ╚═╝ ╚═════╝     ╚═════╝ ╚═╝

  Import this file into your LESS project to use Fomantic-UI without build tools
*/

/* Global */
& { @import "definitions/globals/reset"; }
& { @import "definitions/globals/site"; }

/* Elements */
& { @import "definitions/elements/button"; }
& { @import "definitions/elements/container"; }
& { @import "definitions/elements/divider"; }
& { @import "definitions/elements/emoji"; }
& { @import "definitions/elements/flag"; }
& { @import "definitions/elements/header"; }
& { @import "definitions/elements/icon"; }
& { @import "definitions/elements/image"; }
& { @import "definitions/elements/input"; }
& { @import "definitions/elements/label"; }
& { @import "definitions/elements/list"; }
& { @import "definitions/elements/loader"; }
& { @import "definitions/elements/placeholder"; }
& { @import "definitions/elements/rail"; }
& { @import "definitions/elements/reveal"; }
& { @import "definitions/elements/segment"; }
& { @import "definitions/elements/step"; }
& { @import "definitions/elements/text"; }

/* Collections */
& { @import "definitions/collections/breadcrumb"; }
& { @import "definitions/collections/form"; }
& { @import "definitions/collections/grid"; }
& { @import "definitions/collections/menu"; }
& { @import "definitions/collections/message"; }
& { @import "definitions/collections/table"; }

/* Views */
& { @import "definitions/views/ad"; }
& { @import "definitions/views/card"; }
& { @import "definitions/views/comment"; }
& { @import "definitions/views/feed"; }
& { @import "definitions/views/item"; }
& { @import "definitions/views/statistic"; }

/* Modules */
& { @import "definitions/modules/accordion"; }
& { @import "definitions/modules/calendar"; }
& { @import "definitions/modules/checkbox"; }
& { @import "definitions/modules/dimmer"; }
& { @import "definitions/modules/dropdown"; }
& { @import "definitions/modules/embed"; }
& { @import "definitions/modules/modal"; }
& { @import "definitions/modules/nag"; }
& { @import "definitions/modules/popup"; }
& { @import "definitions/modules/progress"; }
& { @import "definitions/modules/slider"; }
& { @import "definitions/modules/rating"; }
& { @import "definitions/modules/search"; }
& { @import "definitions/modules/shape"; }
& { @import "definitions/modules/sidebar"; }
& { @import "definitions/modules/sticky"; }
& { @import "definitions/modules/tab"; }
& { @import "definitions/modules/toast"; }
& { @import "definitions/modules/transition"; }
EOT
        );

        @chmod($semantic_file, FILE_WRITE_MODE);

//------------------------------------------------------------------------------

        $semantic_theme_config_file = DEFAULTFCPATH.'assets/composer-asset/fomantic/ui/src/theme.config';

        file_put_contents($semantic_theme_config_file, <<<'EOT'
/*

████████╗██╗  ██╗███████╗███╗   ███╗███████╗███████╗
╚══██╔══╝██║  ██║██╔════╝████╗ ████║██╔════╝██╔════╝
   ██║   ███████║█████╗  ██╔████╔██║█████╗  ███████╗
   ██║   ██╔══██║██╔══╝  ██║╚██╔╝██║██╔══╝  ╚════██║
   ██║   ██║  ██║███████╗██║ ╚═╝ ██║███████╗███████║
   ╚═╝   ╚═╝  ╚═╝╚══════╝╚═╝     ╚═╝╚══════╝╚══════╝

*/

/*******************************
        Theme Selection
*******************************/

/* To override a theme for an individual element
   specify theme name below
*/

/* Global */
@site       : 'default';
@reset      : 'default';

/* Elements */
@button     : 'default';
@container  : 'default';
@divider    : 'default';
@emoji      : 'default';
@flag       : 'default';
@header     : 'default';
@icon       : 'default';
@image      : 'default';
@input      : 'default';
@label      : 'default';
@list       : 'default';
@loader     : 'default';
@placeholder: 'default';
@rail       : 'default';
@reveal     : 'default';
@segment    : 'default';
@step       : 'default';
@text       : 'default';

/* Collections */
@breadcrumb : 'default';
@form       : 'default';
@grid       : 'default';
@menu       : 'default';
@message    : 'default';
@table      : 'default';

/* Modules */
@accordion  : 'default';
@calendar   : 'default';
@checkbox   : 'default';
@dimmer     : 'default';
@dropdown   : 'default';
@embed      : 'default';
@modal      : 'default';
@nag        : 'default';
@popup      : 'default';
@progress   : 'default';
@slider     : 'default';
@rating     : 'default';
@search     : 'default';
@shape      : 'default';
@sidebar    : 'default';
@sticky     : 'default';
@tab        : 'default';
@toast      : 'default';
@transition : 'default';

/* Views */
@ad         : 'default';
@card       : 'default';
@comment    : 'default';
@feed       : 'default';
@item       : 'default';
@statistic  : 'default';

/*******************************
            Folders
*******************************/

/* Path to theme packages */
@themesFolder : 'themes';

/* Path to site override folder */
@siteFolder  : 'site';


/*******************************
         Import Theme
*******************************/

// Modified by Ivan Tcholakov, 05-JUL-2020.
//@import (multiple) "theme.less";
@import (multiple) "@{theme-loader-path}theme.less";
//

/* End Config */
EOT
        );

        @chmod($semantic_theme_config_file, FILE_WRITE_MODE);
    }

}

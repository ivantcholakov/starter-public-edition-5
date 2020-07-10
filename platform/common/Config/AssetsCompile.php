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

            // php spark assets:compile front_default_css
            [
                'name' => 'front_default_css',
                'type' => 'merge_css',
                'destination' => DEFAULTFCPATH.'themes/front_default/css/front.min.css',
                'sources' => [
                    [
                        'source' => DEFAULTFCPATH.'themes/front_default/src/front.less',
                        'type' => 'less',
                        'less' => [],
                        'autoprefixer' => ['browsers' => $this->autoprefixer_browsers],
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

//------------------------------------------------------------------------------

        $semantic_icon_definition_file = DEFAULTFCPATH.'assets/composer-asset/fomantic/ui/src/definitions/elements/icon.less';

        file_put_contents($semantic_icon_definition_file, <<<'EOT'
/*!
 * # Fomantic-UI - Icon
 * http://github.com/fomantic/Fomantic-UI/
 *
 *
 * Released under the MIT license
 * http://opensource.org/licenses/MIT
 *
 */


/*******************************
            Theme
*******************************/

@type    : 'element';
@element : 'icon';

@import (multiple) '../../theme.config';


/*******************************
             Icon
*******************************/

// Removed by Ivan Tcholakov, 10-JUL-2020.
// See https://github.com/fomantic/Fomantic-UI/issues/1560
/*
@font-face {
  font-family: 'Icons';
  src: @fallbackSRC;
  src: @src;
  font-style: normal;
  font-weight: @normal;
  font-variant: normal;
  text-decoration: inherit;
  text-transform: none;
}
*/

i.icon {
  display: inline-block;
  opacity: @opacity;

  margin: 0 @distanceFromText 0 0;

  width: @width;
  height: @height;

  font-family: 'Icons';
  font-style: normal;
  font-weight: @normal;
  text-decoration: inherit;
  text-align: center;

  speak: none;
  -moz-osx-font-smoothing: grayscale;
  -webkit-font-smoothing: antialiased;
  backface-visibility: hidden;
}

i.icon:before {
  background: none !important;
}

/*******************************
             Types
*******************************/

& when (@variationIconLoading) {
  /*--------------
      Loading
  ---------------*/

  i.icon.loading {
    height: 1em;
    line-height: 1;
    animation: loader @loadingDuration linear infinite;
  }
}

/*******************************
             States
*******************************/

i.icon:hover, i.icons:hover,
i.icon:active, i.icons:active,
i.emphasized.icon:not(.disabled), i.emphasized.icons:not(.disabled) {
  opacity: 1;
}

& when (@variationIconDisabled) {
  i.disabled.icon, i.disabled.icons {
    opacity: @disabledOpacity;
    cursor: default;
    pointer-events: none;
  }
}

/*******************************
           Variations
*******************************/

& when (@variationIconFitted) {
  /*-------------------
          Fitted
  --------------------*/

  i.fitted.icon {
    width: auto;
    margin: 0 !important;
  }
}

& when (@variationIconLink) {
  /*-------------------
           Link
  --------------------*/

  i.link.icon:not(.disabled), i.link.icons:not(.disabled) {
    cursor: pointer;
    opacity: @linkOpacity;
    transition: opacity @defaultDuration @defaultEasing;
  }
  i.link.icon:hover, i.link.icons:hover {
    opacity: 1;
  }
}

& when (@variationIconCircular) {
  /*-------------------
        Circular
  --------------------*/

  i.circular.icon {
    border-radius: 500em !important;
    line-height: 1 !important;

    padding: @circularPadding !important;
    box-shadow: @circularShadow;

    width: @circularSize !important;
    height: @circularSize !important;
  }
  & when (@variationIconInverted) {
    i.circular.inverted.icon {
      border: none;
      box-shadow: none;
    }
  }
}

& when (@variationIconFlipped) {
  /*-------------------
        Flipped
  --------------------*/

  i.flipped.icon,
  i.horizontally.flipped.icon {
    transform: scale(-1, 1);
  }
  i.vertically.flipped.icon {
    transform: scale(1, -1);
  }
}

& when (@variationIconRotated) {
  /*-------------------
        Rotated
  --------------------*/

  i.rotated.icon,
  i.right.rotated.icon,
  i.clockwise.rotated.icon {
    transform: rotate(90deg);
  }

  i.left.rotated.icon,
  i.counterclockwise.rotated.icon {
    transform: rotate(-90deg);
  }

  i.halfway.rotated.icon {
    transform: rotate(180deg);
  }
}

& when (@variationIconFlipped) and (@variationIconRotated) {
  /*--------------------------
        Flipped & Rotated
  ---------------------------*/

  i.rotated.flipped.icon,
  i.right.rotated.flipped.icon,
  i.clockwise.rotated.flipped.icon {
    transform: scale(-1, 1) rotate(90deg);
  }

  i.left.rotated.flipped.icon,
  i.counterclockwise.rotated.flipped.icon {
    transform: scale(-1, 1) rotate(-90deg);
  }

  i.halfway.rotated.flipped.icon {
    transform: scale(-1, 1) rotate(180deg);
  }

  i.rotated.vertically.flipped.icon,
  i.right.rotated.vertically.flipped.icon,
  i.clockwise.rotated.vertically.flipped.icon {
    transform: scale(1, -1) rotate(90deg);
  }

  i.left.rotated.vertically.flipped.icon,
  i.counterclockwise.rotated.vertically.flipped.icon {
    transform: scale(1, -1) rotate(-90deg);
  }

  i.halfway.rotated.vertically.flipped.icon {
    transform: scale(1, -1) rotate(180deg);
  }
}

& when (@variationIconBordered) {
  /*-------------------
        Bordered
  --------------------*/

  i.bordered.icon {
    line-height: 1;
    vertical-align: baseline;

    width: @borderedSize;
    height: @borderedSize;
    padding: @borderedVerticalPadding @borderedHorizontalPadding !important;
    box-shadow: @borderedShadow;
  }
  & when (@variationIconInverted) {
    i.bordered.inverted.icon {
      border: none;
      box-shadow: none;
    }
  }
}

& when (@variationIconInverted) {
  /*-------------------
        Inverted
  --------------------*/

  /* Inverted Shapes */
  i.inverted.bordered.icon,
  i.inverted.circular.icon {
    background-color: @black;
    color: @white;
  }

  i.inverted.icon {
    color: @white;
  }
}

/*-------------------
       Colors
--------------------*/

each(@colors, {
  @color: replace(@key, '@', '');
  @c: @colors[@@color][color];
  @l: @colors[@@color][light];

  i.@{color}.icon.icon.icon.icon {
    color: @c;
  }
  & when (@variationIconInverted) {
    i.inverted.@{color}.icon.icon.icon.icon {
      color: @l;
    }
    i.inverted.bordered.@{color}.icon.icon.icon.icon,
    i.inverted.circular.@{color}.icon.icon.icon.icon {
      background-color: @c;
      color: @white;
    }
  }
})


/*-------------------
        Sizes
--------------------*/

i.icon,
i.icons {
  font-size: @medium;
  line-height: @lineHeight;
}
& when not (@variationIconSizes = false) {
  each(@variationIconSizes, {
    @s: @@value;
    i.@{value}.@{value}.@{value}.icon,
    i.@{value}.@{value}.@{value}.icons {
      font-size: @s;
      vertical-align: middle;
    }
  })
}

& when (@variationIconGroups) or (@variationIconCorner) {
  /*******************************
              Groups
  *******************************/

  i.icons {
    display: inline-block;
    position: relative;
    line-height: 1;
  }

  i.icons .icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
    margin: 0;
  }

  i.icons .icon:first-child {
    position: static;
    width: auto;
    height: auto;
    vertical-align: top;
    transform: none;
  }

  & when (@variationIconCorner) {
    /* Corner Icon */
    i.icons .corner.icon {
      top: auto;
      left: auto;
      right: 0;
      bottom: 0;
      transform: none;
      font-size: @cornerIconSize;
      text-shadow: @cornerIconShadow;
    }
    i.icons .icon.corner[class*="top right"] {
      top: 0;
      left: auto;
      right: 0;
      bottom: auto;
    }
    i.icons .icon.corner[class*="top left"] {
      top: 0;
      left: 0;
      right: auto;
      bottom: auto;
    }
    i.icons .icon.corner[class*="bottom left"] {
      top: auto;
      left: 0;
      right: auto;
      bottom: 0;
    }
    i.icons .icon.corner[class*="bottom right"] {
      top: auto;
      left: auto;
      right: 0;
      bottom: 0;
    }
    & when (@variationIconInverted) {
      i.icons .inverted.corner.icon {
        text-shadow: @cornerIconInvertedShadow;
      }
    }
  }
}

.loadUIOverrides();
EOT
        );

        @chmod($semantic_icon_definition_file, FILE_WRITE_MODE);
    }

//------------------------------------------------------------------------------

}

A PHP Application Starter, Version 5, Based on CodeIgniter 4
============================================================

Project Repository
------------------

https://github.com/ivantcholakov/starter-public-edition-5


Notes
-----

This starter supports multiple applications.

Create your own .env file with your specific settings before trying to run this starter.

PHP
---

If you are a beginner with little or no PHP experience, you might need to read a training tutorial like this one:

PHP Tutorial for Beginners: Learn in 7 Days, https://www.guru99.com/php-tutorials.html

CodeIgniter 4 Documentation and Other Information
-------------------------------------------------

CodeIgniter4 User Guide: https://codeigniter.com/user_guide/index.html

Very useful videos by Lonnie Ezell about CodeIgniter 4 may be found at https://www.youtube.com/channel/UCXeSAhgqDXHHfZXwa1Gk2uw

See also CodeIgniter's home page: https://codeigniter.com/

CodeIgniter's forum: https://forum.codeigniter.com/

The GitHub repository of CodeIgniter 4: https://github.com/codeigniter4/CodeIgniter4

Requirements
------------

PHP 7.2.5 or higher, Apache 2.4 (mod_rewrite should be enabled).
For database support seek information within CodeIgniter 4 documentation.

It is highly recommendable the following PHP extensions to be installed:

* **mbstring**;
* **iconv**;
* **intl**;
* **curl**;
* **json**;
* **xml**.

Installation
------------

Download source and place it on your web-server within its document root or within a sub-folder.
Make the folder platform/writable to be writable. It is to contain CodeIgniter's cache, logs and other things that you might add.
Open the site with a browser on an address like this: http://localhost/starter-public-edition-5/public/ or
https://localhost/starter-public-edition-5/public/

On your web-server you may move one level up the content of the folder public, so the segment public from the address to disappear.
Also you can move the folder platform to a folder outside the document root of the web server for increased security.
After such a rearrangement open the file config.php (public/config.php before rearrangement), find the setting $PLATFORMPATH
and change this path accordingly.

The following directories (the locations are the original) must have writable access by Apache and CLI:

```
platform/writable/
```

Have a look at the files .htaccess and robots.txt and adjust them for your site.
Within the folder platform/applications you will by default default - "front".
Have a look at its configuration files. Also, the common PHP configuration files you may find at platform/common/Config/ folder.

The platform auto-detects its base URL address nevertheless its public part is on the document root of the web-server or not.
However, on production installation, site should be accessed only through trusted host/server/domain names,
see platform/common/Config/Config.php , the configuration settings $config['restrictAccessToTrustedHostsOnly'] and
$config['trustedHosts'] for more information.

Within the directory platform/applications/front/ you will find the file env, copy it into file .env and inside the the copied file
uncomment the setting CI_ENVIRONMENT. You can set it

```
CI_ENVIRONMENT = development
```

or

```
CI_ENVIRONMENT = production
```

depending on the stage of readyness of your future application for deployment.

Installation on a developer's machine
-------------------------------------

In addition to the section above, it is desirable on a developer's machine
additional components to be installed globally, they are mostly to support
compilation of web resources (for example: less -> css, ts -> js). The system
accesses them using PHP command-shell functions.

When installing the additional components globally, the command-line console would
require administrative privileges.

* Install Node.js and npm, for example see https://docs.npmjs.com/getting-started/installing-node
As a result, from the command line these commands should work:

```sh
node -v
npm -v
```

* (Optional, Linux, Ubuntu) Install the interactive node.js updater:

```sh
sudo npm install -g n
```

* Later you can use the following commands for updates:

Updating Node.js:

```sh
sudo n lts
```

Updating npm:

```sh
sudo npm i -g npm
```

Updating all the globally installed packages:

```sh
sudo npm update -g
```

Another way for global updating is using the interactive utility npm-check. Installing:

```sh
sudo npm -g i npm-check
```

And then using it:

```sh
sudo npm-check -u -g
```

* Install less.js compiler (http://lesscss.org/) globally:

```sh
sudo npm install less -g
```

Then the following command should work:

```sh
lessc -v
```

* Install PostCSS and its CLI utility (https://github.com/postcss/postcss-cli) globally:

```sh
sudo npm -g install postcss-cli
```

And this command should work:

```sh
postcss -v
```

* Install Autoprefixer (https://github.com/postcss/autoprefixer) globally:

```sh
sudo npm -g install autoprefixer
```

* Install cssnano (https://github.com/ben-eb/cssnano):

```sh
sudo npm -g install cssnano
```

* Install TypeScript compiler (if it is needed):

```sh
sudo npm -g install typescript-compiler
```

This command should work:

```sh
tsc -v
```

On compilation of huge web-resources Node.js might exaust its memory, in such case try
(the value may vary):

```sh
export NODE_OPTIONS=--max-old-space-size=8192
```

Coding Rules
------------

For originally written code a tab is turned into four spaces. This is the only
strict rule. Standard PSR rules are welcome, but it is desirable code not to be
'compressed' vertically, use more meaningful empty lines that would make code
more readable and comfortable.

Additional Features
-------------------

### Template engines, renderers and parsers

* Twig 3.x
* Mustache
* Handlebars
* Markdown (Parsedown implementation)
* Markdownify
* Textile
* Less
* Scss
* Autoprefixer
* Cssmin
* Jsmin
* Jsonmin
* Highlight

See platform/common/Config/Renderers.php on enabling/disbling these engines.
Within platform/common/Config/ there are specific configuration files for every
engine, but probably you would not need to modify them. There is a deeply
hidden (for dicouraging modifications) configuration file with more options
platform/common/Modules/Renderers/Config/Renderers.php, there you can see the
file extensions that are associated with some renderers/parsers, like this:

```php
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
```

How to use them, examples on rendering views: 

```php
return view('welcome_message', $data);          // The renderer would be chosen by file extension of the found view.
                                                // If there is a view welcome_message.php - PHP would be rendered;
                                                // welcome_message.html.twig or welcome_message.twig - Twig syntax would
                                                // be rendered and etc., the same is for other engines;

return view('welcome_message.html', $data);     // A coventional for Symfony notation. I this case welcome_message.html.twig
                                                // is expected to be found;

return view('README');                          // If README.md view is found if t would be parsed as Markdown syntax.
                                                // Parsers don't need to be provided with data;

return view('README.textile');                  // Specifying explicitly the parser by its associated file extension.
return view('welcome_message.php', $data);      // The same, ensuring that PHP would be applied;

return view('README', null, ['textile']);       // Specifying explicitly the parser by using an option;

return view('welcome_message.html', $data, ['twig' => ['debug' => true]]);  // Passing an option, specific to the renderer.
```

Outside, independently from CodeIgniter's view-management system there are two functions, render() and render_string(),
passing parameters to them is similar:

```php
$result = render('email_template.mustache', $data);             // A trivial example;

$result = render_string('# Hello There!', null, 'markdown');    // Here the parser should be specified explicitly;

$result = render(DEFAULTFCPATH.'assets/my.less', null, 'less' => ['full_path' = true]); // Accessing by a full file name;

$result = render(                                               // A chain of renderer/parsers can be applied too.
    DEFAULTFCPATH.'assets/my.less',
    null,
    [
        'less' => ['full_path' = true],
        'autoprefixer',
        'cssmin'
    ]
);
```

### Web-assets

Fomantic-UI CSS/JS framework is used in this application starter, although there is no restriction on what you would
desire to use. But these big resources need efforts for intallation and upgrade, Gulp/Webpack and etc. package managers
from the Javascript world might be annoying burden for a PHP-developer. In order to make this matter easier, a web-asset
compilator has been implemented, it uses internally the corresponding renderers that were previouly descibed. First, the
compiler's tasks must be specified by names, see the configuration file platform/common/Config/AssetsCompile.php.
A simple example:

```php
    ...
    [
        'name' => 'my_task',
        'type' => 'less',
        'source' => DEFAULTFCPATH.'themes/front_default/src/my.less',
        'destination' => DEFAULTFCPATH.'themes/front_default/src/my.min.css',
        'less' => [],
        'autoprefixer' => [
            'browsers' => [
                '> 0.1%',
                'last 2 versions',
                'Firefox ESR',
                'Safari >= 7',
                'iOS >= 7',
                'ie >= 10',
                'Edge >= 12',
                'Android >= 4'
            ]
        ],
        'cssmin' => [],
    ],
    ...
```

As you can see, there are source and destinations files, and a chain of parsers with their specific options.
The type of the task here is the name of the first parser to be applied. Practically, more complex tasks
might be needed when CSS and Javascripts are merged into a single result file. For this purpose there are
two special task-types: 'merge_css' and 'merge_js', see an example:

```php
    [
        'name' => 'front_default_css',
        'type' => 'merge_css',
        'destination' => DEFAULTFCPATH.'themes/front_default/css/front.min.css',
        'sources' => [
            [
                'source' => DEFAULTFCPATH.'themes/front_default/src/front.less',
                'type' => 'less',
                'less' => [],
                'autoprefixer' => [
                    'browsers' => [
                        '> 0.1%',
                        'last 2 versions',
                        'Firefox ESR',
                        'Safari >= 7',
                        'iOS >= 7',
                        'ie >= 10',
                        'Edge >= 12',
                        'Android >= 4'
                    ]
                ],
                'cssmin' => [],
            ],
            [
                'source' => DEFAULTFCPATH.'assets/scss/lib/sweetalert/sweetalert.scss',
                'type' => 'scss',
                'autoprefixer' => [
                    'browsers' => [
                        '> 0.1%',
                        'last 2 versions',
                        'Firefox ESR',
                        'Safari >= 7',
                        'iOS >= 7',
                        'ie >= 10',
                        'Edge >= 12',
                        'Android >= 4'
                    ]
                ],
                'cssmin' => [],
            ],
        ],
        'before' => [$this, 'prepare_semantic_source'],
        'after' => [
            [$this, 'create_sha384'],
            [$this, 'create_sha384_base64'],
        ],
    ],
```

Within the example 'before' and 'after' elements are callbacks that do additional user-defined
actions before and after the correspinding task is executed.

There is a defined special task-type 'copy' that allows merging already minified CSS or JavaScript without
any processing.

How the configeured web-assets to be compiled. Open the command prompt at the directory platform/applications/front/
and write the command:

```sh
php spark assets:compile
```

Thus, all the prepared tasks within the configuration file would be executed. A command like the following
would execute only one or many tasks you have specified (separate with intervals):

```sh
php spark assets:compile task_name_1 task_name_2 task_name_3 ...
```

### Third-Party Components

* Roave Security Advisories - This package ensures that your application doesn't have installed dependencies with known security vulnerabilities, https://github.com/Roave/SecurityAdvisories
* Twig 3.x, the flexible, fast, and secure template engine for PHP, http://twig.sensiolabs.org
* Textile, A Humane Web Text Generator, https://txstyle.org, https://github.com/textile/php-textile
* Markdownify - The HTML to Markdown converter for PHP, https://github.com/Elephant418/Markdownify
* Parsedown - Better Markdown Parser in PHP - https://github.com/erusev/parsedown
* Parsedown Extra - An extension of Parsedown that adds support for Markdown Extra - https://github.com/erusev/parsedown-extra
* Mustache, Logic-less templates, https://github.com/bobthecow/mustache.php, https://github.com/janl/mustache.js
* Handlebars.php - Handlebars processor for PHP, https://github.com/salesforce/handlebars-php
* scssphp, a compiler for SCSS written in PHP, https://github.com/scssphp/scssphp
* TSCompiler, https://github.com/ComFreek/TSCompiler
* php-json-minify, a JSON minifier and uncommenter written in PHP, https://github.com/T1st3/php-json-minify
* CSS & JavaScript minifier, in PHP, https://github.com/matthiasmullie/minify , http://www.minifier.org
* jQuery JavaScript Library - https://github.com/jquery/jquery
* Modernizr, a JavaScript library that detects HTML5 and CSS3 features in the user’s browser, http://modernizr.com
* Web Font Loader, gives you added control when using linked fonts via @font-face, https://github.com/typekit/webfontloader
* An icon subset of flags from GoSquared, https://www.gosquared.com/resources/flag-icons/ , https://github.com/gosquared/flags
* Function print_d() (enhanced debug print), https://github.com/CesiumComputer/print_d
* Menu Library, https://github.com/nihaopaul/Spark-Menu, https://github.com/Barnabas/Spark-Menu (the original spark-source), https://github.com/daylightstudio/FUEL-CMS/blob/master/fuel/modules/fuel/libraries/Menu.php
* Multiplayer - A tiny library to build nice HTML embed codes for videos, https://github.com/felixgirault/multiplayer, https://packagist.org/packages/fg/multiplayer
* imagesLoaded - "You images done yet or what?", https://github.com/desandro/imagesloaded
* Masonry - a cascading grid layout library, https://github.com/desandro/masonry
* Fomantic UI - a component framework based around useful principles from natural language, http://www.semantic-ui.com
* Headroom.js - A widget that reacts to the user's scroll, https://github.com/WickyNilliams/headroom.js
* highlight.js - Javascript syntax highlighter, https://github.com/highlightjs/highlight.js
* highlight.php - A port of highlight.js by Ivan Sagalaev to PHP, https://github.com/scrivo/highlight.php
* Turbolinks - makes navigating your web application faster, https://github.com/turbolinks/turbolinks

License Information
-------------------

For original code in this project:  
Copyright (c) 2020:  
Ivan Tcholakov (the initial author) ivantcholakov@gmail.com  
License: The MIT License (MIT), http://opensource.org/licenses/MIT

Third parties:  
License information is to be found directly within code and/or within additional files at corresponding folders.

Donations
---------

Ivan Tcholakov, 06-JUL-2020: No donations are accepted here. If you wish to help, you need the time and the skills
of being a direct contributor, by providing code/documentation and reporting issues. Period.

Author of This Document
-----------------------

Ivan Tcholakov, 2020

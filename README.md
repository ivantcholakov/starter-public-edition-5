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

Coding Rules
------------

For originally written code a tab is turned into four spaces. This is the only
strict rule. Standard PSR rules are welcome, but it is desirable code not to be
'compressed' vertically, use more meaningful empty lines that would make code
more readable and comfortable.

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

<?php

namespace App\Controllers;

class Home extends \App\Core\BaseController
{
    public function index()
    {
        $this->mainMenu->setActiveItem('home');

        // This is just a demo page, code is done in ad-hoc manner.

        $yes = '<span class="green text">Yes</span>';
        $no  = '<span class="red text">No</span>';

        // Collecting diagnostics data.

        $writable_folders = array(

            'platform/writable/' =>
                [
                    'path' => WRITABLEPATH,
                    'is_writable' => NULL
                ],
            'platform/writable/cache/' =>
                [
                    'path' => WRITABLEPATH.'cache/',
                    'is_writable' => NULL
                ],
            'platform/writable/debugbar/' =>
                [
                    'path' => WRITABLEPATH.'debugbar/',
                    'is_writable' => NULL
                ],
            'platform/writable/handlebars/' =>
                [
                    'path' => WRITABLEPATH.'handlebars/',
                    'is_writable' => NULL
                ],
            'platform/writable/logs/' =>
                [
                    'path' => WRITABLEPATH.'logs/',
                    'is_writable' => NULL
                ],
            'platform/writable/mustache/' =>
                [
                    'path' => WRITABLEPATH.'mustache/',
                    'is_writable' => NULL
                ],
            'platform/writable/session/' =>
                [
                    'path' => WRITABLEPATH.'session/',
                    'is_writable' => NULL
                ],
            'platform/writable/tmp/' =>
                [
                    'path' => WRITABLEPATH.'tmp/',
                    'is_writable' => NULL
                ],
            'platform/writable/twig/' =>
                [
                    'path' => WRITABLEPATH.'twig/',
                    'is_writable' => NULL
                ],
            'platform/writable/uploads/' =>
                [
                    'path' => WRITABLEPATH.'uploads/',
                    'is_writable' => NULL
                ],
        );

        foreach ($writable_folders as $key => $folder) {

            $writable_folders[$key]['is_writable'] = is_really_writable($folder['path']);
        }

        // Diagnostics data decoration.

        $diagnostics = [];

        //----------------------------------------------------------------------

        $diagnostics[] = '<strong>CodeIgniter Version:</strong> '.\CodeIgniter\CodeIgniter::CI_VERSION;

        //----------------------------------------------------------------------

        $diagnostics[] = '<br /><strong>Writable folders check:</strong>';

        foreach ($writable_folders as $key => $folder) {

            if ($writable_folders[$key]['is_writable']) {

                $diagnostics[] = "$key - <span class=\"green text\">writable</span>";

            } else {

                $diagnostics[] = "$key - <span class=\"red text\">make it writable</span>";
            }
        }

        //----------------------------------------------------------------------

        if (function_exists('apache_get_modules')) {

            $apache_modules = apache_get_modules();
            $mod_rewrite_enabled = in_array('mod_rewrite', $apache_modules);

            $diagnostics[] = '<br /><strong>Apache:</strong>';

            $diagnostics[] = 'mod_rewrite enabled - '.($mod_rewrite_enabled ? $yes : $no);
        }

        //----------------------------------------------------------------------

        $diagnostics[] = '<br /><strong>UTF-8 support:</strong>';

        $diagnostics[] = 'IS_UTF8_CHARSET - '.(IS_UTF8_CHARSET ? $yes : $no);
        //$diagnostics[] = 'MBSTRING_INSTALLED - '.(MBSTRING_INSTALLED ? $yes : $no);
        //$diagnostics[] = 'ICONV_INSTALLED - '.(ICONV_INSTALLED ? $yes : $no);
        //$diagnostics[] = 'PCRE_UTF8_INSTALLED - '.(PCRE_UTF8_INSTALLED ? $yes : $no);
        //$diagnostics[] = 'INTL_INSTALLED (optional) - '.(INTL_INSTALLED ? $yes : $no);

        //----------------------------------------------------------------------

        $diagnostics[] = '<br /><strong>Cryptography support:</strong>';

        $diagnostics[] = '\'openssl\' installed - '.(extension_loaded('openssl') ? $yes : $no);

        if (version_compare(PHP_VERSION, '7.1.0-alpha', '<')) {
            $diagnostics[] = 'or \'mcrypt\' installed - '.(defined('MCRYPT_DEV_URANDOM') ? $yes : $no);
        }

        $random_bytes = $no;

        if (function_exists('random_bytes')) {

            try {
                $test = random_bytes(1);
                $random_bytes = $yes;
            }
            catch (Exception $e) {
                $random_bytes = '<span class="red text">'.$e->getMessage().'</span>';
            }
        }

        $diagnostics[] = 'random_bytes() - '.$random_bytes;

        //----------------------------------------------------------------------

        $diagnostics[] = '<br /><strong>Graphics:</strong>';

        $gd_installed = extension_loaded('gd');

        $gd_version = null;

        if ($gd_installed) {

            $gd_info = gd_info();

            if (isset($gd_info['GD Version'])) {
                $gd_version = $gd_info['GD Version'];
            }
        }

        $diagnostics[] = '\'gd\' installed - '.($gd_installed ? $yes.($gd_version != '' ? ', '.$gd_version : '') : $no);

        //----------------------------------------------------------------------

        $diagnostics[] = '<br /><strong>Communication:</strong>';

        $diagnostics[] = '\'curl\' - '.(function_exists('curl_init') ? $yes : $no);

        //----------------------------------------------------------------------

        $diagnostics = implode('<br />', $diagnostics);

        return view('welcome_message', ['diagnostics' => $diagnostics]);
    }

}

<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @link: https://codeigniter4.github.io/CodeIgniter4/
 */

// Renderers -------------------------------------------------------------------

if (!function_exists('render_string')) {

    /**
     * Renders a given string template.
     *
     * @param string $stringTemplate
     * @param array  $data
     * @param string|array $options - driver-specific options.
     *
     * Examples: $output = render_string('Hello {{ name }}!', ['name' => 'John'], 'twig');
     *           $output = render_string('Hello {{ name }}!', ['name' => 'John'], ['twig' => ['debug' => false]]);
     *
     * PHP is not to be rendered.
     *
     * @return string
     */
    function render_string(string $stringTemplate = null, $data = [], $options = []): string
    {
        $stringTemplate = (string) $stringTemplate;
        $output = '';

        if (!is_array($data) && !is_object($data)) {
            $data = [];
        }

        if (!is_array($options) && !is_object($data)) {

            $options = (string) $options;
            $options = $options != '' ? [$options] : [];
        }

        $driverManager = new \Common\Modules\Renderers\Renderers();
        $driverChain = $driverManager->getDriverChain('string', $options);

        if (empty($driverChain)) {

            throw new \InvalidArgumentException('No valid renderer-driver has been specified (\'twig\', \'markdown\', etc.).');

        } else {

            foreach ($driverChain as $currentDriver) {

                $currentRenderer = $driverManager->createRenderer($currentDriver['name']);
                $output = $currentRenderer->renderString(!empty($currentDriver['first']) ? $stringTemplate : $output, !empty($currentDriver['first']) ? $data : [], $currentDriver['options']);
            }
        }

        return (string) $output;
    }

}

if (!function_exists('render')) {

    /**
     * Renders a given view without messing up with other templates data.
     *
     * @param string $view
     * @param array  $data
     * @param string|array $options - driver-specific options.
     *
     * @return string
     */
    function render(string $view = null, $data = [], $options = []): string
    {
        $view = (string) $view;
        $output = '';

        if (!is_array($data) && !is_object($data)) {
            $data = [];
        }

        if (!is_array($options) && !is_object($data)) {

            $options = (string) $options;
            $options = $options != '' ? [$options] : [];
        }

        $driverManager = new \Common\Modules\Renderers\Renderers();
        $driverChain = $driverManager->getDriverChain('view', $options, $view);

        $currentDriver = null;
        $currentRenderer = null;

        foreach ($driverChain as $currentDriver) {

            $currentRenderer = $driverManager->createRenderer($currentDriver['name']);

            if (!empty($currentDriver['first'])) {
                $output = $currentRenderer->render($currentDriver['file'], $data, $currentDriver['options']);
            } else {
                $output = $currentRenderer->renderString($output, [], $currentDriver['options']);
            }
        }

        return (string) $output;
    }

}

if (!function_exists('locate')) {

    /**
     * Returns the full path of a given view.
     *
     * @param string $view
     *
     * @return string
     */
    function locate($view)
    {
        $view = (string) $view;

        $options = [];

        $driverManager = new \Common\Modules\Renderers\Renderers();
        $driverChain = $driverManager->getDriverChain('view', $options, $view);

        if (empty($driverChain)) {
            return null;
        }

        return $driverChain[0]['file'];
    }

}

if (!function_exists('source')) {

    /**
     * Returns the source of a given view.
     *
     * @param string $view
     *
     * @return string
     */
    function source($view)
    {
        return file_get_contents(locate($view));
    }

}

// Global Registry -------------------------------------------------------------

if (!function_exists('registry')) {

    function registry($key)
    {
        return \Config\Services::registry(true)->get($key);
    }

}

if (!function_exists('registry_all')) {

    function registry_all()
    {
        return \Config\Services::registry(true)->getAll();
    }

}

if (!function_exists('registry_set')) {

    function registry_set($key, $value = null)
    {
        \Config\Services::registry(true)->set($key, $value);
    }

}

if (!function_exists('registry_has')) {

    function registry_has($key)
    {
        return \Config\Services::registry(true)->has($key);
    }

}

if (!function_exists('registry_delete')) {

    function registry_delete($key)
    {
        return \Config\Services::registry(true)->delete($key);
    }

}

if (!function_exists('registry_destroy')) {

    // Use this function for testing purposes only.
    function registry_destroy()
    {
        \Config\Services::registry(true)->destroy();
    }

}

// Files -----------------------------------------------------------------------

if (!function_exists('extension')) {

    function extension($path) {

        $qpos = strpos($path, '?');

        if ($qpos !== false) {

            // Eliminate query string.
            $path = substr($path, 0, $qpos);
        }

        return substr(strrchr($path, '.'), 1);
    }

}

// CLI -------------------------------------------------------------------------

if (!function_exists('escape_shell_arg')) {

    /**
     * Escapes command line shell arguments, this is an alternative
     * to the built-in PHP function escapeshellarg($arg).
     *
     * @param string $arg   The input string.
     * @return string
     *
     * @see https://www.php.net/manual/en/function.escapeshellarg.php
     * @see http://stackoverflow.com/questions/6427732/how-can-i-escape-an-arbitrary-string-for-use-as-a-command-line-argument-in-windo
     * @see http://markushedlund.com/dev-tech/php-escapeshellarg-with-unicodeutf-8-support
     *
     * @author Ivan Tcholakov <ivantcholakov@gmail.com>, 2016-2020.
     * @license The MIT License (MIT)
     * @link http://opensource.org/licenses/MIT
     */
    function escape_shell_arg($arg)
    {
        if (IS_WINDOWS_OS) {

            // PHP engine is built for Windows.

            // Sequence of backslashes followed by a double quote:
            // double up all the backslashes and escape the double quote
            $arg = preg_replace('/(\\*)"/', '$1$1\\"', $arg);

            // Sequence of backslashes followed by the end of the arg,
            // which will become a double quote later:
            // double up all the backslashes
            $arg = preg_replace('/(\\*)$/', '$1$1', $arg);

            // All other backslashes do not need modifying

            // Double-quote the whole thing
            $arg = '"'.$arg.'"';

            // Escape shell metacharacters.
            $arg = preg_replace('/([\(\)%!^"<>&|;, ])/', '^$1', $arg);

            return $arg;
        }

        // PHP engine is built for Linux or similar.

        return "'" . str_replace("'", "'\\''", $arg) . "'";
    }

}

// -----------------------------------------------------------------------------

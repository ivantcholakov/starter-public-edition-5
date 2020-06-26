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
    function render_string(string $stringTemplate, $data = [], $options = []): string
    {
        $output = $stringTemplate;

        if (!is_array($data)) {

            $data = (string) $data;
            $data = $data != '' ? [$data] : [];
        }

        if (!is_array($options)) {

            $options = (string) $options;
            $options = $options != '' ? [$options] : [];
        }

        $driverManager = new \Common\Modules\System\View\DriverManager();
        $driverChain = $driverManager->getDriverChain('string', $options);

        if (empty($driverChain)) {

            throw new \InvalidArgumentException('No valid renderer-driver has been specified (\'twig\', \'markdown\', etc.).');

        } else {

            foreach ($driverChain as $currentDriver) {

                $currentRenderer = $driverManager->createRenderer($currentDriver['name']);
                $output = $currentRenderer->renderString($output, !empty($currentDriver['first']) ? $data : [], $currentDriver['options']);
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
    function render(string $view, $data = [], $options = []): string
    {
        $output = '';

        if (!is_array($data)) {

            $data = (string) $data;
            $data = $data != '' ? [$data] : [];
        }

        if (!is_array($options)) {

            $options = (string) $options;
            $options = $options != '' ? [$options] : [];
        }

        $driverManager = new \Common\Modules\System\View\DriverManager();
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

    function registry_destroy()
    {
        \Config\Services::registry(true)->destroy();
    }

}


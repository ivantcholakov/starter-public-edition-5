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

if (! function_exists('view_string'))
{
    /**
     * Grabs the current RendererInterface-compatible class
     * and tells it to render the specified view.
     *
     * NOTE: Does not provide any escaping of the data, so that must
     * all be handled manually by the developer.
     *
     * @param string $stringTemplate
     * @param array  $data
     * @param array  $options - reserved for third-party extensions.
     *
     * @return string
     */
    function view_string(string $stringTemplate, array $data = [], array $options = []): string
    {
        /**
         * @var CodeIgniter\View\View $renderer
         */
        $renderer = Services::renderer();

        // The default option true might cause mess here.
        //$saveData = config(View::class)->saveData;
        $saveData = false;
        //

        if (array_key_exists('saveData', $options))
        {
            $saveData = (bool) $options['saveData'];
            unset($options['saveData']);
        }

        return $renderer->setData($data, 'raw')
                        ->renderString($stringTemplate, $options, $saveData);
    }
}

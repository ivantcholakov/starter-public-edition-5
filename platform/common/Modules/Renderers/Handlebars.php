<?php

namespace Common\Modules\Renderers;

class Handlebars
{
    protected $renderer;

    public function render($template, $data = null, array $options = null)
    {
        $template = (string) $template;

        if (empty($data)) {
            $data = [];
        }

        if (empty($options)) {
            $options = [];
        }

        $config = config('Handlebars')->config;

        if (isset($config['escapeArgs']) && isset($options['escapeArgs'])) {
            unset($config['escapeArgs']);
        }

        $options = array_merge_recursive_distinct($config, $options);
        unset($config);

        if (array_key_exists('cache', $options)) {

            if ($options['cache'] != '') {
                $options['cache'] = rtrim($options['cache'], '/\\');
            } else {
                unset($options['cache']);
            }
        }

        if (!array_key_exists('cache_file_prefix', $options)) {
            $options['cache_file_prefix'] = '';
        }

        if (!array_key_exists('cache_file_suffix', $options)) {
            $options['cache_file_suffix'] = '';
        }

        if (isset($options['cache']) && $options['cache'] != '') {

            $options['cache'] = new \Handlebars\Cache\Disk(
                $options['cache'],
                $options['cache_file_prefix'],
                $options['cache_file_suffix']
            );
        }

        unset($options['cache_file_prefix']);
        unset($options['cache_file_suffix']);

        $base_dir = pathinfo($template, PATHINFO_DIRNAME);
        $filename = pathinfo($template, PATHINFO_FILENAME);
        $extension = pathinfo($template, PATHINFO_EXTENSION);

        if (array_key_exists('loader', $options) && !is_object($options['loader'])) {
            unset($options['loader']);
        }

        if (empty($options['loader'])) {
            $options['loader'] = new \Handlebars\Loader\FilesystemLoader($base_dir, ['extension' => '.'.$extension]);
        }

        if (array_key_exists('partials_loader', $options) && !is_object($options['partials_loader'])) {
            unset($options['partials_loader']);
        }

        if (empty($options['partials_loader'])) {
            $options['partials_loader'] = new \Handlebars\Loader\FilesystemLoader($base_dir, ['extension' => '.'.$extension]);
        }

        if (array_key_exists('helpers', $options) && !is_array($options['helpers']) && !$options['helpers'] instanceof \Traversable) {
            unset($options['helpers']);
        }

        if (!empty($options['helpers'])) {
            $options['helpers'] = new \Handlebars\Helpers($options['helpers']);
        }

        $this->renderer = new \Handlebars\Handlebars($options);

        return $this->renderer->render($filename, $data);
    }

    public function renderString($template, $data = null, array $options = null)
    {
        $template = (string) $template;

        if (empty($data)) {
            $data = [];
        }

        if (empty($options)) {
            $options = [];
        }

        $config = config('Handlebars')->config;

        if (isset($config['escapeArgs']) && isset($options['escapeArgs'])) {
            unset($config['escapeArgs']);
        }

        $options = array_merge_recursive_distinct($config, $options);
        unset($config);

        if (array_key_exists('cache', $options)) {

            if ($options['cache'] != '') {
                $options['cache'] = rtrim($options['cache'], '/\\');
            } else {
                unset($options['cache']);
            }
        }

        if (!array_key_exists('cache_file_prefix', $options)) {
            $options['cache_file_prefix'] = '';
        }

        if (!array_key_exists('cache_file_suffix', $options)) {
            $options['cache_file_suffix'] = '';
        }

        if (isset($options['cache']) && $options['cache'] != '') {

            $options['cache'] = new \Handlebars\Cache\Disk(
                $options['cache'],
                $options['cache_file_prefix'],
                $options['cache_file_suffix']
            );
        }

        unset($options['cache_file_prefix']);
        unset($options['cache_file_suffix']);

        if (array_key_exists('helpers', $options) && !is_array($options['helpers']) && !$options['helpers'] instanceof \Traversable) {
            unset($options['helpers']);
        }

        if (!empty($options['helpers'])) {
            $options['helpers'] = new \Handlebars\Helpers($options['helpers']);
        }

        $this->renderer = new \Handlebars\Handlebars($options);

        return $this->renderer->render($template, $data);
    }

}

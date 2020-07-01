<?php

namespace Common\Modules\Renderers;

class Mustache
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

        $config = config('Mustache')->config;
        $options = array_merge_recursive_distinct($config, $options);
        unset($config);

        if (array_key_exists('cache', $options)) {

            if ($options['cache'] != '') {
                $options['cache'] = rtrim($options['cache'], '/\\');
            } else {
                unset($options['cache']);
            }
        }

        if (array_key_exists('charset', $options)) {
            $options['charset'] = strtoupper($options['charset']);
        }

        $base_dir = pathinfo($template, PATHINFO_DIRNAME);
        $filename = pathinfo($template, PATHINFO_FILENAME);
        $extension = pathinfo($template, PATHINFO_EXTENSION);

        if (array_key_exists('loader', $options) && !is_object($options['loader'])) {
            unset($options['loader']);
        }

        if (empty($options['loader'])) {
            $options['loader'] = new \Mustache_Loader_FilesystemLoader($base_dir, ['extension' => '.'.$extension]);
        }

        if (array_key_exists('partials_loader', $options) && !is_object($options['partials_loader'])) {
            unset($options['partials_loader']);
        }

        if (empty($options['partials_loader'])) {
            $options['partials_loader'] = new \Mustache_Loader_FilesystemLoader($base_dir, ['extension' => '.'.$extension]);
        }

        $this->renderer = new \Mustache_Engine($options);

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

        $config = config('Mustache')->config;
        $options = array_merge_recursive_distinct($config, $options);
        unset($config);

        if (array_key_exists('cache', $options)) {

            if ($options['cache'] != '') {
                $options['cache'] = rtrim($options['cache'], '/\\');
            } else {
                unset($options['cache']);
            }
        }

        if (array_key_exists('charset', $options)) {
            $options['charset'] = strtoupper($options['charset']);
        }

        $options['loader'] = new \Mustache_Loader_StringLoader();

        if (array_key_exists('partials_loader', $options)) {
            unset($options['partials_loader']);
        }

        $this->renderer = new \Mustache_Engine($options);

        return $this->renderer->render($template, $data);
    }

}

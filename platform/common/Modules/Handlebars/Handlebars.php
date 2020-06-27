<?php

namespace Common\Modules\Handlebars;

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
        $options = array_merge_recursive_distinct($config, $options);
        unset($config);

        if (array_key_exists('cache', $options)) {

            if ($options['cache'] != '') {
                $options['cache'] = rtrim($options['cache'], '/\\');
            } else {
                unset($options['cache']);
            }
        }

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
        $options = array_merge_recursive_distinct($config, $options);
        unset($config);

        if (array_key_exists('cache', $options)) {

            if ($options['cache'] != '') {
                $options['cache'] = rtrim($options['cache'], '/\\');
            } else {
                unset($options['cache']);
            }
        }

    }

}

<?php

namespace Common\Modules\Renderers;

class Autoprefixer
{
    protected $renderer;

    public function render($template, $data = null, array $options = null)
    {
        $template = (string) $template;

        if (empty($options)) {
            $options = [];
        }

        $config = config('Autoprefixer')->config;
        $options = array_merge($config, $options);
        unset($config);

        $this->renderer = new \Common\Modules\Renderers\Implementations\Autoprefixer($options);

        return $this->renderer->parse($template);
    }

    public function renderString($template, $data = null, array $options = null)
    {
        $template = (string) $template;

        if (empty($options)) {
            $options = [];
        }

        $config = config('Autoprefixer')->config;
        $options = array_merge($config, $options);
        unset($config);

        $this->renderer = new \Common\Modules\Renderers\Implementations\Autoprefixer($options);

        return $this->renderer->parseString($template);
    }

}

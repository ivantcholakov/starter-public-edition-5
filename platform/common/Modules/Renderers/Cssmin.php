<?php

namespace Common\Modules\Renderers;

class Cssmin
{
    protected $renderer;

    public function render($template, $data = null, array $options = null)
    {
        $template = (string) $template;

        if (empty($options)) {
            $options = [];
        }

        $config = config('Cssmin')->config;
        $options = array_merge($config, $options);
        unset($config);

        switch ($options['implementation'])
        {
            case 'minifycss':

                $this->renderer = new \MatthiasMullie\Minify\CSS($template);

                $result = $this->renderer->minify();

                break;

            default:

                $this->renderer = new \Common\Modules\Renderers\Implementations\Cssnano($options);

                $result = $this->renderer->parse($template);

                break;
        }

        return $result;
    }

    public function renderString($template, $data = null, array $options = null)
    {
        $template = (string) $template;

        if (empty($options)) {
            $options = [];
        }

        $config = config('Cssmin')->config;
        $options = array_merge($config, $options);
        unset($config);

        switch ($options['implementation'])
        {
            case 'minifycss':

                $this->renderer = new \MatthiasMullie\Minify\CSS($template);

                $result = $this->renderer->minify();

                break;

            default:

                $this->renderer = new \Common\Modules\Renderers\Implementations\Cssnano($options);

                $result = $this->renderer->parseString($template);

                break;
        }

        return $result;
    }

}

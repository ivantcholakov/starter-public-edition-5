<?php

namespace Common\Modules\Renderers;

class Scss
{
    protected $renderer;

    protected $allowed_formatters = [
        'expanded',
        'nested',
        'compressed',
        'compact',
        'crunched',
    ];

    public function render($template, $data = null, array $options = null)
    {
        $template = (string) $template;

        if (empty($options)) {
            $options = [];
        }

        $config = config('Scss')->config;
        $options = array_merge($config, $options);
        unset($config);

        $this->renderer = new \ScssPhp\ScssPhp\Compiler();

        $this->renderer->setImportPaths($options['import_paths']);
        $this->renderer->addImportPath(dirname($template));
        $this->renderer->setNumberPrecision($options['number_precision']);

        $formatter = $options['formatter'];

        if (!in_array($formatter, $this->allowed_formatters)) {
            $formatter = 'expanded';
        }

        $formatter = 'ScssPhp\ScssPhp\Formatter\\'.ucfirst($formatter);
        $this->renderer->setFormatter($formatter);

        $this->renderer->setLineNumberStyle($options['line_number_style']);

        return $this->renderer->compile(file_get_contents($template));
     }

    public function renderString($template, $data = null, array $options = null)
    {
        $template = (string) $template;

        if (empty($options)) {
            $options = [];
        }

        $config = config('Scss')->config;
        $options = array_merge($config, $options);
        unset($config);

        $this->renderer = new \ScssPhp\ScssPhp\Compiler();

        $this->renderer->setImportPaths($options['import_paths']);
        $this->renderer->setNumberPrecision($options['number_precision']);

        $formatter = $options['formatter'];

        if (!in_array($formatter, $this->allowed_formatters)) {
            $formatter = 'expanded';
        }

        $formatter = 'ScssPhp\ScssPhp\Formatter\\'.ucfirst($formatter);
        $this->renderer->setFormatter($formatter);

        $this->renderer->setLineNumberStyle($options['line_number_style']);

        return $this->renderer->compile($template);
    }

}

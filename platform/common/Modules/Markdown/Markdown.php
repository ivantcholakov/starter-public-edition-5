<?php

namespace Common\Modules\Markdown;

class Markdown
{
    protected $renderer;

    public function __construct()
    {
    }

    public function render($template, array $data = null, array $options = null)
    {
        if (empty($data)) {
            $data = [];
        }

        if (empty($options)) {
            $options = [];
        }

        $config = config('Markdown')->config;
        $options = array_merge_recursive_distinct($config, $options);
        unset($config);

        $this->renderer = new \ParsedownExtra();

        return $this->renderer->text(file_get_contents($template));
    }

    public function renderString($template, array $data = null, array $options = null)
    {
        if (empty($data)) {
            $data = [];
        }

        if (empty($options)) {
            $options = [];
        }

        $config = config('Markdown')->config;
        $options = array_merge_recursive_distinct($config, $options);
        unset($config);

        $this->renderer = new \ParsedownExtra();

        return $this->renderer->text($template);
    }

}

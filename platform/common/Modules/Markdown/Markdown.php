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
        $this->renderer = new \ParsedownExtra();

        return $this->renderer->text(file_get_contents($template));
    }

    public function renderString($template, array $data = null, array $options = null)
    {
        $this->renderer = new \ParsedownExtra();

        return $this->renderer->text($template);
    }

}

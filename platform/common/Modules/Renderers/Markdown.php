<?php

namespace Common\Modules\Renderers;

class Markdown
{
    protected $renderer;

    public function render($template, $data = null, array $options = null)
    {
        $this->renderer = new \ParsedownExtra();

        return $this->renderer->text(file_get_contents($template));
    }

    public function renderString($template, $data = null, array $options = null)
    {
        $this->renderer = new \ParsedownExtra();

        return $this->renderer->text($template);
    }

}

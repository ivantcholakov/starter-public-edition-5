<?php

namespace Common\Modules\Renderers;

class Jsmin
{
    protected $renderer;

    public function render($template, $data = null, array $options = null)
    {
        $this->renderer = new \MatthiasMullie\Minify\JS($template);

        return $this->renderer->minify();
    }

    public function renderString($template, $data = null, array $options = null)
    {
        $this->renderer = new \MatthiasMullie\Minify\JS($template);

        return $this->renderer->minify();
    }

}

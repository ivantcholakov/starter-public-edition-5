<?php

namespace Common\Modules\Renderers;

class Jsonmin
{
    protected $renderer;

    public function render($template, $data = null, array $options = null)
    {
        $this->renderer = new \t1st3\JSONMin\JSONMin(file_get_contents($template));

        return $this->renderer->getMin();
    }

    public function renderString($template, $data = null, array $options = null)
    {
        $this->renderer = new \t1st3\JSONMin\JSONMin($template);

        return $this->renderer->getMin();
    }

}

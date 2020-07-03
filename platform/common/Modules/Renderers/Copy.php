<?php

namespace Common\Modules\Renderers;

class Copy
{
    public function render($template, $data = null, array $options = null)
    {
        return file_get_contents($template);
    }

    public function renderString($template, $data = null, array $options = null)
    {
        return $template;
    }

}

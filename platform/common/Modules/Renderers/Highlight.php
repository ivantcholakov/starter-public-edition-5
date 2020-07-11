<?php

namespace Common\Modules\Renderers;

class Highlight
{
    protected $renderer;

    public function render($template, $data = null, array $options = null)
    {
        $template = (string) $template;

        if (empty($options)) {
            $options = [];
        }

        $config = config('Highlight')->config;
        $options = array_merge($config, $options);
        unset($config);

        $languages = isset($options['languages']) ? $options['languages'] : [];

        if (!is_array($languages)) {

            $languages = trim($languages) != '' ? [$languages] : [];
        }

        $template = file_get_contents($template);

        $this->renderer = new \Highlight\Highlighter();

        if (count($languages) == 1) {

            try {

                return $this->renderer->highlight($languages[0], $template);

            } catch (\DomainException $e) {

                return $template;
            }
        }

        if (count($languages) > 0) {
            $this->renderer->setAutodetectLanguages($languages);
        }

        try {

            return $this->renderer->highlightAuto($template);

        } catch (\DomainException $e) {

            return $template;
        }

        return $template;
    }

    public function renderString($template, $data = null, array $options = null)
    {
        $template = (string) $template;

        if (empty($options)) {
            $options = [];
        }

        $config = config('Highlight')->config;
        $options = array_merge($config, $options);
        unset($config);

        $languages = isset($options['languages']) ? $options['languages'] : [];

        if (!is_array($languages)) {

            $languages = trim($languages) != '' ? [$languages] : [];
        }

        $this->renderer = new \Highlight\Highlighter();

        if (count($languages) == 1) {

            try {

                return $this->renderer->highlight($languages[0], $template);

            } catch (\DomainException $e) {

                return $template;
            }
        }

        if (count($languages) > 0) {
            $this->renderer->setAutodetectLanguages($languages);
        }

        try {

            return $this->renderer->highlightAuto($template);

        } catch (\DomainException $e) {

            return $template;
        }

        return $template;
    }

}

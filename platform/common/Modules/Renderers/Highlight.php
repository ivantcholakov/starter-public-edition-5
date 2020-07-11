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

        registry_delete('_highlight_language');

        if (count($languages) == 1) {

            try {

                $this->renderer->highlight($languages[0], $template);

                registry_set('_highlight_language', $this->renderer->language);

                return $this->renderer->value;

            } catch (\DomainException $e) {

                return $template;
            }
        }

        if (count($languages) > 0) {
            $this->renderer->setAutodetectLanguages($languages);
        }

        try {

            $this->renderer->highlightAuto($template);

            registry_set('_highlight_language', $this->renderer->language);

            return $this->renderer->value;

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

        registry_delete('_highlight_language');

        if (count($languages) == 1) {

            try {

                $this->renderer->highlight($languages[0], $template);

                registry_set('_highlight_language', $this->renderer->language);

                return $this->renderer->value;

            } catch (\DomainException $e) {

                return $template;
            }
        }

        if (count($languages) > 0) {
            $this->renderer->setAutodetectLanguages($languages);
        }

        try {

            $this->renderer->highlightAuto($template);

            registry_set('_highlight_language', $this->renderer->language);

            return $this->renderer->value;

        } catch (\DomainException $e) {

            return $template;
        }

        return $template;
    }

}

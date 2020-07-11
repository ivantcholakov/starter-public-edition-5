<?php

namespace Common\Modules\Renderers;

class Markdownify
{
    protected $renderer;

    public function render($template, $data = null, array $options = null)
    {
        $template = (string) $template;

        if (empty($options)) {
            $options = [];
        }

        $config = config('Markdownify')->config;
        $options = array_merge($config, $options);
        unset($config);

        // Check whether the deprecated option is still used.
        if (isset($options['linksAfterEachParagraph']) && !isset($options['linkPosition'])) {
            $options['linkPosition'] = empty($options['linksAfterEachParagraph']) ? 0 : 1;
        }

        $template = file_get_contents($template);

        $this->renderer = new \Markdownify\ConverterExtra(
            $options['linkPosition'],
            $options['bodyWidth'],
            $options['keepHTML']
        );

        return $this->renderer->parseString($template);
    }

    public function renderString($template, $data = null, array $options = null)
    {
        $template = (string) $template;

        if (empty($options)) {
            $options = [];
        }

        $config = config('Markdownify')->config;
        $options = array_merge($config, $options);
        unset($config);

        // Check whether the deprecated option is still used.
        if (isset($options['linksAfterEachParagraph']) && !isset($options['linkPosition'])) {
            $options['linkPosition'] = empty($options['linksAfterEachParagraph']) ? 0 : 1;
        }

        $this->renderer = new \Markdownify\ConverterExtra(
            $options['linkPosition'],
            $options['bodyWidth'],
            $options['keepHTML']
        );

        return $this->renderer->parseString($template);
    }

}

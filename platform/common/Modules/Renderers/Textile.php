<?php

namespace Common\Modules\Renderers;

class Textile
{
    protected $renderer;

    public function render($template, $data = null, array $options = null)
    {
        $template = (string) $template;

        if (empty($options)) {
            $options = [];
        }

        $config = config('Textile')->config;
        $options = array_merge($config, $options);
        unset($config);

        $options['restricted_mode'] = !empty($options['restricted_mode']);
        $options['lite'] = !empty($options['lite']);
        $options['encode'] = !empty($options['encode']);
        $options['noimage'] = !empty($options['noimage']);
        $options['strict'] = !empty($options['strict']);
        $options['rel'] = (string) $options['rel'];

        $template = file_get_contents($template);

        $this->renderer = new \Netcarver\Textile\Parser($options['doctype']);

        if ($options['encode']) {

            return $this->renderer->textileEncode($template);
        }

        return $this->renderer
            ->setRestricted($options['restricted_mode'])
            ->setLite($options['lite'])
            ->setBlockTags(true)
            ->setImages(!$options['noimage'])
            ->setLinkRelationShip($options['rel'])
            ->parse($template);
    }

    public function renderString($template, $data = null, array $options = null)
    {
        $template = (string) $template;

        if (empty($options)) {
            $options = [];
        }

        $config = config('Textile')->config;
        $options = array_merge($config, $options);
        unset($config);

        $options['restricted_mode'] = !empty($options['restricted_mode']);
        $options['lite'] = !empty($options['lite']);
        $options['encode'] = !empty($options['encode']);
        $options['noimage'] = !empty($options['noimage']);
        $options['strict'] = !empty($options['strict']);
        $options['rel'] = (string) $options['rel'];

        $this->renderer = new \Netcarver\Textile\Parser($options['doctype']);

        if ($options['encode']) {

            return $this->renderer->textileEncode($template);
        }

        return $this->renderer
            ->setRestricted($options['restricted_mode'])
            ->setLite($options['lite'])
            ->setBlockTags(true)
            ->setImages(!$options['noimage'])
            ->setLinkRelationShip($options['rel'])
            ->parse($template);
    }

}

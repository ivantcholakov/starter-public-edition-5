<?php

namespace Common\Modules\System\View;

class Driver
{
    public static function valid_drivers()
    {
        $result = [
            'parser',
            'twig',
        ];

        return $result;
    }

    public static function is_renderer($driver)
    {
        $renderers = [
            'parser',
            'twig',
        ];

        return in_array($driver, $renderers);
    }

    public static function getFileExtensions()
    {
        $result = [
            'parser' => ['tpl'],
            'twig' => ['twig', 'html.twig'],
            'handlebars' => ['handlebars', 'hbs'],
            'mustache' => ['mustache'],
            'markdown' => ['md', 'markdown', 'fbmd'],
            'textile' => ['textile'],
        ];

        return $result;
    }

    public static function parse_options($options)
    {
        if (!is_array($options)) {

            $options = (string) $options;
            $options = $options != '' ? [$options] : [];
        }

        if (empty($options)) {

            return $options;
        }

        $drivers = [];
        $result = [];

        foreach ($options as $key => $value) {

            if (is_string($key)) {

                if (in_array($key, static::valid_drivers())) {

                    $drivers[] = [['name' => $key], ['type' => static::is_renderer($key) ? 'renderer' : 'parser'], ['options' => $value]];

                } else {

                    $result[$key] = $value;
                }

            } elseif (is_string($value)) {

                if (in_array($value, static::valid_drivers())) {

                    $drivers[] = [['name' => $value], ['type' => static::is_renderer($value) ? 'renderer' : 'parser'], ['options' => []]];

                } else {

                    $result[] = $value;
                }

            }
        }

        if (!empty($drivers)) {

            $result['drivers'] = $drivers;
        }

        return $result;
    }

}

<?php

namespace Common\Modules\System\View;

class Driver
{
    public static function validDrivers()
    {
        $result = [
//            'parser',
            'twig',
//            'handlebars',
//            'mustache',
//            'markdown',
//            'textile',
        ];

        return $result;
    }

    public static function isRenderer($driver)
    {
        $renderers = [
            'parser',
            'twig',
            'handlebars',
            'mustache',
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

    public static function parseOptions($options)
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

                if (in_array($key, static::validDrivers())) {

                    $drivers[] = [['name' => $key], ['type' => static::isRenderer($key) ? 'renderer' : 'parser'], ['options' => $value]];

                } else {

                    $result[$key] = $value;
                }

            } elseif (is_string($value)) {

                if (in_array($value, static::validDrivers())) {

                    $drivers[] = [['name' => $value], ['type' => static::isRenderer($value) ? 'renderer' : 'parser'], ['options' => []]];

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

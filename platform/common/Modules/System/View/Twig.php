<?php

namespace Common\Modules\System\View;

class Twig
{
    public static function getEnvironmentOptions()
    {
        $result = [
            'debug' => false,
            'charset' => 'UTF-8',
            'base_template_class' => 'Twig_Template',
            'strict_variables' => false,
            'autoescape' => 'html',
            'cache' => false,
            'auto_reload' => null,
            'optimizations' => -1,
        ];

        return $result;
    }

    public static function render($template, $data, $options)
    {
        $parser = new \Twig_Environment(new \Parser_Twig_Loader_Filesystem(),
            static::getEnvironmentOptions()
        );

        $result = $parser->render($template, $data);

        return $result;
    }

    public static function renderString($template, $data, $options)
    {
        $parser = new \Twig_Environment(new \Twig_Loader_Chain(array(new \Parser_Twig_Loader_String, new \Parser_Twig_Loader_Filesystem())),
            static::getEnvironmentOptions()
        );

        $template = $parser->render($template, $data);

        return $result;
    }
}

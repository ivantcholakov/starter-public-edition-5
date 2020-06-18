<?php

namespace Common\Modules\System\View;

class Twig
{
    protected $config;

    public function __construct()
    {
        $this->config = config('Twig')->config;
    }

    public function render($template, $data, $options)
    {
        // Just playing ...

        $directory = pathinfo($template, PATHINFO_DIRNAME);
        $basename = pathinfo($template, PATHINFO_BASENAME);

        $loader = new \Twig\Loader\FilesystemLoader($directory);

        $parser = new \Twig\Environment($loader, array_only(
            $this->config,
            [
                'debug',
                'charset',
                'strict_variables',
                'autoescape',
                'cache',
                'auto_reload',
                'optimizations',
            ]
        ));

        $function = new \Twig\TwigFunction('base_url', function($uri = null) {
            return base_url($uri);
        });

        $parser->addFunction($function);

        $function = new \Twig\TwigFunction('site_url', function($uri = null) {
            return site_url($uri);
        });

        $parser->addFunction($function);

        $result = $parser->render($basename, $data);

        return $result;
    }

    public function renderString($template, $data, $options)
    {
        /*
        $parser = new \Twig_Environment(new \Twig_Loader_Chain(array(new \Parser_Twig_Loader_String, new \Parser_Twig_Loader_Filesystem())),
            static::getEnvironmentOptions()
        );

        $template = $parser->render($template, $data);
        */
        $result = '';
        return $result;
    }
}

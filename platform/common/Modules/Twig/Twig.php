<?php

namespace Common\Modules\Twig;

class Twig
{
    protected $config;

    protected $renderer;

    protected $filesystemLoader;

    public function __construct()
    {
        $this->config = config('Twig')->config;

        $this->filesystemLoader = new \Twig\Loader\FilesystemLoader([]);

        $this->renderer = new \Twig\Environment($this->filesystemLoader, array_only(
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
    }

    public function render($template, $data, $options)
    {
        // Just playing ...

        $directory = pathinfo($template, PATHINFO_DIRNAME);
        $basename = pathinfo($template, PATHINFO_BASENAME);

        $this->filesystemLoader->prependPath($directory);

        $function = new \Twig\TwigFunction('base_url', function($uri = null) {
            return base_url($uri);
        });

        $this->renderer->addFunction($function);

        $function = new \Twig\TwigFunction('site_url', function($uri = null) {
            return site_url($uri);
        });

        $this->renderer->addFunction($function);

        $result = $this->renderer->render($basename, $data);

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

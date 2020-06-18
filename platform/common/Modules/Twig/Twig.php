<?php

namespace Common\Modules\Twig;

class Twig
{
    protected $config;

    protected $renderer;

    public function __construct()
    {
        $this->config = config('Twig')->config;

        $filesystemLoader = $this->createFilesystemLoader();

        $this->renderer = new \Twig\Environment($filesystemLoader, array_only(
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

    public function render($template, array $data = null, array $options = null)
    {
        if (empty($data)) {
            $data = [];
        }

        if (empty($options)) {
            $options = [];
        }

        $options = array_merge_recursive($this->config, $options);
        $paths = $options['paths'] ?? [];
        $filesystemLoader = $this->createFilesystemLoader(array_only($options, 'paths'));
        $this->renderer->setLoader($filesystemLoader);

        $directory = pathinfo($template, PATHINFO_DIRNAME);
        $basename = pathinfo($template, PATHINFO_BASENAME);

        $filesystemLoader->prependPath($directory);

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

    public function renderString($template, array $data = null, array $options = null)
    {
        if (empty($data)) {
            $data = [];
        }

        if (empty($options)) {
            $options = [];
        }

        $options = array_merge_recursive($this->config, $options);
        $paths = $options['paths'] ?? [];
        $filesystemLoader = $this->createFilesystemLoader(array_only($options, 'paths'));
        $this->renderer->setLoader($filesystemLoader);

        $function = new \Twig\TwigFunction('base_url', function($uri = null) {
            return base_url($uri);
        });

        $this->renderer->addFunction($function);

        $function = new \Twig\TwigFunction('site_url', function($uri = null) {
            return site_url($uri);
        });

        $this->renderer->addFunction($function);

        $template = $this->renderer->createTemplate($template);
        $result = $template->render($data);

        return $result;
    }

    public function getRenderer()
    {
        return $this->renderer;
    }

    protected function createFilesystemLoader(array $options = null)
    {
        if (empty($options)) {
            $options = [];
        }

        $loader = new \Twig\Loader\FilesystemLoader([]);

        $paths = $options['paths'] ?? [];

        foreach ($paths as $path) {

            if (is_array($path)) {

                $count = count($path);

                if ($count > 1 && $path[1] == 'prepend') {
                    $loader->prependPath($path[0]);
                } elseif ($count > 0) {
                    $loader->addPath($path[0]);
                }

            } else {

                $loader->addPath($path);
            }
        }

        return $loader;
    }

}

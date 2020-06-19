<?php

namespace Common\Modules\Twig;

class Twig
{
    protected $shared;

    protected $config;

    protected $renderer;

    public function __construct($shared = false)
    {
        $this->shared = !empty($shared);

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

        if ($this->shared) {

            $this->loadExtensions($this->config);
        }
    }

    public function render($template, array $data = null, array $options = null)
    {
        if (empty($data)) {
            $data = [];
        }

        if (empty($options)) {
            $options = [];
        }

        if (isset($options['cache'])) {

            // A name collision.
            unset($options['cache']);
        }

        $options = array_merge_recursive_distinct($this->config, $options);

        $paths = $options['paths'] ?? [];
        $filesystemLoader = $this->createFilesystemLoader(array_only($options, 'paths'));
        $this->renderer->setLoader($filesystemLoader);

        $directory = pathinfo($template, PATHINFO_DIRNAME);
        $basename = pathinfo($template, PATHINFO_BASENAME);

        $filesystemLoader->prependPath($directory);

        if (!$this->shared) {

            $this->loadExtensions($options);
        }


        // TODO: Remove this.
        $function = new \Twig\TwigFunction('base_url', function($uri = null) {
            return base_url($uri);
        });

        $this->renderer->addFunction($function);

        $function = new \Twig\TwigFunction('site_url', function($uri = null) {
            return site_url($uri);
        });
        // /TODO

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

        if (isset($options['cache'])) {

            // A name collision.
            unset($options['cache']);
        }

        $options = array_merge_recursive_distinct($this->config, $options);

        $paths = $options['paths'] ?? [];
        $filesystemLoader = $this->createFilesystemLoader(array_only($options, 'paths'));
        $this->renderer->setLoader($filesystemLoader);

        if (!$this->shared) {

            $this->loadExtensions($options);
        }


        // TODO: Remove this.
        $function = new \Twig\TwigFunction('base_url', function($uri = null) {
            return base_url($uri);
        });

        $this->renderer->addFunction($function);
        // /TODO

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

        $options = $options['paths'] ?? [];

        if (!is_array($options)) {
            $options = [];
        }

        foreach ($options as $path) {

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

    protected function loadExtensions(array $options = null)
    {
        if (empty($options)) {
            $options = [];
        }

        $ext_options = $options['extensions'] ?? [];

        if (!is_array($ext_options)) {
            $ext_options = [];
        }

        $extensions = [];

        foreach ($ext_options as $value) {

            if (is_array($value)) {

                $extensions = array_merge($extensions, $value);

            } else {

                $extension[$value] = true;
            }
        }

        if (!empty($options['debug'])) {
            $extensions['\Twig\Extension\DebugExtension'] = true;
        }

        foreach ($extensions as $extension => $enabled) {

            if ($enabled) {
                $this->renderer->addExtension(new $extension);
            }
        }

        $this->renderer->addExtension(new \Twig\Extension\SandboxExtension(new \Twig\Sandbox\SecurityPolicy(
            !empty($options['sandbox_tags']) && is_array($options['sandbox_tags']) ? $options['sandbox_tags'] : [],
            !empty($options['sandbox_filters']) && is_array($options['sandbox_filters']) ? $options['sandbox_filters'] : [],
            !empty($options['sandbox_methods']) && is_array($options['sandbox_methods']) ? $options['sandbox_methods'] : [],
            !empty($options['sandbox_properties']) && is_array($options['sandbox_properties']) ? $options['sandbox_properties'] : [],
            !empty($options['sandbox_functions']) && is_array($options['sandbox_functions']) ? $options['sandbox_functions'] : []
        )));
    }

}

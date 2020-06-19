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

            $this->loadHelpers($this->config);
            $this->loadExtensions($this->config);
            $this->loadFunctions($this->config);
            $this->loadFilters($this->config);
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

            $this->loadHelpers($options);
            $this->loadExtensions($options);
            $this->loadFunctions($options);
            $this->loadFilters($options);
        }

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

            $this->loadHelpers($options);
            $this->loadExtensions($options);
            $this->loadFunctions($options);
            $this->loadFilters($options);
        }

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

    protected function loadHelpers(array $options = null)
    {
        if (empty($options)) {
            $options = [];
        }

        $helpers = $options['helpers'] ?? [];

        if (!is_array($helpers)) {
            $helpers = [];
        }

        foreach ($helpers as $item) {

            if (is_array($item)) {

                if (empty($item)) {
                    continue;
                }

            } else {

                $item = (string) $item;

                if ($item == '') {
                    continue;
                }
            }

            helper($item);
        }
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

        foreach ($ext_options as $item) {

            if (is_array($item)) {

                $extensions = array_merge($extensions, $item);

            } else {

                $extension[$item] = true;
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

    protected function loadFunctions(array $options = null)
    {
        if (empty($options)) {
            $options = [];
        }

        $functions = $options['functions'] ?? [];

        if (!is_array($functions)) {
            $functions = [];
        }

        foreach ($functions as $item) {

            if (!is_array($item)) {
                $item = array((string) $item);
            }

            $count = count($item);

            if (empty($count)) {
                continue;
            }

            switch ($count) {

                case 1:

                    $this->renderer->addFunction(new \Twig\TwigFunction($item[0], $item[0]));
                    break;

                case 2:

                    $this->renderer->addFunction(new \Twig\TwigFunction($item[0], $item[1]));
                    break;

                case 3:

                    $this->renderer->addFunction(new \Twig\TwigFunction($item[0], $item[1], $item[2]));
                    break;

                default:

                    if ($item[3] !== false) {
                        $this->renderer->addFunction(new \Twig\TwigFunction($item[0], $item[1], $item[2]));
                    }

                    break;
            }
        }
    }

    protected function loadFilters(array $options = null)
    {
        if (empty($options)) {
            $options = [];
        }

        $filters = $options['filters'] ?? [];

        if (!is_array($filters)) {
            $filters = [];
        }

        foreach ($filters as $item) {

            if (!is_array($item)) {
                $item = array((string) $item);
            }

            $count = count($item);

            if (empty($count)) {
                continue;
            }

            switch ($count) {

                case 1:

                    $this->renderer->addFilter(new \Twig\TwigFilter($item[0], $item[0]));
                    break;

                case 2:

                    $this->renderer->addFilter(new \Twig\TwigFilter($item[0], $item[1]));
                    break;

                case 3:

                    $this->renderer->addFilter(new \Twig\TwigFilter($item[0], $item[1], $item[2]));
                    break;

                default:

                    if ($item[3] !== false) {
                        $this->renderer->addFilter(new \Twig\TwigFilter($item[0], $item[1], $item[2]));
                    }

                    break;
            }
        }
    }

}

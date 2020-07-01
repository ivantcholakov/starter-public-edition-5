<?php

namespace Common\Modules\Renderers;

class Twig
{
    protected $renderer;

    public function render($template, $data = null, array $options = null)
    {
        $template = (string) $template;

        if (is_object($data)) {
            $data = get_object_vars($data);
        }

        if (empty($data) || !is_array($data)) {
            $data = [];
        }

        if (empty($options)) {
            $options = [];
        }

        $config = config('Twig')->config;
        $options = array_merge_recursive_distinct($config, $options);
        unset($config);

        $paths = $options['paths'] ?? [];
        $filesystemLoader = $this->createFilesystemLoader(array_only($options, 'paths'));

        $directory = pathinfo($template, PATHINFO_DIRNAME);
        $basename = pathinfo($template, PATHINFO_BASENAME);

        $filesystemLoader->prependPath($directory);

        $this->renderer = new \Twig\Environment($filesystemLoader, array_only(
            $options, [
                'debug',
                'charset',
                'strict_variables',
                'autoescape',
                'cache',
                'auto_reload',
                'optimizations',
            ]
        ));

        $this->loadHelpers($options);
        $this->loadExtensions($options);
        $this->loadFunctions($options);
        $this->loadFilters($options);
        $this->loadTests($options);
        $this->loadGlobals($options);

        return $this->renderer->render($basename, $data);
    }

    public function renderString($template, $data = null, array $options = null)
    {
        $template = (string) $template;

        if (is_object($data)) {
            $data = get_object_vars($data);
        }

        if (empty($data) || !is_array($data)) {
            $data = [];
        }

        if (empty($options)) {
            $options = [];
        }

        $config = config('Twig')->config;
        $options = array_merge_recursive_distinct($config, $options);
        unset($config);

        $paths = $options['paths'] ?? [];
        $filesystemLoader = $this->createFilesystemLoader(array_only($options, 'paths'));

        $this->renderer = new \Twig\Environment($filesystemLoader, array_only(
            $options, [
                'debug',
                'charset',
                'strict_variables',
                'autoescape',
                'cache',
                'auto_reload',
                'optimizations',
            ]
        ));

        $this->loadHelpers($options);
        $this->loadExtensions($options);
        $this->loadFunctions($options);
        $this->loadFilters($options);
        $this->loadTests($options);
        $this->loadGlobals($options);

        $template = $this->renderer->createTemplate($template);

        return $template->render($data);
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

                $extensions[$item] = true;
            }
        }

        if (!empty($options['debug'])) {
            $extensions['\Twig\Extension\DebugExtension'] = true;
        }

        foreach ($extensions as $extension => $enabled) {

            if (!is_string($extension)) {
                continue;
            }

            if (!empty($enabled)) {
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

        $loadedFunctions = [];

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
                    $loadedFunctions[] = $item[0];
                    break;

                case 2:

                    $this->renderer->addFunction(new \Twig\TwigFunction($item[0], $item[1]));
                    $loadedFunctions[] = $item[0];
                    break;

                case 3:

                    $this->renderer->addFunction(new \Twig\TwigFunction($item[0], $item[1], $item[2]));
                    $loadedFunctions[] = $item[0];
                    break;

                default:

                    if ($item[3] !== false) {
                        $this->renderer->addFunction(new \Twig\TwigFunction($item[0], $item[1], $item[2]));
                        $loadedFunctions[] = $item[0];
                    }

                    break;
            }
        }

        if (!empty($options['debug'])) {

            if (!in_array('print_d', $loadedFunctions)) {
                $this->renderer->addFunction(new \Twig\TwigFunction('print_d', 'print_d', ['is_safe' => ['html']]));
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

    protected function loadTests(array $options = null)
    {
        if (empty($options)) {
            $options = [];
        }

        $tests = $options['tests'] ?? [];

        if (!is_array($tests)) {
            $tests = [];
        }

        foreach ($tests as $item) {

            if (!is_array($item)) {
                $item = array((string) $item);
            }

            $count = count($item);

            if ($count == 0) {
                continue;
            }

            switch ($count) {

                case 1:

                    $this->renderer->addTest(new \Twig\TwigTest($item[0], $item[0]));
                    break;

                case 2:

                    $this->renderer->addTest(new \Twig\TwigTest($item[0], $item[1]));
                    break;

                case 3:

                    $this->renderer->addTest(new \Twig\TwigTest($item[0], $item[1], $item[2]));
                    break;

                default:

                    if ($item[3] !== false) {
                        $this->renderer->addTest(new \Twig\TwigTest($item[0], $item[1], $item[2]));
                    }

                    break;
            }
        }
    }

    protected function loadGlobals(array $options = null)
    {
        if (empty($options)) {
            $options = [];
        }

        $globals = $options['globals'] ?? [];

        if (!is_array($globals)) {
            $globals = [];
        }

        foreach ($globals as $item) {

            if (!is_array($item)) {
                continue;
            }

            $count = count($item);

            if ($count < 2) {
                continue;
            }

            if (!is_string($item[0]) || $item[0] == '') {
                continue;
            }

            $this->renderer->addGlobal($item[0], $item[1]);
        }
    }

}

<?php

namespace Common\Modules\System\View;

class DriverManager
{
    protected static $sharedConfig = [];

    public function __construct()
    {
        if (empty(self::$sharedConfig)) {

            $this->loadValidDrivers();
            $this->loadDriverTypes();
            $this->loadFileExtensions();
            $this->loadDriverClasses();
        }
    }

    protected function loadValidDrivers()
    {
        $config = config('Views')->config;

        $options = $config['validDrivers'] ?? [];

        if (empty($options)) {
            $options = [];
        }

        if (!is_array($options)) {
            $options = [$options];
        }

        $items = [];

        foreach ($options as $item) {

            if (is_array($item)) {

                $items = array_merge($items, $item);

            } else {

                $items[$item] = true;
            }
        }

        $result = [];

        foreach ($items as $item => $enabled) {

            if (!is_string($item)) {
                continue;
            }

            if (!empty($enabled)) {
                $result[] = $item;
            }
        }

        self::$sharedConfig['validDrivers'] = $result;
    }

    protected function loadDriverTypes()
    {
        $config = config('Views')->config;

        $options = $config['driverTypes'] ?? [];

        if (empty($options)) {
            $options = [];
        }

        $result = [];

        foreach ($options as $key => $value) {

            if (!is_string($key) && !is_string($value)) {
                continue;
            }

            if (!in_array($key, self::$sharedConfig['validDrivers'])) {
               continue;
            }

            $result[$key] = $value;
        }

        self::$sharedConfig['driverTypes'] = $result;
    }

    protected function loadFileExtensions()
    {
        $config = config('Views')->config;

        $options = $config['fileExtensions'] ?? [];

        if (empty($options)) {
            $options = [];
        }

        $result = [];

        foreach ($options as $key => $value) {

            if (!is_string($key)) {
                continue;
            }

            if (!in_array($key, self::$sharedConfig['validDrivers'])) {
               continue;
            }

            if (!is_array($value)) {
                $value = [$value];
            }

            foreach ($value as & $item) {
                $item = ltrim($item, '.');
            }

            unset($item);

            $result[$key] = $value;
        }

        self::$sharedConfig['fileExtensions'] = $result;
    }

    protected function loadDriverClasses()
    {
        $config = config('Views')->config;

        $options = $config['driverClasses'] ?? [];

        if (empty($options)) {
            $options = [];
        }

        $result = [];

        foreach ($options as $key => $value) {

            if (!is_string($key) && !is_string($value)) {
                continue;
            }

            if (!in_array($key, self::$sharedConfig['validDrivers'])) {
               continue;
            }

            $result[$key] = $value;
        }

        self::$sharedConfig['driverClasses'] = $result;
    }

    public function getValidDrivers() {

        return self::$sharedConfig['validDrivers'];
    }

    public function isValidDriver($driverName) {

        return in_array((string) $driverName, self::$sharedConfig['validDrivers']);
    }

    public function getDriverTypes()
    {
        return self::$sharedConfig['driverTypes'];
    }

    public function getDriverType($driverName)
    {
        $driverName = (string) $driverName;

        return isset(self::$sharedConfig['driverTypes'][$driverName])
            ? self::$sharedConfig['driverTypes'][$driverName]
            : null;
    }

    public function getFileExtensions($driverName = null, $flat = false)
    {
        $driverName = (string) $driverName;

        if ($driverName == '') {

            if ($flat) {

                $result = [];

                foreach (self::$sharedConfig['fileExtensions'] as $key => $extensions) {

                    foreach ($extensions as $extension) {
                        $result[] = $extension;
                    }
                }

                return $result;
            }

            return self::$sharedConfig['fileExtensions'];
        }

        return isset(self::$sharedConfig['fileExtensions'][$driverName])
           ? self::$sharedConfig['fileExtensions'][$driverName]
           : [];
    }

    public function hasFileExtension($driverName)
    {
        $extensions = $this->getFileExtensions($driverName);

        return !empty($extensions);
    }

    public function getDriversByFileExtensions($extension = null)
    {
        static $drivers = null;

        if ($drivers === null) {

            $drivers = [];
            $allExtensions = $this->getFileExtensions();

            foreach ($allExtensions as $driverName => $extensions) {

                foreach ($extensions as $ext) {
                    $drivers[$ext] = $driverName;
                }
            }
        }

        if ($extension != '') {

            return $drivers[$extension] ?? null;
        }

        return $drivers;
    }

    public function getDriverClasses()
    {
        return self::$sharedConfig['driverClasses'];
    }

    public function getDriverClass($driverName)
    {
        $driverName = (string) $driverName;

        return isset(self::$sharedConfig['driverClasses'][$driverName])
            ? self::$sharedConfig['driverClasses'][$driverName]
            : null;
    }

    protected function detectDriverFromFilename(string $view)
    {
        $detectedDriverName = null;
        $detectedExtension = null;
        $detectedViewName = null;

        $detectedDriver = [
            'view' => & $view,
            'detectedDriverName' => & $detectedDriverName,
            'detectedViewName' => & $detectedViewName,
            'detectedExtension' => & $detectedExtension,
        ];

        $drivers = $this->getDriversByFileExtensions();

        foreach ($drivers as $key => $value) {

            $k = preg_quote($key);

            if (preg_match('/.*\.('.$k.')$/', $view, $matches)) {

                $detectedExtension = $matches[1];
                $detectedViewName = preg_replace('/(.*)\.'.$k.'$/', '$1', $view);
                $detectedDriverName = $value;

                return $detectedDriver;
            }
        }

        $detectedExtension = pathinfo($view, PATHINFO_EXTENSION);
        $detectedViewName = pathinfo($view, PATHINFO_FILENAME);

        return $detectedDriver;
    }

    public function parseDriverOptions($options)
    {
        if (!is_array($options)) {

            $options = (string) $options;
            $options = $options != '' ? [$options] : [];
        }

        $driverOptions = [];

        if (!empty($options)) {

            foreach ($options as $key => $value) {

                if (is_string($key)) {

                    if (in_array($key, self::$sharedConfig['validDrivers'])) {

                        $driverOptions[] = [
                            'name' => $key,
                            'type' => $this->getDriverType($key),
                            'hasFileExtension' => $this->hasFileExtension($key),
                            'options' => $value
                        ];

                    } else {

                        $driverOptions[$key] = $value;
                    }

                } elseif (is_string($value)) {

                    if (in_array($value, self::$sharedConfig['validDrivers'])) {

                        $driverOptions[] = [
                            'name' => $value,
                            'type' => $this->getDriverType($value),
                            'hasFileExtension' => $this->hasFileExtension($value),
                            'options' => []
                        ];

                    } else {

                        $driverOptions[] = $value;
                    }
                }
            }
        }

        return $driverOptions;
    }

    protected function findView($fileName, $extensions, string $viewPath, $loader)
    {
        $result = [];

        $view = null;
        $file = null;
        $found = false;

        foreach ($extensions as $extension) {

            $view = $fileName.'.'.$extension;

            $file = $viewPath . $view;

            if (!is_file($file)) {
                $file = $loader->locateFile($view, 'Views', $extension);
            }

            if ($file != '') {

                // locateFile will return an empty string if the file cannot be found.
                $found = true;
                break;
            }
        }

        if (!$found) {
            throw \CodeIgniter\View\Exceptions\ViewException::forInvalidFile((string) $fileName);
        }

        $driverName = $extension != 'php'
            ? $this->getDriversByFileExtensions($extension)
            : 'php';

        $result['name'] = $driverName;
        $result['type'] = $driverName != 'php' ? $this->getDriverType($driverName) : 'renderer';
        $result['hasFileExtension'] = $driverName != 'php' ? $this->hasFileExtension($driverName) : true;
        $result['options'] = [];
        $result['view'] = $fileName;
        $result['viewName'] = $view;
        $result['extension'] = $extension;
        $result['file'] = $file;
        $result['path'] = rtrim(str_replace('\\', '/', realpath(dirname($result['file']))), '/').'/';
        $result['target'] = 'view';

        return $result;
    }

    public function getDriverChain(string $target, array $options = null, string $view = null, string $viewPath = null, $loader = null)
    {
        if (!in_array($target, ['view', 'string'])) {
            throw new \InvalidArgumentException('The $target argument should be \'view\' or \'string\'.');
        }

        if ($target == 'view') {

            if (is_null($viewPath)) {

                $paths = config('Paths');

                $viewPath = $paths->viewDirectory;
                $viewPath = rtrim($viewPath, '/ ') . '/';
            }

            $loader = is_null($loader) ? Services::locator() : $loader;

        } else {

            // Clear non-relevant parameters, just in case.
            $view = null;
            unset($viewPath);
            unset($loader);
        }

        $list = $this->parseDriverOptions($options);

        if ($target == 'view') {

            if (empty($list)) {

                $list[] = $this->findView(
                    pathinfo($view, PATHINFO_FILENAME),
                    array_merge(['php'], $this->getFileExtensions(null, true)),
                    $viewPath,
                    $loader
                );

            } else {

                if (!$list[0]['hasExtension']) {

                    $list = array_merge(
                        $this->findView(
                            pathinfo($view, PATHINFO_FILENAME),
                            array_merge(['php'], $this->getFileExtensions(null, true)),
                            $viewPath,
                            $loader
                        ),
                        $list
                    );

                } else {

                    $detectedDriver = $this->detectDriverFromFilename($view);
                    $detectedDriverName = $detectedDriver['detectedDriverName'];
                    $detectedViewName = $detectedDriver['detectedViewName'];
                    $detectedExtension = $detectedDriver['detectedExtension'];

                    if ($detectedDriverName !=  '' && $detectedDriverName != $list[0]['name']) {

                        // Filename and options target different drivers.
                        throw \CodeIgniter\View\Exceptions\ViewException\ViewException::forInvalidFile((string) $view);
                    }

                    $list[0] = $this->findView(
                        pathinfo($view, PATHINFO_FILENAME),
                        $detectedDriverName != '' && $detectedExtension != ''
                            ? [$detectedExtension]
                            : $this->getFileExtensions($list[0]['name']),
                        $viewPath,
                        $loader
                    );
                }
            }
        }

        foreach ($list as & $item) {

            if (!isset($item['target']) || $item['target'] == 0) {
                $item['target'] = 'string';
            }
        }

        unset($item);

        return $list;
    }

    public function createRenderer($driverName)
    {
        $driverName = (string) $driverName;

        if ($driverName == '') {
            throw new \InvalidArgumentException('No renderer-driver name has been provided.');
        }

        if (!in_array($driverName, self::$sharedConfig['validDrivers'])) {
            throw new \InvalidArgumentException('Invalid renderer-driver name has been provided.');
        }

        if ($driverName == 'php') {

            return new \Common\Modules\System\View\PHP();
        }

        $class = (string) $this->getDriverClass($driverName);

        if ($class == '') {
            throw new \RuntimeException('No class name of renderer-driver has been configured.');
        }

        return new $class();
    }

}

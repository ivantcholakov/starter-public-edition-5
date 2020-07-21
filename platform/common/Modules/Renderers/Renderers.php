<?php

namespace Common\Modules\Renderers;

class Renderers
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
        $config = config('Renderers')->config;

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
        $config = config('Renderers')->config;

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
        $config = config('Renderers')->config;

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
        $config = config('Renderers')->config;

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
        if (is_object($options)) {
            $options = get_object_vars($options);
        }

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

            $e = '.'.$extension;

            if (strlen($fileName) > strlen($e) && substr_compare($fileName, $e, -strlen($e)) === 0) {

                $fileName = substr($fileName, 0, -strlen($e));
                $extensions = [$extension];
                break;
            }
        }

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

        $ext = pathinfo($file, PATHINFO_EXTENSION);

        if ($ext == 'php') {

            $driverName = 'php';
            $driverType = 'renderer';
            $hasFileExtension = true;
            $extension = 'php';

        } else {

            $driverName = $this->getDriversByFileExtensions($extension);

            if ($driverName != '') {

                $driverType = $this->getDriverType($driverName);
                $hasFileExtension = $this->hasFileExtension($driverName);

            } else {

                $driverName = 'copy';
                $driverType = 'parser';
                $hasFileExtension = false;
                $extension = $ext;
            }
        }

        $result['name'] = $driverName;
        $result['type'] = $driverType;
        $result['hasFileExtension'] = $hasFileExtension;
        $result['options'] = [];
        $result['view'] = $fileName;
        $result['viewName'] = $view;
        $result['extension'] = $extension;
        $result['file'] = $file;
        $result['path'] = rtrim(str_replace('\\', '/', realpath(dirname($result['file']))), '/').'/';
        $result['target'] = 'view';

        return $result;
    }

    public function getDriverChain(string $target, $options = null, string $view = null, string $viewPath = null, $loader = null)
    {
        if (!in_array($target, ['view', 'string'])) {

            throw new \InvalidArgumentException('The $target argument should be \'view\' or \'string\'.');
        }

        $list = $this->parseDriverOptions($options);

        if ($target == 'view') {

            if (is_null($viewPath)) {

                if (!empty($list) && !empty($list[0]['options']['full_path']) && $view != '') {

                    $viewPath = pathinfo($view, PATHINFO_DIRNAME);
                    $view = pathinfo($view, PATHINFO_BASENAME);

                } else {

                    $viewPath = config('Paths')->viewDirectory;
                }
            }

            $viewPath = rtrim($viewPath, '/ ') . '/';

            $loader = is_null($loader) ? \Config\Services::locator() : $loader;

            if (empty($list)) {

                $list[] = $this->findView(
                    //pathinfo($view, PATHINFO_FILENAME),
                    $view,
                    array_merge(['php'], $this->getFileExtensions(null, true)),
                    $viewPath,
                    $loader
                );

            } else {

                if (!$list[0]['hasFileExtension']) {

                    $provided_extension = trim(pathinfo($view, PATHINFO_EXTENSION));

                    $list = array_merge(
                        [$this->findView(
                            //pathinfo($view, PATHINFO_FILENAME),
                            $view,
                            array_merge([$provided_extension != '' ? $provided_extension : 'php'], $this->getFileExtensions(null, true)),
                            $viewPath,
                            $loader
                        )],
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

                    $_options = $list[0]['options'];

                    $list[0] = $this->findView(
                        //pathinfo($view, PATHINFO_FILENAME),
                        $view,
                        $detectedDriverName != '' && $detectedExtension != ''
                            ? [$detectedExtension]
                            : $this->getFileExtensions($list[0]['name']),
                        $viewPath,
                        $loader
                    );

                    $list[0]['options'] = $_options;
                    unset($_options);
                }
            }
        }

        if (!empty($list)) {

            foreach ($list as & $item) {

                if (!isset($item['target']) || $item['target'] == '') {
                    $item['target'] = 'string';
                }
            }

            unset($item);

            $list[0]['first'] = true;
        }

        return $list;
    }

    public function createRenderer($driverName)
    {
        $driverName = (string) $driverName;

        if ($driverName == '') {
            throw new \InvalidArgumentException('No renderer-driver name has been provided.');
        }

        if ($driverName == 'php') {

            return new \Common\Modules\Renderers\PHP();
        }

        if ($driverName == 'copy') {

            return new \Common\Modules\Renderers\Copy();
        }

        if (!in_array($driverName, self::$sharedConfig['validDrivers'])) {

            throw new \InvalidArgumentException('Invalid renderer-driver name has been provided.');
        }

        $class = (string) $this->getDriverClass($driverName);

        if ($class == '') {

            throw new \RuntimeException('No class name of renderer-driver has been configured.');
        }

        return new $class();
    }

}

<?php

namespace Common\Modules\System\View;

class Driver
{
    public static function validDrivers()
    {
        // TODO: Get this from a configuration file.
        $result = [
            'twig',
//            'parser',
//            'handlebars',
//            'mustache',
//            'markdown',
//            'textile',
        ];

        return $result;
    }

    public static function Type($driverName)
    {
        static $types = null;

        if ($types === null) {

            // TODO: Get this from a configuration file.
            $types = [
                'twig' => 'renderer',
                'parser' => 'renderer',
                'handlebars' => 'renderer',
                'mustache' => 'renderer',
                'markdown' => 'parser',
                'textile' => 'parser',
            ];
        }

        $driverName = (string) $driverName;

        return isset($types[$driverName]) ? $types[$driverName] : null;
    }

    public static function getFileExtensions($driverName = null)
    {
        static $extensions = null;

        if ($extensions === null) {

            $extensions = [];

            // TODO: Get this from a configuration file.
            $configuredExtensions = [
                'twig' => ['html.twig', 'twig'],
                'parser' => 'parser',
                'handlebars' => ['handlebars', 'hbs'],
                'mustache' => 'mustache',
                'markdown' => ['md', 'markdown', 'fbmd'],
                'textile' => 'textile',
            ];

            $validDrivers = static::validDrivers();

            foreach ($configuredExtensions as $key => $value) {

                if (!in_array($key, $validDrivers)) {
                   continue;
                }

                if (!is_array($value)) {
                    $value = (array) $value;
                }

                foreach ($value as & $item) {
                    $item = ltrim($item, '.');
                }

                unset($item);

                $extensions[$key] = $value;
            }
        }

        $driverName = (string) $driverName;

        if ($driverName == '') {

            return $extensions;
        }

        return isset($extensions[$driverName]) ? $extensions[$driverName] : [];
    }

    public static function hasFileExtension($driverName)
    {
        $extensions = static::getFileExtensions($driverName);

        return !empty($extensions);
    }

    public static function getDriversByFileExtensions($extension = null)
    {
        static $drivers = null;

        if ($drivers === null) {

            $drivers = [];
            $allExtensions = static::getFileExtensions();

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

    public static function detect($fileName, & $detectedExtension = null, & $detectedFilename = null)
    {
        static $drivers = null;

        if ($drivers === null) {

            $drivers = static::getDriversByFileExtensions();
        }

        $fileName = (string) $fileName;
        $detectedExtension = null;
        $detectedFilename = null;

        // Test whether a pure extension was given.
        if (isset($drivers[$fileName])) {

            $detectedExtension = $fileName;

            return $drivers[$fileName];
        }

        foreach ($drivers as $key => $value) {

            $k = preg_quote($key);

            if (preg_match('/.*\.('.$k.')$/', $fileName, $matches)) {

                $detectedExtension = $matches[1];
                $detectedFilename = preg_replace('/(.*)\.'.$k.'$/', '$1', pathinfo($fileName, PATHINFO_BASENAME));

                return $value;
            }
        }

        $detectedExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $detectedFilename = pathinfo($fileName, PATHINFO_FILENAME);

        return null;
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

                    $drivers[] = ['name' => $key, 'type' => static::Type($key), 'hasFileExtension' => static::hasFileExtension($key), 'options' => $value];

                } else {

                    $result[$key] = $value;
                }

            } elseif (is_string($value)) {

                if (in_array($value, static::validDrivers())) {

                    $drivers[] = ['name' => $value, 'type' => static::Type($value), 'hasFileExtension' => static::hasFileExtension($value), 'options' => []];

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

    public static function parseViewOptions(string $view, array $options = null, bool $saveData = null)
    {
        $originalOptions = $options;
        $options = static::parseOptions($options);
        $driverChain = !empty($options['drivers']) ? $options['drivers'] : [];

        // This is to be the first driver from the chain.
        $driver = null;
        $driverName = null;

        if (!empty($driverChain)) {

            if ($driverChain[0]['hasFileExtension']) {

                $driver = $driverChain[0];
                $driverName = $driver['name'];
                $driverChain = array_slice($driverChain, 1);
            }
        }

        $viewExtension = pathinfo($view, PATHINFO_EXTENSION);
        $viewHasExtension = $viewExtension != '' && $viewExtension != 'html';

        $detectedExtension = null;
        $detectedFilename = null;
        $detectedDriverName = static::detect($view, $detectedExtension, $detectedFilename);

        if (
            $viewHasExtension
            &&
            $detectedDriverName != ''
            &&
            $driverName != ''
            &&
            $detectedDriverName != $driverName
        ) {

            // Filename and options target different drivers.
            throw \CodeIgniter\View\Exceptions\ViewException\ViewException::forInvalidFile($view);
        }

        $fileName = $detectedFilename;

        if ($detectedDriverName != '' && $detectedExtension != '') {

            $extensions = [$detectedExtension];

            if ($driverName == '') {
                $driver = ['name' => $detectedDriverName, 'type' => static::Type($detectedDriverName), 'hasFileExtension' => static::hasFileExtension($detectedDriverName), 'options' => []];
            }

        } elseif ($driverName != '') {

            $extensions = static::getFileExtensions($driverName);

        } else {

            $extensions = [];

            $allExtensions = static::getFileExtensions();

            foreach ($allExtensions as $key => $value) {

                foreach ($value as $ext) {
                    $extensions[] = $ext;
                }
            }

            $extensions[] = 'php';
        }

        $result = compact(
            'originalOptions',
            'options',
            'saveData',
            'driverChain',
            'driver',
            'fileName',
            'extensions'
        );

        return $result;
    }

}

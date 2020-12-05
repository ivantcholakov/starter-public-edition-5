<?php

namespace Common\Modules\Renderers\TwigExtension;

/**
 * This is an integration class for CodeIgniter.
 *
 * @author Ivan Tcholakov <ivantcholakov@gmail.com>, 2020
 * @license The MIT License, http://opensource.org/licenses/MIT
 */

class SessionExtension {

    public static function session() {

        $args = func_get_args();

        if (count($args) < 1) {

            return null;
        }

        $name = $args[0];

        $name = trim(@ (string) $name);

        if ($name == '') {

            return null;
        }

        $session = \Config\Services::session();

        if (count($args) == 1) {

            if (self::isBlacklisted($name)) {

                return null;
            }

            return $session->get($name);
        }

        if (self::isBlacklisted($name) || self::isReadOnly($name)) {

            return null;
        }

        $session->set($name,  $args[1]);

        return null;
    }

    public static function session_flash() {

        $args = func_get_args();

        if (count($args) < 1) {

            return null;
        }

        $name = $args[0];

        $name = trim(@ (string) $name);

        if ($name == '') {

            return null;
        }

        $session = \Config\Services::session();

        if (count($args) == 1) {

            if (self::isBlacklisted($name)) {

                return null;
            }

            return $session->getFlashdata($name);
        }

        if (self::isBlacklisted($name) || self::isReadOnly($name)) {

            return null;
        }

        $session->setFlashdata($name,  $args[1]);

        return null;
    }

    public static function session_temp() {

        $args = func_get_args();

        if (count($args) < 1) {

            return null;
        }

        $name = $args[0];

        $name = trim(@ (string) $name);

        if ($name == '') {

            return null;
        }

        $session = \Config\Services::session();

        if (count($args) == 1) {

            if (self::isBlacklisted($name)) {

                return null;
            }

            return $session->getTempdata($name);
        }

        if (self::isBlacklisted($name) || self::isReadOnly($name)) {

            return null;
        }

        $ttl = isset($args[2]) ? ($args[2] != '' && is_numeric($args[2]) ? $args[2] : 300) : 300;

        $session->setTempdata($name,  $args[1], $ttl);

        return null;
    }

    protected static function isBlacklisted(string $name) {

        return self::isListed($name, 'sessionBlacklist');
    }

    protected static function isReadOnly(string $name) {

        return self::isListed($name, 'sessionReadOnly');
    }

    protected static function isListed(string $name, string $listName) {

        static $list;

        if ($list === null) {

            $config = config('Renderers')->config;
            $list = $config[$listName] ?? [];

            if (!is_array($list)) {
                $list = [];
            }
        }

        if (empty($list)) {

            return false;
        }

        if ($name == '') {

            return true;
        }

        if (in_array($name, $list)) {

            return true;
        }

        foreach ($list as $item) {

            if (strpos($item, $name) === 0) {

                return true;
            }
        }

        return false;
    }

}

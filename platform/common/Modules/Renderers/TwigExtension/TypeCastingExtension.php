<?php

namespace Common\Modules\Renderers\TwigExtension;

/**
 * This is an integration class for CodeIgniter.
 *
 * @author Ivan Tcholakov <ivantcholakov@gmail.com>, 2016-2020
 * @license The MIT License, http://opensource.org/licenses/MIT
 */

class TypeCastingExtension {

    public static function boolean($value) {

        return (bool) $value;
    }

    public static function integer($value) {

        return (int) $value;
    }

    public static function float($value) {

        return (float) $value;
    }

    public static function string($value) {

        return (string) $value;
    }

    public static function twig_array($value) {

        return (array) $value;
    }

    public static function object($value) {

        return (object) $value;
    }

    public static function null($value) {

        return null;
    }

}

<?php

namespace Common\Modules\Renderers\TwigExtension;

/**
 * @author Ivan Tcholakov <ivantcholakov@gmail.com>, 2020
 * @license The MIT License, http://opensource.org/licenses/MIT
 */

class FormatExtension {

    public static function markdown($text) {

        return render_string(trim($text), null, 'markdown');
    }

    public static function textile($text) {

        return render_string(trim($text), null, 'textile');
    }

}

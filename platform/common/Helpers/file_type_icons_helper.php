<?php

if (!function_exists('file_type_icon')) {

    function file_type_icon($path = null) {

        static $_icons;

        if (!isset($_icons)) {

            $icons = config('FileTypeIcons')->icons;

            $_icons = [];

            if (!empty($icons)) {

                foreach ($icons as $key => $icon) {

                    if (is_array($icon)) {

                        foreach ($icon as $i) {
                            $_icons[(string) $i] = $key;
                        }

                    } else {

                        $_icons[(string) $icon] = $key;
                    }
                }
            }
        }

        if ($path === null) {
            return $_icons;
        }

        $ext = extension($path);

        if (isset($_icons[$ext])) {
            return $_icons[$ext];
        }

        return null;
    }
}

if (!function_exists('file_type_icon_fa')) {

    function file_type_icon_fa($path) {

        $result = file_type_icon($path);

        if (is_array($result)) {

            foreach ($result as $key => & $value) {
                $value = 'fa-file-'.$value;
            }

            return $result;
        }

        if ($result == '') {
            return 'fa-file';
        }

        return 'fa-file-'.$result;
    }
}

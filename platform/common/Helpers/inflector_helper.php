<?php

if (! function_exists('humanize'))
{
    /**
     * Humanize
     *
     * Takes multiple words separated by the separator,
     * camelizes and changes them to spaces
     *
     * @param  string $string    Input string
     * @param  string $separator Input separator
     * @return string
     */
    function humanize(string $string, string $separator = '_'): string
    {
        return UTF8::ucwords(
            preg_replace('/[' . $separator . ']+/u', ' ', UTF8::strtolower(trim($string)))
        );
    }
}

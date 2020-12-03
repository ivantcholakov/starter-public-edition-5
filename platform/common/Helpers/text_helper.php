<?php

/**
 * UTF-8 alternatives to CodeIgniter's text helper functions
 * @author Ivan Tcholakov <ivantcholakov@gmail.com>, 2013-2020
 * @license The MIT License, http://opensource.org/licenses/MIT
 */

if (! function_exists('character_limiter')) {

    /**
     * Character Limiter, UTF-8 version.
     *
     * Limits the string based on the character count.  Preserves complete words
     * so the character count may not be exactly as specified.
     *
     * @param string  $str
     * @param integer $n
     * @param string  $end_char the end character. Usually an ellipsis
     *
     * @return string
     */
    function character_limiter(string $str, int $n = 500, string $end_char = '&#8230;'): string {

        if (UTF8::strlen($str) < $n) {
            return $str;
        }

        $end_char = html_entity_decode($end_char, ENT_QUOTES, 'UTF-8');

        // a bit complicated, but faster than preg_replace with \s+
        //$str = preg_replace('/ {2,}/', ' ', str_replace(["\r", "\n", "\t", "\x0B", "\x0C"], ' ', $str));
        $str = preg_replace('/\s+/u', ' ', $str);

        if (UTF8::strlen($str) <= $n) {
            return $str;
        }

        $out = '';

        foreach (explode(' ', trim($str)) as $val) {

            $out .= $val . ' ';

            if (UTF8::strlen($out) >= $n) {
                $out = trim($out);
                break;
            }
        }

        return (UTF8::strlen($out) === UTF8::strlen($str)) ? $out : $out.$end_char;
    }
}

if (! function_exists('convert_accented_characters')) {

    /**
     * Convert Accented Foreign Characters to ASCII
     *
     * @param string $str Input string
     *
     * @return string
     */
    function convert_accented_characters(string $str, $locale = null): string {

        $locale = (string) $locale;

        if ($locale == '') {
            $locale = config('App')->defaultLocale;
        }

        // See https://github.com/ivantcholakov/transliterate
        return Transliterate::to_ascii($str, $locale);
    }

}

if (! function_exists('ellipsize'))
{
    /**
     * Ellipsize String (UTF-8 compatible version)
     *
     * This function will strip tags from a string, split it at its max_length and ellipsize
     *
     * @param string  $str        String to ellipsize
     * @param integer $max_length Max length of string
     * @param mixed   $position   int (1|0) or float, .5, .2, etc for position to split
     * @param string  $ellipsis   ellipsis ; Default '...'
     *
     * @return string    Ellipsized string
     */
    function ellipsize(string $str, int $max_length, $position = 1, string $ellipsis = '&hellip;'): string
    {
        // Strip tags
        $str = trim(strip_tags($str));

        // Added by Ivan Tcholakov, 08-FEB-2016.
        $ellipsis = html_entity_decode($ellipsis, ENT_QUOTES, 'UTF-8');
        //

        // Added by Ivan Tcholakov, 07-JAN-2014.
        $str = html_entity_decode($str, ENT_QUOTES, 'UTF-8');
        //

        // Is the string long enough to ellipsize?
        if (UTF8::strlen($str) <= $max_length)
        {
            return $str;
        }

        $beg = UTF8::substr($str, 0, floor($max_length * $position));
        $position = ($position > 1) ? 1 : $position;

        if ($position === 1)
        {
            $end = UTF8::substr($str, 0, -($max_length - UTF8::strlen($beg)));
        }
        else
        {
            $end = UTF8::substr($str, -($max_length - UTF8::strlen($beg)));
        }

        return $beg.$ellipsis.$end;
    }
}

if (! function_exists('word_wrap'))
{
    /**
     * Word Wrap
     *
     * Wraps text at the specified character. Maintains the integrity of words.
     * Anything placed between {unwrap}{/unwrap} will not be word wrapped, nor
     * will URLs.
     *
     * @param string  $str     the text string
     * @param integer $charlim = 76    the number of characters to wrap at
     *
     * @return string
     */
    function word_wrap(string $str, int $charlim = 76): string
    {
        // Set the character limit
        is_numeric($charlim) || $charlim = 76;

        // Reduce multiple spaces
        $str = preg_replace('| +|u', ' ', $str);

        // Standardize newlines
        if (strpos($str, "\r") !== false)
        {
            $str = str_replace(["\r\n", "\r"], "\n", $str);
        }

        // If the current word is surrounded by {unwrap} tags we'll
        // strip the entire chunk and replace it with a marker.
        $unwrap = [];

        if (preg_match_all('|\{unwrap\}(.+?)\{/unwrap\}|su', $str, $matches))
        {
            for ($i = 0, $c = count($matches[0]); $i < $c; $i ++)
            {
                $unwrap[] = $matches[1][$i];
                $str      = str_replace($matches[0][$i], '{{unwrapped' . $i . '}}', $str);
            }
        }

        // Use PHP's native function to do the initial wordwrap.
        // We set the cut flag to FALSE so that any individual words that are
        // too long get left alone. In the next step we'll deal with them.
        $str = UTF8::wordwrap($str, $charlim, "\n", false);

        // Split the string into individual lines of text and cycle through them
        $output = '';

        foreach (explode("\n", $str) as $line)
        {
            // Is the line within the allowed character count?
            // If so we'll join it to the output and continue
            if (UTF8::strlen($line) <= $charlim)
            {
                $output .= $line . "\n";
                continue;
            }

            $temp = '';

            while (UTF8::strlen($line) > $charlim)
            {
                // If the over-length word is a URL we won't wrap it
                if (preg_match('!\[url.+\]|://|www\.!', $line))
                {
                    break;
                }

                // Trim the word down
                $temp .= UTF8::substr($line, 0, $charlim - 1);
                $line = UTF8::substr($line, $charlim - 1);
            }

            // If $temp contains data it means we had to split up an over-length
            // word into smaller chunks so we'll add it back to our current line
            if ($temp !== '')
            {
                $output .= $temp . "\n" . $line . "\n";
            }
            else
            {
                $output .= $line . "\n";
            }
        }

        // Put our markers back
        if (! empty($unwrap))
        {
            foreach ($unwrap as $key => $val)
            {
                $output = str_replace('{{unwrapped' . $key . '}}', $val, $output);
            }
        }

        // remove any trailing newline
        $output = rtrim($output);

        return $output;
    }

}

if (! function_exists('word_limiter')) {

    /**
     * Word Limiter, UTF-8 version.
     *
     * Limits a string to X number of words.
     *
     * @param string  $str
     * @param integer $limit
     * @param string  $end_char the end character. Usually an ellipsis
     *
     * @return string
     */
    function word_limiter(string $str, int $limit = 100, string $end_char = '&#8230;'): string
    {
        if (UTF8::trim($str) === '')
        {
            return $str;
        }

        // Added by Ivan Tcholakov, 08-FEB-2016.
        $end_char = html_entity_decode($end_char, ENT_QUOTES, 'UTF-8');
        //

        preg_match('/^\s*+(?:\S++\s*+){1,' . (int) $limit . '}/u', $str, $matches);

        if (UTF8::strlen($str) === UTF8::strlen($matches[0]))
        {
            $end_char = '';
        }

        return UTF8::rtrim($matches[0]).$end_char;
    }

}


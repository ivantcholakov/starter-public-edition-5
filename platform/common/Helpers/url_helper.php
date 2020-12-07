<?php

if (! function_exists('safe_mailto'))
{
    /**
     * Encoded Mailto Link
     *
     * A weaker alternative implementation because
     * Javascript's function document.write()
     * breaks Turbolinks.
     * @link https://stackoverflow.com/questions/12592363/looking-for-a-php-only-email-address-obfuscator-function
     *
     * @param string $email      the email address
     * @param string $title      the link title
     * @param mixed  $attributes any attributes
     *
     * @return string
     */
    function safe_mailto(string $email, string $title = '', $attributes = ''): string
    {
        if (!empty($attributes))
        {
            $attributes = stringify_attributes($attributes);
        }

        $email = trim($email);
        $title = trim($title);

        if ($title == '') {
            $title = $email;
        }

        $encoded_email = '';

        for ($a = 0, $b = \UTF8::strlen($email);  $a < $b; $a++)
        {
            $letter = \UTF8::substr($email, $a, 1);
            $encoded_email .= '&#'.(mt_rand(0, 1) == 0  ? 'x'.dechex(\UTF8::ord($letter)) : \UTF8::ord($letter)) . ';';
        }

        $encoded_title = '';

        for ($a = 0, $b = \UTF8::strlen($title);  $a < $b; $a++)
        {
            $letter = \UTF8::substr($title, $a, 1);
            $encoded_title .= '&#'.(mt_rand(0, 1) == 0  ? 'x'.dechex(\UTF8::ord($letter)) : \UTF8::ord($letter)) . ';';
        }

        return '<a href="mailto:'.$encoded_email.'" '.$attributes.'>'.$encoded_title.'</a>';
    }
}

if (! function_exists('auto_link'))
{
    /**
     * Modifies the auto_link helper (url_helper) by accepting as an optional third
     * argument an array of html attributes for the anchor tags (just like the anchor helper).
     *
     * This array is supplied as the third argument, replacing the
     * optional argument $pop in the original helper.
     *
     * This modified helper attempts to be backward compatible with the use of the
     * original helper by accepting TRUE and FALSE as possible values for the $attributes
     * argument, and giving output identical to the original usage of the helper.
     *
     * use:  auto_link($string, 'url' , array('class' => 'external', 'target'=>'_blank'));
     * use:  auto_link($string, 'email', array('class' => 'email_link' , 'style' => 'color:red;'));
     * use(legacy): auto_link($string, 'url' , TRUE);
     *
     * @link https://github.com/bcit-ci/CodeIgniter/wiki/auto-link
     * @author Derek Jones (original author)
     * @author Ivan Tcholakov (adaptation)
     *
     * @see url_helper
     * @link https://codeigniter.com/userguide3/helpers/url_helper.html
     * @param string $str
     * @param string $type
     * @param mixed $attributes
     * @return string
     */
    function auto_link($str, $type = 'both', $attributes = '')
    {
        // MAKE THE THIRD ARGUMENT BACKWARD COMPATIBLE
        // here we deal with the original third argument $pop
        // which could be TRUE or FALSE, and was FALSE by default.
        if ($attributes === TRUE)
        {
            $attributes = ' target="_blank" rel="noopener"';
        }
        elseif ($attributes === FALSE)
        {
            $attributes = '';
        }

        if (!empty($attributes))
        {
            $attributes = stringify_attributes($attributes);
        }

        // Find and replace any URLs.
        // Modified by Ivan Tcholakov, 19-DEC-2013, 09-MAR-2017.
        //if ($type !== 'email' && preg_match_all('#(\w*://|www\.)[^\s()<>;]+\w#i', $str, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER))
        if ($type !== 'email' && preg_match_all('#(\w*://|www\.)[^\s()<>;]+(\w|/)#iu', $str, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER))
        //
        {
            // We process the links in reverse order (last -> first) so that
            // the returned string offsets from preg_match_all() are not
            // moved as we add more HTML.
            foreach (array_reverse($matches) as $match)
            {
                // $match[0] is the matched string/link
                // $match[1] is either a protocol prefix or 'www.'
                //
                // With PREG_OFFSET_CAPTURE, both of the above is an array,
                // where the actual value is held in [0] and its offset at the [1] index.
                $a = '<a href="'.(strpos($match[1][0], '/') ? '' : 'http://').$match[0][0].'"'.$attributes.'>'.$match[0][0].'</a>';
                $str = substr_replace($str, $a, $match[0][1], strlen($match[0][0]));
            }
        }

        // Find and replace any emails.
        if ($type !== 'url' && preg_match_all('#([\w\.\-\+]+@[a-z0-9\-]+\.[a-z0-9\-\.]+[^[:punct:]\s])#i', $str, $matches, PREG_OFFSET_CAPTURE))
        {
            foreach (array_reverse($matches[0]) as $match)
            {
                if (filter_var($match[0], FILTER_VALIDATE_EMAIL) !== FALSE)
                {
                    $str = substr_replace($str, safe_mailto($match[0], '', $attributes), $match[1], strlen($match[0]));
                }
            }
        }

        return $str;
    }
}

if (!function_exists('url_title')) {

    function url_title($str, $separator = '-', $lowercase = FALSE, $transliterate_to_ascii = TRUE, $language = NULL) {

        $str = strip_tags($str);

        if ($transliterate_to_ascii) {
            $str = Transliterate::to_ascii($str, $language);
        }

        if ($separator === 'dash') {
            $separator = '-';
        }
        elseif ($separator === 'underscore') {
            $separator = '_';
        }

        $q_separator = preg_quote($separator);

        $trans = array(
                '&.+?;'                 => '',
                '[^\p{L}0-9 _-]'        => '',
                '\s+'                   => $separator,
                '('.$q_separator.')+'   => $separator
            );

        foreach ($trans as $key => $val) {
            $str = preg_replace('#'.$key.'#u', $val, $str);
        }


        if ($lowercase) {
            $str = UTF8::strtolower($str);
        }

        return trim(trim($str, $separator));
    }

}

if (!function_exists('slugify')) {

    // A function for compatibility with PyroCMS.
    function slugify($str, $separator = '-') {

        return url_title($str, $separator, true);
    }

}

if (! function_exists('mb_url_title'))
{
    function mb_url_title($str, $separator = '-', $lowercase = FALSE): string
    {
        return url_title($str, $separator, $lowercase, TRUE, NULL);
    }
}

if (!function_exists('gmap_url')) {

    /**
     * Returns a link for showing a Google Map at a given location.
     *
     * @param   float       $latitude           The location's latitude.
     * @param   float       $longitude          The location's longitude.
     * @param   int         $zoom               The map zooming.
     * @param   boolean     $show_marker        TRUE - show a marker at the location, FALSE - don't show a marker.
     * @param   string      $marker_name        The name associated with the marker (an address for example)
     * @return  string                          Returns a link to be opened with a browser.
     *
     * @author Ivan Tcholakov <ivantcholakov@gmail.com>, 2015-2017
     * @license The MIT License, http://opensource.org/licenses/MIT
     */
    function gmap_url($latitude, $longitude, $zoom = null, $show_marker = true, $marker_name = null) {

        $latitude = trim($latitude);
        $longitude = trim($longitude);

        if ($latitude == '' || !is_numeric($latitude) || $longitude == '' || !is_numeric($longitude)) {
            return;
        }

        $zoom = (int) $zoom;

        if ($zoom <= 0) {
            $zoom = 1;
        }

        $show_marker = !empty($show_marker);
        $marker_name = @ (string) $marker_name;

        if ($show_marker) {

            if ($marker_name == '') {
                $marker_name = "$latitude,$longitude";
            }

            $marker_name = urlencode($marker_name);

            $result = "https://www.google.com/maps/place/$marker_name/@$latitude,$longitude,{$zoom}z";

        } else {

            $result = "https://www.google.com/maps/@$latitude,$longitude,{$zoom}z";
        }

        return $result;
    }

}

<?php

namespace Common\Modules\System\View;

// Experimental.

class PHP
{
    public function __construct()
    {
    }

    public function render($____TEMPLATE____, array $____DATA____ = null, array $____OPTIONS____ = null)
    {
        unset($____OPTIONS____);

        if (!empty($____DATA____)) {
            extract($____DATA____);
        }

        unset($____DATA____);

        ob_start();
        include $____TEMPLATE____; // PHP will be processed
        $output = ob_get_contents();
        @ob_end_clean();

        return $output;
    }

    public function renderString($____TEMPLATE____, array $____DATA____ = null, array $____OPTIONS____ = null)
    {
        unset($____OPTIONS____);

        if (!empty($____DATA____)) {
            extract($____DATA____);
        }

        unset($____DATA____);

        ob_start();
        $incoming = '?>' . $____TEMPLATE____;
        eval($incoming);
        $output = ob_get_contents();
        @ob_end_clean();

        return $output;
    }

}

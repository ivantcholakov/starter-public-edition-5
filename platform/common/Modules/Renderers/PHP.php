<?php

namespace Common\Modules\Renderers;

class PHP
{
    public function render($____TeMpLaTe____, array $____DaTa____ = null, array $____OpTiOnS____ = null)
    {
        unset($____OpTiOnS____);

        if (!empty($____DaTa____)) {
            extract($____DaTa____);
        }

        unset($____DaTa____);

        ob_start();
        include $____TeMpLaTe____; // PHP will be processed
        $output = ob_get_contents();
        @ob_end_clean();

        return $output;
    }

    public function renderString($____TeMpLaTe____, array $____DaTa____ = null, array $____OpTiOnS____ = null)
    {
        unset($____OpTiOnS____);

        if (!empty($____DaTa____)) {
            extract($____DaTa____);
        }

        unset($____DaTa____);

        ob_start();
        $incoming = '?>' . $____TeMpLaTe____;
        eval($incoming);
        $output = ob_get_contents();
        @ob_end_clean();

        return $output;
    }

}

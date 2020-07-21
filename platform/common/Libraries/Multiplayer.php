<?php

namespace Common\Libraries;

/**
 * A wrapper of fg/multiplayer library.
 *
 * @author Ivan Tcholakov <ivantcholakov@gmail.com>, 2020
 * @license The MIT License, http://opensource.org/licenses/MIT
 *
 */

class Multiplayer extends \Multiplayer\Multiplayer {

    public function __construct()
    {
        $config = config('Multiplayer');

        parent::__construct($config->services, $config->template);
    }

}

<?php

namespace Common\Config;

use CodeIgniter\Config\BaseConfig;

class Multiplayer extends BaseConfig
{
    public function __construct() {

        $this->services = [
            'vbox7' => [
                'id' => '#vbox7\.com/play\:(?<id>[a-z0-9_-]+)#i',
                'url' => 'http://vbox7.com/emb/external.php?vid=%s',
                'map' => [],
            ]
        ];

        $this->template = null;
    }

//------------------------------------------------------------------------------

}

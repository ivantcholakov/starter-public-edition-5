<?php

namespace Config;

class Autoload extends \Common\Config\Autoload
{
    public function __construct()
    {
        parent::__construct();

        $psr4 = [
            'Playground' => APPPATH . 'Modules/Playground',
        ];

        $classmap = [
        ];

        //--------------------------------------------------------------------
        // Do Not Edit Below This Line
        //--------------------------------------------------------------------

        $this->psr4     = array_merge($this->psr4, $psr4);
        $this->classmap = array_merge($this->classmap, $classmap);

        unset($psr4, $classmap);
    }

}

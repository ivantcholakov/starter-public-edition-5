<?php

namespace Playground\Controllers;

class Playground extends \Playground\Core\BaseController
{
    public function index()
    {
        $title = 'The Playground';

        $this->header->setTitle($title);

        return view('Playground\Views\playground');
    }

}

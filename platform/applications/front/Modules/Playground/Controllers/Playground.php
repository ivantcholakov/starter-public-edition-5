<?php

namespace Playground\Controllers;

class Playground extends \Playground\Core\BaseController
{
    public function index()
    {
        $title = 'The Playground';

        $this->header->setTitle($title);

        // TODO: See why this is not working.
        //return view('Playground\Views\playground.html.twig');

        return view('Playground\Views\playground');
    }

}

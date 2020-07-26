<?php

namespace Playground\Controllers;

class Masonry extends \Playground\Core\BaseController
{
    public function index()
    {
        $title = 'Masonry Test';

        $this->breadcrumb->add($title, site_url('playground/masonry'));
        $this->header->setTitle($title);

        return view('Playground\Views\masonry', []);
    }

}

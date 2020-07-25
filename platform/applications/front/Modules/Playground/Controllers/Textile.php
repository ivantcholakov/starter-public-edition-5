<?php

namespace Playground\Controllers;

class Textile extends \Playground\Core\BaseController
{
    public function index()
    {
        $title = 'Textile Parser Test';

        $this->breadcrumb->add($title, site_url('playground/textile'));
        $this->header->setTitle($title);

        $text = str_replace('BASE_URL', base_url().'/', source('Playground\Views\test.textile'));
        $html = str_replace('BASE_URL', base_url().'/', render('Playground\Views\test.textile'));

        return view('Playground\Views\textile', ['text' => $text, 'html' => $html]);
    }

}

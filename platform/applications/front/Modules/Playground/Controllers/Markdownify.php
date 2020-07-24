<?php

namespace Playground\Controllers;

class Markdownify extends \Playground\Core\BaseController
{
    public function index()
    {
        $title = 'Markdownify Parser Test';

        $this->breadcrumb->add($title, site_url('playground/markdownify'));
        $this->header->setTitle($title);

        $html = str_replace('BASE_URL', base_url().'/', render('Playground\Views\test.textile'));
        $text = render_string($html, null, 'markdownify');

        return view('Playground\Views\markdownify', ['text' => $text, 'html' => $html]);
    }

}

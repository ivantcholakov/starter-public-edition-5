<?php

namespace Playground\Controllers;

class Markdown extends \Playground\Core\BaseController
{
    public function index()
    {
        $title = 'Markdown Parser Test';

        $this->breadcrumb->add($title, site_url('playground/markdown'));
        $this->header->setTitle($title);

        $html = '';
        $text = '';
        $text = source('Playground\Views\test.md');
        $html = render_string($text, null, 'markdown');

        return view('Playground\Views\markdown', ['text' => $text, 'html' => $html]);
    }

}

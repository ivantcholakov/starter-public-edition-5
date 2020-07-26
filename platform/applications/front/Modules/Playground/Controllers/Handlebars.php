<?php

namespace Playground\Controllers;

class Handlebars extends \Playground\Core\BaseController
{
    public function index()
    {
        $title = 'Handlebars Renderer Test';

        $this->breadcrumb->add($title, site_url('playground/handlebars'));
        $this->header->setTitle($title);

        $template = source('Playground\Views\countries.handlebars');

        $data = [];
        $data['FLAGS_BASE_URL'] = base_url('assets/lib/flags-iso/flat/32');
        $data['items'] = (new \Playground\Models\CountryList())->all();

        return view('Playground\Views\handlebars', ['template' => $template, 'data' => $data]);
    }

}

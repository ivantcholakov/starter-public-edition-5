<?php

namespace Playground\Controllers;

class Mustache extends \Playground\Core\BaseController
{
    public function index()
    {
        $title = 'Mustache Renderer Test';

        $this->breadcrumb->add($title, site_url('playground/mustache'));
        $this->header->setTitle($title);

        $template = source('Playground\Views\countries.mustache');

        $data = [];
        $data['FLAGS_BASE_URL'] = base_url('assets/lib/flags-iso/flat/32');
        $data['items'] = (new \Playground\Models\CountryList())->all();

        return view('Playground\Views\mustache', ['template' => $template, 'data' => $data]);
    }

}

<?php

namespace Playground\Controllers;

class FileTypeIcons extends \Playground\Core\BaseController
{
    public function index()
    {
        $title = 'Testing File Type Icons';

        $this->breadcrumb->add($title, site_url('playground/file-type-icons'));
        $this->header->setTitle($title);

        helper('file_type_icons');

        $file_extensions = array_merge(['unknown'], array_keys(file_type_icon()));

        return view('Playground\Views\file_type_icons', ['file_extensions' => $file_extensions]);
    }

}

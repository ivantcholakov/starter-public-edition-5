<?php

namespace App\Controllers;

class Readme extends \App\Core\BaseController
{
    public function index()
    {
        $title = 'README';

        $this->mainMenu->setActiveItem('readme');
        $this->breadcrumb->add($title, site_url('readme'), 'info circle icon');
        $this->header->setTitle($title);

        $readme = null;
        $readme_file = realpath(PLATFORMPATH.'../'.'README.md');

        if (is_file($readme_file)) {
            $readme = render($readme_file, null, ['markdown' => ['full_path' => true]]);
        }

        return view('readme', compact('readme'));
    }

}

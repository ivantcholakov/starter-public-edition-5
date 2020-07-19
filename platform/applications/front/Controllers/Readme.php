<?php namespace App\Controllers;

class Readme extends BaseController
{
    public function index()
    {
        $this->mainMenu->setActiveItem('readme');

        $readme = null;
        $readme_file = realpath(PLATFORMPATH.'../'.'README.md');

        if (is_file($readme_file)) {

            $readme = render_string(file_get_contents($readme_file), null, 'markdown');
        }

        return view('readme', compact('readme'));
    }

}
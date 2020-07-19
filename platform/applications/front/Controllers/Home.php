<?php namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $this->mainMenu->setActiveItem('home');

        $readme = null;
        $readme_file = realpath(PLATFORMPATH.'../'.'README.md');

        if (is_file($readme_file)) {

            $readme = render_string(file_get_contents($readme_file), null, 'markdown');
        }

        return view('welcome_message', compact('readme'));
    }

    //--------------------------------------------------------------------

}

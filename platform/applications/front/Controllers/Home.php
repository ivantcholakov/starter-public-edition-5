<?php namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $readme = null;
        $readme_file = realpath(PLATFORMPATH.'../'.'README.md');

        if (is_file($readme_file)) {

            //// This is a temporary, hard way to create the renderer.
            //$markdown = new \Common\Modules\Markdown\Markdown();

            // This is another temporary way to create the renderer.
            $markdown = (new \Common\Modules\System\View\DriverManager())
                ->createRenderer('markdown');

            $readme = $markdown->renderString(file_get_contents($readme_file));
        }

        return view('welcome_message.html', compact('readme'));
    }

    //--------------------------------------------------------------------

}

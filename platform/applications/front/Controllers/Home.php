<?php namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $readme = null;
        $readme_file = realpath(PLATFORMPATH.'../'.'README.md');

        if (is_file($readme_file)) {

            $readme = render_string(file_get_contents($readme_file), null, 'markdown');
        }

        registry_set('test', render_string('
.example {
    display: grid;
    transition: all .5s;
    user-select: none;
    background: linear-gradient(to bottom, white, black);
}
', null, ['less', 'autoprefixer' => ['browsers' => ['> 0.1%', 'last 2 versions', 'Firefox ESR', 'ie 9-11']]]));

        return view('welcome_message', compact('readme'));
    }

    //--------------------------------------------------------------------

}

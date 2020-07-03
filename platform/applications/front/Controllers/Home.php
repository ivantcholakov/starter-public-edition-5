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
{
    "a": "b", /* A comment (not officially supported, see RFC 4627). */
    "c": "d"  // Yet another comment.
}
'
        , null, 'jsonmin'));

        return view('welcome_message', compact('readme'));
    }

    //--------------------------------------------------------------------

}

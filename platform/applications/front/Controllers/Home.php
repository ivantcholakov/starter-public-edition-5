<?php namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $ivan = json_decode('{"name": "Ivan", "value" : 1000, "in_ca": true}');

        $ivan->taxed_value = function() use ($ivan) {
            return $ivan->value - ($ivan->value * 0.4);
        };

        registry_set('test', render(
            'test.mustache',
            $ivan
        ));

        $readme = null;
        $readme_file = realpath(PLATFORMPATH.'../'.'README.md');

        if (is_file($readme_file)) {

            $readme = render_string(file_get_contents($readme_file), null, 'markdown');
        }

        return view('welcome_message', compact('readme'));
    }

    //--------------------------------------------------------------------

}

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

        registry_set('test', render_string("
/*
 * test.js
 */

$(function() {

    $('#sidebar_toggle').on('click', function(e) {

        var body = $('body');
        var state = '';

        if (body.hasClass('sidebar-collapse')) {
            state = 'sidebar-collapse';
        }

        $.ajax({
            type: 'post',
            mode: 'queue',
            url: '/main-sidebar/toggle-ajax', // Adjust the URL here..
            data: {
                state: state
            },
            success: function(data) {

            }
        });
    });

});

"
        , null, 'jsmin'));

        return view('welcome_message', compact('readme'));
    }

    //--------------------------------------------------------------------

}

<?php namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $pass = 'jhdfks[eir]wm 9u57-m23v94u203wol vawjeklr';
        $original_string = 'My Secret Message';
        $encrypted_string = \GibberishAES::enc($original_string, $pass);
        $decrypted_string = \GibberishAES::dec($encrypted_string, $pass);

        return view('welcome_message', compact('original_string', 'encrypted_string', 'decrypted_string'));
    }

    //--------------------------------------------------------------------

}

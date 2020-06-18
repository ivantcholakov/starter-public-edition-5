<?php namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $pass = 'jhdfks[eir]wm 9u57-m23v94u203wol vawjeklr';
        $original_string = 'My Secret Message';
        $encrypted_string = \GibberishAES::enc($original_string, $pass);
        $decrypted_string = \GibberishAES::dec($encrypted_string, $pass);

        $twig = new \Common\Modules\Twig\Twig();
        $hello = $twig->renderString('Hello {{ name }}!', ['name' => 'Ivan']);

        return view('welcome_message.html', compact('original_string', 'encrypted_string', 'decrypted_string', 'hello'));
    }

    //--------------------------------------------------------------------

}

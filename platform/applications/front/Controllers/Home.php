<?php namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $this->mainMenu->setActiveItem('home');

        $data = [];

        return view('welcome_message', $data);
    }

}

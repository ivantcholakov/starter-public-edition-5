<?php

namespace Playground\Controllers;

class Multiplayer extends \Playground\Core\BaseController
{
    public function index()
    {
        $title = 'Multiplayer Library Test';

        $this->breadcrumb->add($title, site_url('playground/multiplayer'));
        $this->header->setTitle($title);

        $multiplayer = new \Common\Libraries\Multiplayer();

        $videos = array(
            'https://www.youtube.com/watch?v=NRhVcTTMlrM',
            'http://vimeo.com/60743823',
            'http://www.dailymotion.com/video/x9kdze',
            'http://vbox7.com/play:25c4115f2d',
        );

        return view('Playground\Views\multiplayer', ['multiplayer' => $multiplayer, 'videos' => $videos]);
    }

}

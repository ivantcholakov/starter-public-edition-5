<?php

namespace Playground\Controllers;

class WhichBrowser extends \Playground\Core\BaseController
{
    public function index()
    {
        $title = 'WhichBrowser Test';

        $this->breadcrumb->add($title, site_url('playground/which-browser'));
        $this->header->setTitle($title);

        $request = service('request');

        $headers = [];

        foreach ($request->getHeaders() as $header) {

            $headers[$header->getName()] = $header->getValueLine();
        }

        try {

            $result = new \WhichBrowser\Parser($headers);
            $your_browser = $result->toString();

        } catch (Exception $ex) {

            $your_browser = $ex->getMessage();
        }

        return view('Playground\Views\which_browser', ['your_browser' => $your_browser]);
    }

}

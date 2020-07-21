<?php

namespace Playground\Core;

class BaseController extends \App\Core\BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->mainMenu->setActiveItem('playground');
        $this->breadcrumb->add('The Playground', site_url('playground'), 'sun icon');
    }
}

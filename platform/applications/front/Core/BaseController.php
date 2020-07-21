<?php

namespace App\Core;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * @var \App\Libraries\MainMenu
     */
    public $mainMenu;

    /**
     * @var \App\Libraries\Breadcrumb
     */
    public $breadcrumb;

    /**
     * @var \App\Libraries\Header
     */
    public $header;

    /**
     * Constructor.
     */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.:
        // $this->session = \Config\Services::session();

        registry_set('controller', $this);

        $this->mainMenu = new \App\Libraries\MainMenu();
        $this->breadcrumb = new \App\Libraries\Breadcrumb();
        $this->header = new \App\Libraries\Header();

        $this->breadcrumb->add('Home', site_url(), 'home icon');
    }

}

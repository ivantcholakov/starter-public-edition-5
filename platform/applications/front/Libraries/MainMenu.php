<?php

namespace App\Libraries;

class MainMenu
{
    protected $items = [];
    protected $activeItem;

    public function __construct()
    {
        $this->items['home'] = array('label' => 'Home', 'icon' => 'home icon', 'location' => site_url());
        $this->items['readme'] = array('label' => 'README', 'icon' => 'info circle icon', 'location' => 'readme');
        $this->items['playground'] = array('label' => 'The Playground', 'icon' => 'sun icon', 'location' => 'playground');

        //// Sub-menu demostration.
        //$this->items['multiplayer'] = array('label' => 'Multiplayer Library Test', 'location' => 'playground/multiplayer', 'parent_id' => 'playground');
    }

    public function getActiveItem()
    {
        return $this->activeItem;
    }

    public function setActiveItem($activeItem)
    {
        $this->activeItem = $activeItem;
    }

    public function render()
    {
        $menu = new \Common\Libraries\Menu();

        $nav = $menu->render($this->items, $this->activeItem, NULL, 'data');

        return render('main_menu', ['nav' => $nav]);
    }
}

<?php

namespace App\Libraries;

class Breadcrumb
{
    protected $items = [];

    public function add($name, $url = null, $icon = null, $raw = false)
    {
        $this->items[] = ['name' => $name, 'url' => $url, 'icon' => $icon, 'raw' => !empty($raw)];
    }

    public function count()
    {
        return count($this->items);
    }

    public function render()
    {
        return render('breadcrumb', ['breadcrumbs' => $this->items, 'n' => count($this->items)]);
    }
}

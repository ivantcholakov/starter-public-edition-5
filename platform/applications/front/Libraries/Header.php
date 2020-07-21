<?php

namespace App\Libraries;

class Header
{
    protected $title;

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function render()
    {
        return render('header', ['title' => $this->title]);
    }
}

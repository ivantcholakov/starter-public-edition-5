<?php

namespace Playground\Models;

class CountryList {

    protected $items = [];

    public function __construct()
    {
        $csv = file_get_contents(__DIR__.'/countries.csv');

        $items = preg_split('/\r\n|\r|\n/m', $csv, null, PREG_SPLIT_NO_EMPTY);

        foreach ($items as $item) {

            $values = explode(';', $item);
            $this->items[] = ['code' => $values[0], 'name' => $values[1]];
        }
    }

    public function all()
    {
        return $this->items;
    }

    public function count()
    {
        return count($this->items);
    }
}

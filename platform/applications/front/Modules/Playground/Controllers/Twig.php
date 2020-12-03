<?php

namespace Playground\Controllers;

class Twig extends \Playground\Core\BaseController
{
    public function index()
    {
        $title = 'Twig Renderer Test';

        $this->breadcrumb->add($title, site_url('playground/twig'));
        $this->header->setTitle($title);

        $countries = (new \Playground\Models\CountryList())->all();
        $countries_10 = array_slice($countries, 0, 10);

        $data = [
            'br' => '<br />',
            'hr' => '<hr />',
            'name' => 'John',
            'array_1' => ['one', 'two', 'three'],
            'array_2' => ['one', 'two', 'three', ['four', 'five']],
            'string_123' => 'one, two, three',
            'string_empty' => '',
            'json_123' => json_encode(['one', 'two', 'three']),
            'very_long_text' => 'Very long text. Very long text. Very long text. Very long text.',
            'value_0' => 0,
            'value_1' => 1,
            'value_2' => 2,
            'value_3' => 3,
            'boolean_true' => true,
            'value_null' => null,
            'string_10' => '10',
            'object_123' => (object) ['one', 'two', 'three'],
            'float_value' => 250.5,
            'dog' => "I'll \"walk\" the <b>dog</b> now.",
            'dog_entities' => htmlentities("I'll \"walk\" the <b>dog</b> now.", ENT_QUOTES, 'UTF-8'),
            'countries' => $countries,
            'countries_10' => $countries_10,
            'string_markdown' => 'Formatted **text**',
            'string_textile' => 'Formatted _text_',
        ];

        return view('Playground\Views\twig', $data);
    }

}

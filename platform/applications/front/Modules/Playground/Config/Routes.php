<?php

$routes->group('playground', ['namespace' => 'Playground\Controllers'], function($routes) {
    $routes->get('/', 'Playground::index');
});

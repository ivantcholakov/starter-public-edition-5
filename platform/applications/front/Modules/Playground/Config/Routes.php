<?php

$routes->group('playground', ['namespace' => 'Playground\Controllers'], function($routes) {

    $routes->get('/', 'Playground::index');

    $routes->get('mustache', 'Mustache::index');

    $routes->get('handlebars', 'Handlebars::index');

    $routes->get('markdown', 'Markdown::index');

    $routes->get('markdownify', 'Markdownify::index');

    $routes->get('textile', 'Textile::index');

    $routes->get('multiplayer', 'Multiplayer::index');

    $routes->get('file-type-icons', 'FileTypeIcons::index');

    $routes->get('which-browser', 'WhichBrowser::index');

    $routes->get('masonry', 'Masonry::index');
});

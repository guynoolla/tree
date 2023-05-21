<?php

return [
    'url_base' => '/daxrealestate/',
    'app_root' => realpath(__DIR__),
    'views_path'  => 'Views' . DIRECTORY_SEPARATOR,

    'db'  => [
        'host'       => 'localhost',
        'name'       => 'db_tree',
        'user'       => 'root',
        'password'   => '',
        'charset'    => 'utf8',
    ],

    'assets' => [
        'css' => '/assets/css',
        'js'  => '/assets/js'
    ]
];

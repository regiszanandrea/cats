<?php

return [

    'mysql' => [
        'driver' =>  'mysql',

        'host' => $_ENV['DB_HOST'],
        'database' => $_ENV['DB_NAME'],
        'username' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
        'port' => $_ENV['DB_PORT'],
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
    ]
];

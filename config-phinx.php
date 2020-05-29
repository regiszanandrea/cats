<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$database = include(__DIR__ . '/config/database.php');
$database = $database['mysql'];

return [
    'paths' => [
        'migrations' => 'database/migrations'
    ],
    'migration_base_class' => '\Migration\Migration',
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'dev',
        'dev' => [
            'adapter' => $database['driver'],
            'host' => $database['host'],
            'name' => $database['database'],
            'user' => $database['username'],
            'pass' => $database['password'],
            'port' => $database['port'],
        ]
    ]
];
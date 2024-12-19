<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

return [
    'paths' => [
        'migrations' => 'database/migrations',
        'seeds' => 'database/seeds',
    ],
    'environments' => [
        'default' => 'development',
        'development' => [
            'adapter' => 'pgsql',
            'host' => $_ENV['DB_HOST'],
            'name' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USERNAME'],
            'pass' => $_ENV['DB_PASSWORD'],
            'port' => $_ENV['DB_PORT'],
            'charset' => 'utf8mb4',
        ],
    ],
];
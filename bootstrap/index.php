<?php

use DI\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

error_log('DB Host: ' . $_ENV['DB_HOST']);

$container = new Container;

$settings = require __DIR__ . '/../app/settings.php';
$settings($container);

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'pgsql',
    'host' => $_ENV['DB_HOST'],
    'port' => $_ENV['DB_PORT'],
    'database' => $_ENV['DB_DATABASE'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => 'UTF8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

AppFactory::setContainer($container);
$app = AppFactory::create();

$middlewares = require __DIR__ . '/../app/middleware.php';
$middlewares($app);

$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$app->run();
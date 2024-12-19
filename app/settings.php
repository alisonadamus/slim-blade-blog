<?php

use Dotenv\Dotenv;
use Psr\Container\ContainerInterface;

require_once __DIR__ . '/../vendor/autoload.php';

return function (ContainerInterface $container) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    $container->set('settings', function () {
        return [
            'displayErrorDetails' => true,
            'log_errors' => true,
            'log_error_details' => true
        ];
    });

    if (!function_exists('isLoggedIn')) {
        function isLoggedIn(): bool
        {
            return isset($_SESSION['user_id']);
        }
    }
};
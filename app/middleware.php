<?php

use Slim\App;

return function (App $app) {
    $settings = $app->getContainer()->get('settings');
    $app->addErrorMiddleware(
        $settings['displayErrorDetails'],
        $settings['log_errors'],
        $settings['log_error_details']
    );
};
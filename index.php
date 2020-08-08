<?php

//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
require 'vendor/autoload.php';

use Klein\Klein;

use OneT\Api;
use OneT\Database;
use OneTUI\Views;


$config = parse_ini_file("config.ini");

$klein = new Klein();

$klein->respond(function ($request, $response, $service, $app) use ($config, $klein) {
    // Handle exceptions => flash the message and redirect to the referrer
    $klein->onError(function ($klein, $err_msg) {
        $klein->service()->flash($err_msg);
        $klein->service()->back();
    });

    // lazy services (Only get instantiated on first call)
    $app->register('db', function () use ($config) {
        // Replace the values in config.ini with your actual database login details
        return Database::newConnection($config);
    });

    $app->register('api', function () use ($app) {
        return new Api($app);
    });

    $app->register('view', function () use ($app, $service) {
        return new Views($service);
    });
});

$klein->respond('GET', '/', function ($req, $resp, $service, $app) {
    $app->view->home();
});

$klein->respond('GET', '/user', function ($req, $resp, $service, $app) use ($klein) {
    $app->view->userPage();
    $klein->abort();
});

$klein->respond(['POST', 'GET'], '/api/[:action]', function ($req, $resp, $service, $app) {
    $app->api->execute($req, $resp);
});

$klein->respond(['POST', 'GET'], '/[a:short_slug]', function ($req, $resp, $service, $app) {
    $app->api->resolve($req, $resp);
});


$klein->dispatch();
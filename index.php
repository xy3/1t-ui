<?php

require "vendor/autoload.php";

use Klein\Klein;

use OneT\Accounts;
use OneT\Api;
use OneT\Database;
use OneTUI\Views;


$config = parse_ini_file("config.ini");

$klein = new Klein();

$klein->respond(function ($request, $response, $service, $app) use ($config, $klein) {
    // Handle exceptions => flash the message and redirect to the referrer
    $klein->onError(function ($klein, $err_msg) {
        $klein->service()->flash($err_msg);
        $klein->service()->flashes();
        echo $err_msg;
//        $klein->service()->back();
    });

    // lazy services (Only get instantiated on first call)
    $app->register('pdo', function () use ($config) {
        // Replace the values in config.ini with your actual database login details
        return Database::newConnection($config);
    });

    $app->register('api', function () use ($app) {
        return new Api($app->pdo);
    });

    $app->register('accounts', function () use ($app) {
        return new Accounts($app->pdo);
    });

    $app->register('views', function () use ($request, $app, $service) {
        $views = new Views($app, $service);
        return $views->setSiteUrl($app->api->getSiteUrl($request));
    });
});


$pages = [
    'user',
    'links',
    'debug'
];


$view = function ($request, $response, $service, $app) use ($klein) {
    $app->views->show($request, $response, $service, $app);
};

$protectedView = function ($request, $response, $service, $app) use ($klein) {
    $app->views->showProtected($request, $response, $service, $app);
};

$klein->respond('GET', '/', $view);
$klein->respond('GET', '/[user|links:page]', $protectedView);


$klein->respond(['POST', 'GET'], '/api/[a:action]', function ($req, $resp, $service, $app) {
    $app->api->execute($req, $resp);
});

$klein->respond(['POST', 'GET'], '/[a:short_slug]', function ($req, $resp, $service, $app) use ($pages, $klein) {
    if (!in_array($req->short_slug, $pages)) {
        $app->api->resolve($req, $resp);
    }
});

$klein->respond(['POST', 'GET'], '/accounts/[a:action]', function ($req, $resp, $service, $app) {
    $app->accounts->execute($req, $resp);
});


$klein->respond('GET', '/debug', function ($req, $resp, $service, $app) {
    session_start();
    var_dump($_SESSION);
});


$klein->dispatch();
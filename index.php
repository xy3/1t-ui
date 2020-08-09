<?php

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
    $app->register('pdo', function () use ($config) {
        // Replace the values in config.ini with your actual database login details
        return Database::newConnection($config);
    });

    $app->register('api', function () use ($app) {
        return new Api($app->db);
    });

    $app->register('view', function () use ($request, $app, $service) {
        $views = new Views($app, $service);
        $views->setSiteUrl($app->api->getSiteUrl($request));
        return $views;
    });

    $klein->respond('GET', '/', $app->views->show);
    $klein->respond('GET', '/[user|login|contact:page]', $app->views->show);
});


$klein->respond(['POST', 'GET'], '/api/[:action]', function ($req, $resp, $service, $app) {
    $app->api->execute($req, $resp);
});

$klein->respond(['POST', 'GET'], '@/[a:short_slug]', function ($req, $resp, $service, $app) {
    $app->api->resolve($req, $resp);
});


$klein->dispatch();
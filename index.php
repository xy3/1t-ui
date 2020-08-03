<?php

require 'vendor/autoload.php';

use Klein\Klein;
use OneTUI\Views;

$klein = new Klein();

$klein->respond(function ($request, $response, $service, $app) use ($klein) {
    // Handle exceptions => flash the message and redirect to the referrer
    $klein->onError(function ($klein, $err_msg) {
        $klein->service()->flash($err_msg);
        $klein->service()->back();
    });

    $app->register('view', function () use ($service, $app) {
        return new Views($service);
    });
});

$klein->respond('GET', '/1t-ui/', function ($req, $resp, $service, $app) {
    $app->view->home();
});


$klein->dispatch();
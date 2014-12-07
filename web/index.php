<?php

session_start();
require_once __DIR__.'/../vendor/autoload.php';

$applicationFactory = new NgakakSeru\Application\Factory();
$app = $applicationFactory->createApplication();

function get_site_url()
{
    global $app;

    return $app['config']['url']['site_url'];
}

$app->run();


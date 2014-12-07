<?php
session_start();
// web/index.php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['config'] = include __DIR__.'/../config/config.php';
$app['view'] = new League\Plates\Engine(__DIR__ . '/../view/scripts', 'phtml');
$app['database'] = NgakakSeru\Database\Connection::getConnection(include __DIR__ . '/../config/database.php');

// Enable PHP Error level
error_reporting(E_ALL);
ini_set('display_errors','On');

// Enable debug mode
$app['debug'] = true;

// Handle fatal errors



$app->get('/', 'NgakakSeru\\Controller\\Home::index');
$app->get('/about', 'NgakakSeru\\Controller\\About::dispatch');
$app->get('/contact', 'NgakakSeru\\Controller\\Contact::dispatch');
$app->post('/auth/register', 'NgakakSeru\\Controller\\Auth::register');
$app->post('/auth/login', 'NgakakSeru\\Controller\\Auth::login');
$app->get('/auth/logout', 'NgakakSeru\\Controller\\Auth::logout');
$app->get('/auth', 'NgakakSeru\\Controller\\Auth::index');
$app->get('/dashboard/uploadpicture', 'NgakakSeru\\Controller\\Dashboard::uploadPicture');
$app->get('/dashboard/history', 'NgakakSeru\\Controller\\Dashboard::history');
$app->post('/dashboard/uploadpicturedo', 'NgakakSeru\\Controller\\Dashboard::uploadPictureDo');

$app->run();


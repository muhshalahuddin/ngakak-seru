<?php

namespace NgakakSeru\Application;

class Factory
{
    public function createApplication()
    {
        $app = new \Silex\Application;

        $appPath = __DIR__ . '/../../..';

        $app['config']   = include $appPath . '/config/config.php';
        $app['view']     = new \League\Plates\Engine($appPath . '/view/scripts', 'phtml');
        $app['database'] = function () use ($appPath) {
            return \NgakakSeru\Database\Connection::getConnection(include $appPath . '/config/database.php');
        };

        if (isset($app['config']['debug'])) {
            $app['debug'] = $app['config']['debug'];
        }

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

        return $app;
    }
}

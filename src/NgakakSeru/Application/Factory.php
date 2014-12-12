<?php

namespace NgakakSeru\Application;

class Factory
{
    public function createApplication()
    {
        $app = new \Silex\Application();

        $appPath = __DIR__.'/../../..';
        $app['config']   = include $appPath.'/config/config.php';
        $app['view']     = function () use ($appPath, $app) {
            $engine = new \League\Plates\Engine($appPath.'/view/scripts', 'phtml');
            $engine->addData(array('app' => $app));
            $engine->addData(array('auth' => $app['auth']));

            return $engine;
        };

        $app['database'] = function () use ($appPath) {
            return \NgakakSeru\Database\Connection::getConnection(include $appPath.'/config/database.php');
        };

        $app['auth'] = function () use ($app) {
            $auth = new \Zend\Authentication\AuthenticationService();

            return $auth;
        };

        $app['auth_adapter'] = function () use ($app) {
            $authAdapter = new \NgakakSeru\Auth\AuthAdapter($app['database']);

            return $authAdapter;
        };

        if (isset($app['config']['debug'])) {
            $app['debug'] = $app['config']['debug'];
        }
        //POST *
        $app->post('/auth/register', 'NgakakSeru\\Controller\\Auth::register');
        $app->post('/dashboard/uploadpicturedo', 'NgakakSeru\\Controller\\Dashboard::uploadPictureDo');

        //GET *
        $app->get('/', 'NgakakSeru\\Controller\\Home::index');
        $app->get('/about', 'NgakakSeru\\Controller\\About::dispatch');
        $app->get('/contact', 'NgakakSeru\\Controller\\Contact::dispatch');
        $app->get('/auth/logout', 'NgakakSeru\\Controller\\Auth::logout');
        $app->get('/auth/loginpage', 'NgakakSeru\\Controller\\Auth::loginpage');
        $app->get('/auth/registerpage', 'NgakakSeru\\Controller\\Auth::registerpage');
        $app->get('/dashboard/uploadpicture', 'NgakakSeru\\Controller\\Dashboard::uploadPicture');
        $app->get('/dashboard/history', 'NgakakSeru\\Controller\\Dashboard::history');

        $app->post('/auth/login', 'NgakakSeru\\Controller\\Auth::handleLoginSubmit');
        $app->get('/auth/login', 'NgakakSeru\\Controller\\Auth::showLoginForm');

        return $app;
    }
}

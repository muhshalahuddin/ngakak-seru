<?php

namespace NgakakSeru\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use NgakakSeru\Database\HomePage;

class Home
{
    public function index(Request $request, Application $app)
    {
        $data['base_url'] = $request->getBasePath();
        $data['config'] = $app['config'];
        $data['detail'] = array(
            'title' => $app['config']['site']['site_title'],
            'description' => $app['config']['site']['site_description'],
            'keywords' => $app['config']['site']['site_keywords'],
            'author' => $app['config']['site']['site_author'],
            'version' => $app['config']['site']['site_version'],
            'baseUrl' => $app['config']['url']['base_url_asset'],
            'layout' => 'home', // name section of content
        );

        $homePage = new HomePage();
        $result = $homePage->loadPost($app['database']);
        $data['data'] = $result;

        return new Response($app['view']->render('home', $data));
    }
}

<?php

namespace NgakakSeru\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;

class Post
{
    public function showSinglePost(Request $request, Application $app)
    {
        $slug = $request->get('slug');
        $id   = $request->get('id');
        return new Response($slug . ' ' . $id);
    }
}

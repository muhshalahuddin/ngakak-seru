<?php

namespace NgakakSeru\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use NgakakSeru\Database as Database;

class Auth
{
    private $errorMessage = '';

    public function registerpage(Request $request, Application $app)
    {
        $data['base_url'] = $request->getBasePath();
        return new Response($app['view']->render('register', $data));
    }

    public function loginpage(Request $request, Application $app)
    {
        $data['base_url'] = $request->getBasePath();

        return new Response($app['view']->render('login', $data));
    }


    public function register(Request $request, Application $app)
    {
        $username = $request->get('username');

        if (empty($username)) {
            $this->errorMessage .= 'Username harus diisi<br>';
        }

        $email = $request->get('email');

        if (empty($email)) {
            $this->errorMessage .= 'Email harus diisi<br>';
        }
        $password = $request->get('password');

        if (empty($password)) {
            $this->errorMessage .= 'Password Harus diisi<br>';
        }

        $password_confirm = $request->get('password_confirm');

        if ($password != $password_confirm) {
            $this->errorMessage .= 'Pasword konfirmasi harus sama';
        }

        if (!$this->errorMessage) {
            $input = array(
                'username' => $username,
                'email' => $email,
                'password' => md5($password),
            );
            $insertUser = new Database\DatabaseCrud();
            $insertUser->insert($app['database'], 'users', $input);

            $newURL = get_site_url()."auth/loginpage";
            header('Location: '.$newURL);

            return new Response($app['view']->render('auth', $data));
        }
    }

    public function login(Request $request, Application $app)
    {
        $username = $request->get('username');
        $password = $request->get('password');

        $LoginUser = new Database\LoginUser();
        $cek_user = $LoginUser->login($app['database'], $username, $password);

        if ($cek_user) {
            $newURL = get_site_url()."dashboard/uploadpicture";
        } else {
            $newURL = get_site_url()."auth/loginpage";
        }
        header('Location: '.$newURL);

        return new Response($app['view']->render('auth', $data));
    }

    public function logout(Request $request, Application $app)
    {
        if (isset($_SESSION['user'])) {
            session_destroy();
        }

        $newURL = get_site_url()."auth";
        header('Location: '.$newURL);

        return new Response($app['view']->render('auth', $data));
    }
}

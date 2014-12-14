<?php

namespace NgakakSeru\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use NgakakSeru\Database as Database;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;

class Auth
{
    private $errorMessage = '';

    public function registerpage(Request $request, Application $app)
    {
        $data['base_url'] = $request->getBasePath();

        return new Response($app['view']->render('register', $data));
    }

    public function register(Request $request, Application $app)
    {
        $inputFilter = $this->getRegisterInputFilter();
        $inputFilter->setData($request->request->all());

        $passwordConfirm = $request->request->get('password_confirm');
        $inputFilter->get('password')->getValidatorChain()->attach(new Validator\Identical($passwordConfirm));

        $messages = array();
        if ($inputFilter->isValid()) {
            var_dump('valid');
            return new Response($app['view']->render('register', $data));
        } else {
            $messages = $inputFilter->getMessages();
            $data['messages'] = $messages;
            $data['registerForm'] = $request->request->all();
            
            return new Response($app['view']->render('register', $data));
        }

        /*
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
        */

        /*
        if (empty($messages)) {
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
        $data['messages'] = $messages;
        
        return new Response($app['view']->render('auth', $data));
        */
    }

    public function getRegisterInputFilter()
    {
        $email = new Input('email');
        $emailValidator = new Validator\EmailAddress();
        $emailValidator->setMessage('Email harus valid');
        $emailValidator->useMxCheck(true);
        $email->getValidatorChain()->attach($emailValidator);
        
        $username = new Input('username');
        $username->getValidatorChain()
            ->attach(new Validator\NotEmpty(), true)
            ->attach(new \Zend\I18n\Validator\Alnum())
            ->attach(new Validator\StringLength(array('min' => 4)));

        $password = new Input('password');
        $password->getValidatorChain()
            ->attach(new Validator\NotEmpty(), true);

        $inputFilter = new InputFilter();
        $inputFilter->add($email);
        $inputFilter->add($username);
        $inputFilter->add($password);

        return $inputFilter;
    }

    public function showLoginForm(Request $request, Application $app)
    {
        $data = array();

        return new Response($app['view']->render('login', $data));
    }

    public function handleLoginSubmit(Request $request, Application $app)
    {
        $username = $request->get('username');
        $password = $request->get('password');

        $auth        = $app['auth'];
        $authAdapter = $app['auth_adapter'];

        $authAdapter->setIdentity($username);
        $authAdapter->setCredential($password);

        $result = $auth->authenticate($authAdapter);

        if ($result->isValid()) {
            $newURL = get_site_url()."dashboard/uploadpicture";
            return new Response('', 302, array('Location' => $newURL));
        } else {
            $data = array('message' => 'Username atau password tidak valid.', 'username' => $username);
            return new Response($app['view']->render('login', $data));
        }
    }

    public function logout(Request $request, Application $app)
    {
        $app['auth']->clearIdentity();

        return new Response('', 302, array('Location' => $app['config']['url']['site_url']));
    }
}

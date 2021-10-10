<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\LoginForm;
use app\models\User;
use app\core\middlewares\AuthMiddleware;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    public function login(Request $request)
    {
        $loginForm = new LoginForm();
        if ($request->isPOST()) {
            $loginForm->loadData($request->getBody());

            if ($loginForm->validate() && $loginForm->login()) {
                Application::$app->response->redirect('/');
                // return;
            }
        }
        return $this->render('login', ['model' => $loginForm]);
    }

    public function logout()
    {
        Application::$app->logout();
        Application::$app->response->redirect('/');
    }

    public function register(Request $request)
    {

        $user = new User();
        if ($request->isPOST()) {
            $user->loadData($request->getBody());

            if ($user->validate() && $user->save()) {
                Application::$app->session->setFlashMessage('success', 'Thanks for registering');
                Application::$app->response->redirect('/');
            }

            return $this->render('register', ['model' => $user]);
        }
        return $this->render('register', ['model' => $user]);
    }

    public function profile()
    {
        return $this->render('profile');
    }
}

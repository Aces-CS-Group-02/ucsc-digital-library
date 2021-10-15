<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Mail;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\PendingUser;
use app\models\RegistrationRequest;
use app\models\User;

class authController extends Controller
{
    public function login(Request $request)
    {
        $loginForm = new LoginForm();
        if ($request->isPOST()) {
            $loginForm->loadData($request->getBody());

            if ($loginForm->validate() && $loginForm->login()) {
                Application::$app->response->redirect('/');
                return;
            }
        }
        return $this->render('auth/login', ['model' => $loginForm]);
    }

    public function register(Request $request)
    {

        // $user = new User();
        $pendingUser =  new PendingUser();
        if ($request->isPOST()) {
            $pendingUser->loadData($request->getBody());

            if ($pendingUser->validate()) {
                $email = $pendingUser->{"email"};

                $ucscEmailPattern = "/(.*)@(ucsc.cmb.ac.lk|stu.ucsc.cmb.lk|stu.ucsc.lk)/";
                $isUcscEmail = preg_match($ucscEmailPattern, $email);
                $code = substr(md5(mt_rand()), 0, 15);
                $pendingUser->{"token"} = $code;

                if ($isUcscEmail === 0) {

                    $subject = "Verification Email";
                    $link = "Click <a href='http://localhost:8000/verify-email?email={$email}&token={$code}'>Here</a> to verify.";
                    $body    = "<h1>Pleasy verify your email</h1><p>{$link}</p>";
                    $altBody = "this is the alt body";


                    $mail = new Mail([$email], $subject, $body, $altBody);
                    $mail->sendMail();

                    if ($pendingUser->save()) {
                        Application::$app->session->setFlashMessage('success', 'Thanks for registering, verification email sent, check your inbox :)');
                        Application::$app->response->redirect('/');
                    }
                } else {
                    return $this->render('auth/registration-request', ['model' => $pendingUser]);
                }
            }

            // echo '<pre>';
            // var_dump($pendingUser);
            // echo '</pre>';
            // // exit();

            return $this->render('auth/registration', ['model' => $pendingUser]);
        }
        return $this->render('auth/registration', ['model' => $pendingUser]);
    }

    public function registerRequest(Request $request)
    {


        $registrationRequest = new RegistrationRequest();
        if ($request->isPOST()) {

            $registrationRequest->loadData($request->getBody());

            // exit();
            $file = $_FILES['verification'];
            $file['name'] = $registrationRequest->email;

            $path = "data/user/request/" . basename($file['name']);

            $registrationRequest->verification = $path;

            if ($registrationRequest->validate() && move_uploaded_file($file['tmp_name'], $path) && $registrationRequest->save()) {

                Application::$app->session->setFlashMessage('success', 'Registration request successfully sent');
                Application::$app->response->redirect('/');
            }
            // echo '<pre>';
            // var_dump($registrationRequest);
            // echo '</pre>';


            return $this->render('auth/registration-request', ['model' => $registrationRequest]);
        }
        return $this->render('auth/registration-request', ['model' => $registrationRequest]);
    }

    public function verifyEmail(Request $request)
    {
        if ($request->isPOST()) {
            $user = new User();

            $user->loadData($request->getBody());

            if ($user->validate() && $user->save()) {
                Application::$app->session->setFlashMessage('success', 'Thanks for verifying and registering');
                Application::$app->response->redirect('/login');
            }

            return $this->render('auth/verify-email', ['model' => $user]);
        }

        $pendingUser = new PendingUser();

        $pendingUser->loadData($request->getBody());

        $where = [
            'email' => $pendingUser->{"email"},
            'token' => $pendingUser->{"token"}
        ];

        $user = $pendingUser->findOne($where);


        return $this->render('auth/verify-email', ['model' => $user]);
    }

    // public function forgotPassword(Request $request)
    // {


    //     if ($request->isPOST()) {

    //         echo '<pre>';
    //         var_dump($user);
    //         echo '</pre>';
    //         exit;
    //     }

    //     return $this->render('auth/forgot-password', ['model' => $user]);
    // }

    public function logout(Request $request)
    {
        Application::$app->logout();
        Application::$app->response->redirect('/');
    }
}

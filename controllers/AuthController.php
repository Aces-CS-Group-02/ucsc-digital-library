<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Mail;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\PendingUser;
use app\models\RegistrationRequest;
use app\models\ResetPassword;
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

                $ucscEmailPattern = "/(.*)@(ucsc.cmb.ac.lk|stu.ucsc.cmb.ac.lk|stu.ucsc.lk)/";
                $isUcscEmail = preg_match($ucscEmailPattern, $email);
                $code = substr(md5(mt_rand()), 0, 15);
                $pendingUser->{"token"} = $code;

                if ($isUcscEmail === 1) {

                    $subject = "Verification Email";
                    $link = "Click <a href='http://localhost:8000/verify-email?email={$email}&token={$code}'>here</a> to verify.";
                    $body    = "<h1>Pleasy verify your email</h1><p>{$link}</p>";
                    $altBody = "this is the alt body";


                    $mail = new Mail([$email], $subject, $body, $altBody);
                    $mail->sendMail();

                    if ($pendingUser->save()) {
                        Application::$app->session->setFlashMessage('success', 'Thanks for registering, verification email sent, check your emails :)');
                        // Application::$app->response->redirect('/');
                        return $this->render('auth/registration-successful');
                    }
                } else {
                    return $this->render('auth/registration-request', ['model' => $pendingUser]);
                }
            }



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

            if ($file['name']) {
                $file['name'] = preg_replace('/[\W]/', '', $registrationRequest->email);

                $path = "data/user/request/" . basename($file['name']);

                $registrationRequest->verification = $path;

                // var_dump($_FILES['verification']);
                // exit;
            }


            if ($registrationRequest->validate()) {

                $file_is_ok =  true;

                if ($file['size'] > 5000000) {
                    $registrationRequest->addError('verification', 'File size should be less tha 5 MB.');
                    $file_is_ok = false;
                }

                if (!($file['type'] == 'image/jpeg' || $file['type'] == 'image/png')) {
                    $registrationRequest->addError('verification', 'File type should be JPEG of PNG.');
                    $file_is_ok = false;
                }

                if (!$file_is_ok) {
                    return $this->render('auth/registration-request', ['model' => $registrationRequest]);
                }else if (move_uploaded_file($file['tmp_name'], $registrationRequest->verification) && $registrationRequest->save()) {
                    var_dump($file['type']);

                    Application::$app->session->setFlashMessage('success', 'Registration request successfully sent');
                    Application::$app->response->redirect('/');
                }
            }



            return $this->render('auth/registration-request', ['model' => $registrationRequest]);
        }
        return $this->render('auth/registration-request', ['model' => $registrationRequest]);
    }

    public function verifyEmail(Request $request)
    {
        if ($request->isPOST()) {
            $user = new User();

            $user->loadData($request->getBody());

            // echo '<pre>';
            // var_dump($user);
            // echo '</pre>';

            $user->role_id = $user->setRoleId();

            // echo '<pre>';
            // var_dump($user);
            // echo '</pre>';

            if ($user->validate() && $user->save()) {
                Application::$app->session->setFlashMessage('success', 'Thank you for registering');
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

        if (!$user) throw new NotFoundException(); //throw not found exception

        return $this->render('auth/verify-email', ['model' => $user]);
    }

    public function forgotPassword(Request $request)
    {
        $input = new ResetPassword();

        if ($request->isPOST()) {

            $input->loadData($request->getBody());

            $input->password = substr(md5(mt_rand()), 0, 15);
            $input->confirm_password = $input->password;

            if ($input->validate()) {
                $email = $input->email;
                $token = substr(md5(mt_rand()), 0, 15);
                $subject = "Reset Password";
                $link = "Click <a href='http://localhost:8000/reset-password?email={$email}&token={$token}'>here</a> to reset your password.";
                $body    = "<h1>Reset your password</h1><p>{$link}</p>";
                $altBody = "this is the alt body";

                $input->token = $token;

                $mail = new Mail([$email], $subject, $body, $altBody);
                $mail->sendMail();

                if ($input->save()) {
                    Application::$app->session->setFlashMessage('success', 'Password reset link has been sent. Check your emails :)');
                    Application::$app->response->redirect('/');
                }
            }

            return $this->render('auth/forgot-password', ['model' => $input]);
        }

        return $this->render('auth/forgot-password', ['model' => $input]);
    }

    public function resetPassword(Request $request)
    {

        if ($request->isPOST()) {
            $input = new ResetPassword();
            $input->loadData($request->getBody());

            if ($input->validate()) {
                $where = [
                    "email" => $input->email
                ];

                $user = new User();

                $user = $user->findOne($where);

                $user->password = $input->password;
                $user->confirm_password =  $input->confirm_password;

                if ($user->update()) {

                    $resetPasswordRequest =  new ResetPassword();

                    $where = [
                        "email" => $input->email,
                        "token" => $input->token
                    ];

                    //token eka enne na


                    $resetPasswordRequest = $resetPasswordRequest->findOne($where);

                    $resetPasswordRequest->delete();

                    Application::$app->session->setFlashMessage('success', 'Yout password is changed');
                    Application::$app->response->redirect('/login');
                }
            }

            return $this->render('auth/reset-password', ['model' => $input]);
        }

        $resetPasswordRequest =  new ResetPassword();

        $resetPasswordRequest->loadData($request->getBody());

        $where = [
            "email" => $resetPasswordRequest->email,
            "token" => $resetPasswordRequest->token
        ];

        if (!$resetPasswordRequest->findOne($where)) throw new NotFoundException(); //throw not found exception

        return $this->render('auth/reset-password', ['model' => $resetPasswordRequest]);
    }


    public function logout(Request $request)
    {
        Application::$app->logout();
        Application::$app->response->redirect('/');
    }
}

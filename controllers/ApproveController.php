<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Mail;
use app\core\middlewares\AuthMiddleware;
use app\core\middlewares\LIAAccessPermissionMiddleware;
use app\core\middlewares\StaffAccessPermissionMiddleware;
use app\core\Request;
use app\models\PendingUser;
use app\models\RegistrationRequest;

class ApproveController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware([]));
        $this->registerMiddleware(new StaffAccessPermissionMiddleware(['approveNewUser']));
    }

    public function approveNewUser(Request $request)
    {
        $registrationRequest = new RegistrationRequest();
        if ($request->isPOST()) {

            $requestData = $request->getBody();

            $where = [
                "request_id" => $requestData["request_id"]
            ];

            $registrationRequest = $registrationRequest->findOne($where);

            if ($registrationRequest) {


                $pendingUser = new PendingUser();
                $code = substr(md5(mt_rand()), 0, 15);

                $pendingUser->first_name = $registrationRequest->first_name;
                $pendingUser->last_name = $registrationRequest->last_name;
                $pendingUser->email = $registrationRequest->email;
                $pendingUser->token = $code;

                $registrationRequest->delete();

                $subject = "Verification Email";
                $link = "Click <a href='http://localhost:8000/verify-email?email={$registrationRequest->email}&token={$code}'>here</a> to verify.";
                $body    = "<h1>Pleasy verify your email</h1><p>{$link}</p>";
                $altBody = "this is the alt body";

                $mail = new Mail([$pendingUser->email], $subject, $body, $altBody);
                $mail->sendMail();

                if ($pendingUser->save()) {
                    Application::$app->session->setFlashMessage('success', 'Selected user is successfully approved');
                    Application::$app->response->redirect('/admin/verify-new-users');
                }
            } else {
                Application::$app->session->setFlashMessage('error', 'The user you are trying to approve does not exist!');
                return $this->render('auth/registration-request');
            }
        }

        $allRequests = $registrationRequest->getAll();

        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_USERS,
            self::BREADCRUM_APPROVE_NEW_USERS
        ];
        return $this->render('admin/user/verify-new-users', ['model' => $allRequests, 'breadcrum' => $breadcrum]);
    }

    public function rejectNewUser(Request $request)
    {
        $registrationRequest = new RegistrationRequest();

        if ($request->isPOST()) {
            $requestData = $request->getBody();

            $where = [
                "request_id" => $requestData["request_id"]
            ];

            $registrationRequest = $registrationRequest->findOne($where);

            echo '<pre>';
            var_dump($registrationRequest);
            echo '</pre>';
            // exit;

            if ($registrationRequest) {
                $subject = "Registration request is rejected";
                // $link = "Click <a href='http://localhost:8000/verify-email?email={$registrationRequest->email}&token={$code}'>here</a> to verify.";
                $body    = "<p>Your registration request is rejected by the administarion.</p>";
                $altBody = "this is the alt body";

                $mail = new Mail([$registrationRequest->email], $subject, $body, $altBody);

                if ($registrationRequest->delete()) {
                    Application::$app->session->setFlashMessage('success', 'Selected user is successfully rejected');
                    Application::$app->response->redirect('/admin/verify-new-users');
                } else {
                    echo '<pre>';
                    var_dump($registrationRequest);
                    echo '</pre>';
                }
            } else {
                Application::$app->session->setFlashMessage('error', 'The user you are trying to approve does not exist!');
                return $this->render('auth/registration-request');
            }
        }
    }
}

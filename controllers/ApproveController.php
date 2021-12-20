<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Mail;
use app\core\middlewares\AuthMiddleware;
use app\core\middlewares\LIAAccessPermissionMiddleware;
use app\core\middlewares\StaffAccessPermissionMiddleware;
use app\core\Request;
use app\models\PendingUser;
use app\models\RegistrationRequest;
use app\models\UserApproval;

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
                $reason = $requestData["reason"];

                $pendingUser->first_name = $registrationRequest->first_name;
                $pendingUser->last_name = $registrationRequest->last_name;
                $pendingUser->email = $registrationRequest->email;
                $pendingUser->token = $code;

                $approvedBy = Application::$app->getUserDisplayName();

                $userApproval = new UserApproval();

                $userApproval->email = $registrationRequest->email;
                $userApproval->is_approved = true;
                $userApproval->reason = $reason;
                $userApproval->approved_by = $approvedBy["firstname"]." ".$approvedBy["lastname"];

                // var_dump($userApproval);
                // if($reason){
                //     echo "reason exists";
                // }

                $registrationRequest->delete();

                $subject = "Verification Email";
                $link = "Click <a href='http://localhost:8000/verify-email?email={$registrationRequest->email}&token={$code}'>here</a> to verify.";
                if ($reason) {
                    $body = "<h3>Thank you for registering to the UCSC Digital Library! Your registration has been approved with the following reason(s).
                                Pleasy verify your email.</h3><p>{$reason}</p><p>{$link}</p>";
                } else {
                    $body = "<h3>Thank you for registering to the UCSC Digital Library! Your registration has been approved.
                                Pleasy verify your email.</h3><p>{$link}</p>";
                }
                $altBody = "this is the alt body";

                $mail = new Mail([$pendingUser->email], $subject, $body, $altBody);
                $mail->sendMail();
                // exit;

                if ($pendingUser->save() && $userApproval->save()) {
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
            $reason = $requestData["reason"];

            $approvedBy = Application::$app->getUserDisplayName();

            $userApproval = new UserApproval();

            $userApproval->email = $registrationRequest->email;
            $userApproval->is_approved = false;
            $userApproval->reason = $reason;
            // $userApproval->approved_by = $approvedBy;
            $userApproval->approved_by = $approvedBy["firstname"]." ".$approvedBy["lastname"];

            // echo '<pre>';
            // var_dump($registrationRequest);
            // echo '</pre>';
            // exit;

            if ($registrationRequest) {
                $subject = "Registration request is rejected";
                // $link = "Click <a href='http://localhost:8000/verify-email?email={$registrationRequest->email}&token={$code}'>here</a> to verify.";
                if ($reason) {
                    $body = "<h3>We are sorry to inform that your registration request has been rejected by the administarion due to the following
                                reason(s).</h3><p>{$reason}</p>";
                } else {
                    $body = "<h3>We are sorry to inform that your registration request has been rejected by the administarion.</h3>";
                }
                $altBody = "this is the alt body";

                $mail = new Mail([$registrationRequest->email], $subject, $body, $altBody);
                $mail->sendMail();

                if ($registrationRequest->delete() && $userApproval->save()) {
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
    public function viewNewUserDetails(Request $request)
    {
        $registrationRequest = new RegistrationRequest;
         $data = $request->getBody();
         $data_keys = array_keys($data);
 
         if(!in_array('id',$data_keys)){
             throw new NotFoundException();
         }
 
         
         $registrationRequest = $registrationRequest->findOne(['request_id' => $data['id']]);
         if($registrationRequest){
             return $this->render('admin/approve/info-approve-new-user',['model' => $registrationRequest]);
         }
         throw new NotFoundException();
 
         
    }
}

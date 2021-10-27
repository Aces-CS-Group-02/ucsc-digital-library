<?php

namespace app\controllers;

use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\middlewares\LIAAccessPermissionMiddleware;
use app\core\middlewares\StaffAccessPermissionMiddleware;
use app\core\Request;
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
        }

        $allRequests = $registrationRequest->getAll();

        return $this->render('admin/user/verify-new-users', ['model' => $allRequests]);
    }
}

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

        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_USERS,
            self::BREADCRUM_APPROVE_NEW_USERS
        ];
        return $this->render('admin/user/verify-new-users', ['model' => $allRequests, 'breadcrum' => $breadcrum]);
    }
}

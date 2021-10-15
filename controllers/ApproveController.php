<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\RegistrationRequest;

class ApproveController extends Controller
{
    public function approveNewUser(Request $request)
    {
        $registrationRequest = new RegistrationRequest();
        if ($request->isPOST()) {
        }

        $allRequests = $registrationRequest->getAll();

        return $this->render('admin/user/verify-new-users', ['model' => $allRequests]);
    }
}

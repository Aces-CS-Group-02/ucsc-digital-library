<?php

namespace app\controllers;

use app\core\Controller;

class DummyController extends Controller
{
    public function test()
    {
        return $this->render('admin/approve/info-approve-content-collection');
    }

}
//  admin/content/admin-inner-manage-content
//  admin/content/admin-bulk-upload
//  admin/content/admin-my-submission
//  admin/approve/info-approve-submission
//  admin/approve/info-verify-new-users
//  admin/approve/info-approve-submission
//  admin/approve/info-approve-user-groups
//  admin/approve/info-approve-content-collection
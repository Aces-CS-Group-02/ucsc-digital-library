<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class DummyController extends Controller
{
    public function test(Request $request)
    {
        if($request->isPOST())
        {
            $users = [];
            foreach($_POST['users'] as $k=>$v){
             $val = intdiv($k,3);
             $users[$val][key($v)]=$v[key($v)];
            }
            $_POST['users']=$users;

            echo"<pre>";
            print_r($_POST);
            exit;
        }
        return $this->render('admin/content/info-publish-content');
    }
}
//admin/content/academic-manage-content-collection
//views\admin\user\admin-report-dashboard.php
// admin/reports/admin-report-dashboard
//  admin/content/admin-inner-manage-content
//  admin/content/admin-bulk-upload
//  admin/content/admin-my-submission
//  admin/approve/info-approve-submission
//  admin/approve/info-verify-new-users
//  admin/approve/info-approve-submission
//  admin/approve/info-approve-user-groups
//  admin/approve/info-approve-content-collection
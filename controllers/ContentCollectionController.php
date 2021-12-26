<?php

namespace app\controllers;

use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Request;

class UsergroupController extends Controller
{

    public function createContentCollection(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_USERS,
            self::BREADCRUM_CREATE_USER_GROUPS
        ];

        // if ($request->getMethod() === 'POST') {
        //     $data = $request->getBody();
        //     $data_keys = array_keys($data);
        //     if (!in_array('name', $data_keys)) throw new NotFoundException();

        //     $usergroupModel = new Usergroup();

        //     $last_inserted_id = $usergroupModel->createUsergroup($data);

        //     if ($last_inserted_id) {
        //         Application::$app->response->redirect('/admin/add-users?usergroup-id=' . $last_inserted_id);
        //         exit;
        //     }
        //     return $this->render("/admin/user/admin-create-user-group", ['model' => $usergroupModel, 'breadcrum' => $breadcrum]);
        // }
        // return $this->render("/admin/user/admin-create-user-group", ['breadcrum' => $breadcrum]);
    }
}

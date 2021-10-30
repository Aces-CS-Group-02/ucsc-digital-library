<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Request;
use app\models\User;
use app\models\Usergroup;

class UsergroupController extends Controller
{
    public function createUserGroup(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            $data = $request->getBody();
            $data_keys = array_keys($data);
            if (!in_array('name', $data_keys)) throw new NotFoundException();

            $usergroupModel = new Usergroup();

            $last_inserted_id = $usergroupModel->createUsergroup($data);
            if ($last_inserted_id) {
                Application::$app->response->redirect('/admin/add-users?usergroup-id=' . $last_inserted_id);
                exit;
            }
            return $this->render("/admin/user/admin-create-user-group", ['model' => $usergroupModel]);
        }
        return $this->render("/admin/user/admin-create-user-group");
    }

    public function addUsers(Request $request)
    {
        $data = $request->getBody();
        $data_keys = array_keys($data);
        if (!in_array('usergroup-id', $data_keys)) throw new NotFoundException();

        $usergroupModel = new Usergroup();

        $user_group = $usergroupModel->findOne(['group_id' => $data['usergroup-id']]);

        if ($user_group) {
            $users_list = $usergroupModel->getAllUsersNotInThisGroup($data['usergroup-id']);
            $this->render('admin/user/add-users', ['group' => $user_group, 'users_list' => $users_list]);
        } else {
            throw new NotFoundException();
        }
    }
}

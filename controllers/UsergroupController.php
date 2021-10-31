<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Request;
use app\models\User;
use app\models\Usergroup;
use app\models\UsergroupUser;

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


    public function pushUserToUserGroup(Request $request)
    {
        $data = $request->getBody();
        $userGroupModel = new UserGroup();
        if ($userGroupModel->pushUserToUserGroup($data['usergroup_id'], $data['user_reg_no'])) {
            Application::$app->session->setFlashMessage('success', 'User added successfully');
            Application::$app->response->redirect('/admin/add-users?usergroup-id=' . $data['usergroup_id']);
        } else {
            Application::$app->session->setFlashMessage('error', 'Something went wrong');
            Application::$app->response->redirect('/admin/add-users?usergroup-id=' . $data['usergroup_id']);
        }
    }


    public function pushUsersToUserGroup(Request $request)
    {
        $data = $request->getBody();
        $users_list = explode(",", $data['reg_no_list']);
        $userGroupModel = new UserGroup();
        if ($userGroupModel->pushUsersToUserGroup($data['usergroup_id'], $users_list)) {
            echo 'success';
            exit;
        }

        echo 'failed';
        exit;
    }


    public function manageUserGroup(Request $request)
    {
        $data = $request->getBody();

        $usergroupModel = new Usergroup();
        $usergroupUserModel = new UsergroupUser();

        $user_group = $usergroupModel->findOne(['group_id' => $data['usergroup-id']]);

        $all_users = $usergroupModel->getAllUsersInUserGroup($data['usergroup-id']);

        $this->render("admin/user/manage-usergroup", ['group' => $user_group, 'users_list' => $all_users]);
    }
}

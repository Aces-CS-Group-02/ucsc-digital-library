<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Request;
use app\models\PendingUserGroup;
use app\models\PendingUsergroupUser;
use app\models\User;
use app\models\Usergroup;
use app\models\UsergroupUser;
use stdClass;

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

        $Search_params = $data['q'] ?? '';

        $page = isset($data['page']) ? $data['page'] : 1;
        $limit = 10;
        $start = ($page - 1) * $limit;

        $usergroupModel = new Usergroup();
        $user_group = $usergroupModel->findOne(['group_id' => $data['usergroup-id']]);

        if ($user_group) {
            $row_count = $usergroupModel->getAllUsersNotInThisGroup(
                $data['usergroup-id'],
                $Search_params,
                true // Fetch row count
            );
            $pageCount = ceil($row_count / $limit);
            $users_list = $usergroupModel->getAllUsersNotInThisGroup(
                $data['usergroup-id'],
                $Search_params,
                false, // Fetch Data
                $start,
                $limit
            );
            $current_Selected_Users = Application::$app->session->get('usergroup_bulk_selection_list');
            $this->render('admin/user/add-users', ['group' => $user_group, 'users_list' => $users_list, 'current_selected_users' => $current_Selected_Users, 'pageCount' => $pageCount, 'currentPage' => $page, 'search_params' => $Search_params]);
        } else {
            throw new NotFoundException();
        }
    }

    public function BulkSelectAndBulkRemoveUser(Request $request)
    {
        $data = $request->getBody();
        $userModel = new User();

        $user_reg_no = $data['user_reg_no'];
        $current_Selected_Users = Application::$app->session->get('usergroup_bulk_selection_list');


        if (!$current_Selected_Users) {
            Application::$app->session->set('usergroup_bulk_selection_list', []);
            $current_Selected_Users = [];
        }

        if ($data['select-action'] === 'true') { // Select request
            if ($userModel->findOne(['reg_no' => $user_reg_no]) && !in_array($user_reg_no, $current_Selected_Users)) {
                array_push($current_Selected_Users, $user_reg_no);
                Application::$app->session->set('usergroup_bulk_selection_list', $current_Selected_Users);
                // echo 'success' . count($current_Selected_Users);
                // echo '[{status:"success", count:"' . count($current_Selected_Users) . '"}]';

                $responseObj = new stdClass();
                $responseObj->status = "success";
                $responseObj->count = count($current_Selected_Users);
                $myJSON = json_encode($responseObj);
                echo $myJSON;
                exit;
            }
        } else { // Deselect request
            if (in_array($user_reg_no, $current_Selected_Users)) {
                $pos = array_search($user_reg_no, $current_Selected_Users);
                unset($current_Selected_Users[$pos]);
                Application::$app->session->set('usergroup_bulk_selection_list', $current_Selected_Users);
                $responseObj = new stdClass();
                $responseObj->status = "success";
                $responseObj->count = count($current_Selected_Users);
                $myJSON = json_encode($responseObj);
                echo $myJSON;
                exit;
            }
        }
        echo 'failed';
        exit;
    }

    public function removeUser(Request $request)
    {
        $data = $request->getBody();
        var_dump($data);
        $usergroupUserModel = new UsergroupUser();
        // $usergroupUserModel->removeUser($data['usergroup_id'], $data['user_reg_no']);
    }


    public function pushUserToUserGroup(Request $request)
    {
        $data = $request->getBody();

        echo '<pre>';
        var_dump($data);
        echo '</pre>';

        // $userGroupModel = new UserGroup();
        // if ($userGroupModel->pushUserToUserGroup($data['usergroup_id'], $data['user_reg_no'])) {
        //     Application::$app->session->setFlashMessage('success', 'User added successfully');
        //     Application::$app->response->redirect('/admin/add-users?usergroup-id=' . $data['usergroup_id']);
        // } else {
        //     Application::$app->session->setFlashMessage('error', 'Something went wrong');
        //     Application::$app->response->redirect('/admin/add-users?usergroup-id=' . $data['usergroup_id']);
        // }
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


    public function createCustomUserGroup(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            $data = $request->getBody();
            $data_keys = array_keys($data);
            if (!in_array('name', $data_keys)) throw new NotFoundException();

            $usergroupModel = new PendingUserGroup();
            $last_inserted_id = $usergroupModel->createCustomUsergroup($data);

            if ($last_inserted_id) {
                Application::$app->response->redirect('/admin/custom-usergroup/add-users?usergroup-id=' . $last_inserted_id);
                exit;
            }
            return $this->render("/admin/user/admin-create-user-group", ['model' => $usergroupModel]);
        }
        return $this->render("/admin/user/admin-create-user-group");
    }

    public function addUsersToCustomUserGroup(Request $request)
    {
        $data = $request->getBody();
        $data_keys = array_keys($data);
        if (!in_array('usergroup-id', $data_keys)) throw new NotFoundException();

        $usergroupModel = new PendingUserGroup();
        $user_group = $usergroupModel->findOne(['group_id' => $data['usergroup-id']]);

        if ($user_group) {
            $users_list = $usergroupModel->getAllUsersNotInThisGroup($data['usergroup-id']);
            $this->render('admin/user/add-users-to-custom-group', ['group' => $user_group, 'users_list' => $users_list]);
            exit;
        }
        throw new NotFoundException();


        // } else {
        // throw new NotFoundException();
        // }
    }

    public function pushUserToCustomUserGroup(Request $request)
    {
        $data = $request->getBody();
        $userGroupModel = new PendingUserGroup();
        if ($userGroupModel->pushUserToUserGroup($data['usergroup_id'], $data['user_reg_no'])) {
            Application::$app->session->setFlashMessage('success', 'User added successfully');
            Application::$app->response->redirect('/admin/custom-usergroup/add-users?usergroup-id=' . $data['usergroup_id']);
        } else {
            Application::$app->session->setFlashMessage('error', 'Something went wrong');
            Application::$app->response->redirect('/admin/custom-usergroup/add-users?usergroup-id=' . $data['usergroup_id']);
        }
    }

    public function manageCustomUserGroup(Request $request)
    {
        $data = $request->getBody();

        $usergroupModel = new PendingUserGroup();
        $usergroupUserModel = new PendingUsergroupUser();

        $user_group = $usergroupModel->findOne(['group_id' => $data['usergroup-id']]);

        $all_users = $usergroupModel->getAllUsersInUserGroup($data['usergroup-id']);

        $this->render("admin/user/manage-custom-usergroup", ['group' => $user_group, 'users_list' => $all_users]);
    }

    public function requestApprovalForCustomUserGroup(Request $request)
    {
        $data = $request->getBody();
        $usergroupModel = new PendingUserGroup();
        if ($usergroupModel->requestApproval($data['custom_usergroup_id'])) {
            Application::$app->session->setFlashMessage('success', 'Submitted to aprrove');
        } else {
            Application::$app->session->setFlashMessage('error', 'Something went wrong');
        }
        Application::$app->response->redirect('/admin/my-usergroups');
    }

    public function manageMyUsergroups(Request $request)
    {
        $this->render('admin/user/my-user-groups');
    }
}

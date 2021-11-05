<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Request;
use app\models\PendingUserGroup;
use app\models\PendingUsergroupUser;
use app\models\User;
use app\models\UserGroup;
use app\models\UsergroupUser;
use stdClass;

class UsergroupController extends Controller
{
    public function createUserGroup(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_USERS,
            self::BREADCRUM_CREATE_USER_GROUPS
        ];

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
            return $this->render("/admin/user/admin-create-user-group", ['model' => $usergroupModel, 'breadcrum' => $breadcrum]);
        }
        return $this->render("/admin/user/admin-create-user-group", ['breadcrum' => $breadcrum]);
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

            $paginateController = new PaginatePathController();

            if (($page > $pageCount)) {
                if ($pageCount) {
                    $path = $paginateController->getNewPath($pageCount);
                    Application::$app->response->redirect($path);
                    exit;
                }
            }

            $paginateController->validatePage($page, $pageCount);

            $users_list = $usergroupModel->getAllUsersNotInThisGroup(
                $data['usergroup-id'],
                $Search_params,
                false, // Fetch Data
                $start,
                $limit
            );

            $breadcrum = [
                self::BREADCRUM_DASHBOARD,
                self::BREADCRUM_MANAGE_USERS,
                self::BREADCRUM_MANAGE_USERGROUPS
            ];

            array_push($breadcrum, ['name' => $user_group->name, 'link' => "/admin/manage-usergroup?usergroup-id=$user_group->group_id"]);

            array_push($breadcrum, self::BREADCRUM_ADD_USERGROUP_USERS);



            $this->render('admin/user/add-users', ['group' => $user_group, 'users_list' => $users_list, 'pageCount' => $pageCount, 'currentPage' => $page, 'search_params' => $Search_params, 'breadcrum' => $breadcrum]);
        } else {
            throw new NotFoundException();
        }
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
        $userGroupModel = new UserGroup();

        if (isset($data['bulk_select_users_list'])) {
            $arr = explode(',', $data['bulk_select_users_list']);
            if ($userGroupModel->pushUsersToUserGroup($data['usergroup_id'], $arr)) {
                Application::$app->session->setFlashMessage('success', 'Users added successfully');
            } else {
                Application::$app->session->setFlashMessage('error', 'Something went wrong');
            }
        } else {
            if ($userGroupModel->pushUserToUserGroup($data['usergroup_id'], $data['user_reg_no'])) {
                Application::$app->session->setFlashMessage('success', 'User added successfully');
            } else {
                Application::$app->session->setFlashMessage('error', 'Something went wrong');
            }
        }

        $current_path = $_SERVER['REQUEST_URI'] ?? "/";
        Application::$app->response->redirect($current_path);
    }



    public function manageUserGroup(Request $request)
    {
        $data = $request->getBody();

        $Search_params = $data['q'] ?? '';
        $page = isset($data['page']) ? $data['page'] : 1;
        $limit = 10;
        $start = ($page - 1) * $limit;

        $usergroupModel = new Usergroup();
        $usergroupUserModel = new UsergroupUser();

        $user_group = $usergroupModel->findOne(['group_id' => $data['usergroup-id']]);
        if (!$user_group) throw new NotFoundException();


        $row_count = $usergroupModel->getAllUsersInUserGroup(
            $data['usergroup-id'],
            $Search_params,
            true // Fetch row count
        );
        $pageCount = ceil($row_count / $limit);

        $paginateController = new PaginatePathController();

        if (($page > $pageCount)) {
            if ($pageCount) {
                $path = $paginateController->getNewPath($pageCount);
                Application::$app->response->redirect($path);
                exit;
            }
        }

        $paginateController->validatePage($page, $pageCount);

        $users_list = $usergroupModel->getAllUsersInUserGroup(
            $data['usergroup-id'],
            $Search_params,
            false, // Fetch Data
            $start,
            $limit
        );


        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_USERS,
            self::BREADCRUM_MANAGE_USERGROUPS
        ];

        array_push($breadcrum, ['name' => $user_group->name, 'link' => "/admin/manage-usergroup?usergroup-id=$user_group->group_id"]);

        $this->render("admin/user/manage-usergroup", ['group' => $user_group, 'users_list' => $users_list, 'pageCount' => $pageCount, 'currentPage' => $page, 'search_params' => $Search_params, 'breadcrum' => $breadcrum]);
    }


    public function manageAllUserGroups(Request $request)
    {

        $data = $request->getBody();
        $Search_params = $data['q'] ?? '';
        $page = isset($data['page']) ? $data['page'] : 1;
        $limit = 10;
        $start = ($page - 1) * $limit;

        $usergroupModel = new UserGroup();

        $row_count = $usergroupModel->getAllUsergroups(
            $Search_params,
            true // Fetch row count
        );
        $pageCount = ceil($row_count / $limit);
        $paginateController = new PaginatePathController();
        if (($page > $pageCount)) {
            if ($pageCount) {
                $path = $paginateController->getNewPath($pageCount);
                Application::$app->response->redirect($path);
                exit;
            }
        }
        $paginateController->validatePage($page, $pageCount);

        $usergroups = $usergroupModel->getAllUsergroups(
            $Search_params,
            false, // Fetch Data
            $start,
            $limit
        );

        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_USERS,
            self::BREADCRUM_MANAGE_USERGROUPS
        ];

        $this->render('admin/user/manage-all-user-groups', ['usergroups' => $usergroups, 'pageCount' => $pageCount, 'currentPage' => $page, 'search_params' => $Search_params, 'breadcrum' => $breadcrum]);
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

<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\DbModel;
use app\core\exception\NotFoundException;
use app\core\middlewares\AuthMiddleware;
use app\core\middlewares\LIAAccessPermissionMiddleware;
use app\core\middlewares\StaffAccessPermissionMiddleware;
use app\core\middlewares\StudentsAccessPermissionMiddleware;
use app\core\Request;
use app\models\User;
use app\models\UserGroup;
use app\models\UsergroupUser;
use PDO;
use stdClass;

class UsergroupController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware([]));

        $this->registerMiddleware(new StaffAccessPermissionMiddleware(
            [
                'approveUserGroup',
                'approveUGRequest',
                'rejectUserGroup'
            ]
        ));

        $this->registerMiddleware(new StudentsAccessPermissionMiddleware([]));
    }

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

            $usergroupModel = new UserGroup();

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

        $usergroupModel = new UserGroup();


        $user_group = $usergroupModel->findOne(['id' => $data['usergroup-id']]);

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

            array_push($breadcrum, ['name' => $user_group->name, 'link' => "/admin/manage-usergroup?usergroup-id=$user_group->id"]);

            array_push($breadcrum, self::BREADCRUM_ADD_USERGROUP_USERS);



            $this->render('admin/user/add-users', ['group' => $user_group, 'users_list' => $users_list, 'pageCount' => $pageCount, 'currentPage' => $page, 'search_params' => $Search_params, 'breadcrum' => $breadcrum]);
        } else {
            throw new NotFoundException();
        }
    }

    public function removeUser(Request $request)
    {
        $data = $request->getBody();
        // Validate request params
        $req_arr_keys = array_keys($data);
        if (!in_array('usergroup_id', $req_arr_keys) || !in_array('user_reg_no', $req_arr_keys)) throw new NotFoundException();

        $usergroupUserModel = new UsergroupUser();

        if ($usergroupUserModel->removeUser($data['usergroup_id'], $data['user_reg_no'])) {
            $usergroup = $data['usergroup_id'];
            Application::$app->response->redirect("/admin/manage-usergroup?usergroup-id=$usergroup");
        }
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


        $usergroupModel = new UserGroup();



        $user_group = $usergroupModel->findOne(['id' => $data['usergroup-id']]);
        if (!$user_group) throw new NotFoundException();


        $show_request_approval_btn = false;
        if ($user_group->status === 3) $show_request_approval_btn = true;


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

        array_push($breadcrum, ['name' => $user_group->name, 'link' => "/admin/manage-usergroup?usergroup-id=$user_group->id"]);

        $this->render("admin/user/manage-usergroup", ['group' => $user_group, 'users_list' => $users_list, 'pageCount' => $pageCount, 'currentPage' => $page, 'search_params' => $Search_params, 'breadcrum' => $breadcrum, 'show_request_approval_btn' => $show_request_approval_btn]);
    }


    public function manageAllUserGroups(Request $request)
    {

        $data = $request->getBody();
        $Search_params = $data['q'] ?? '';
        $page = isset($data['page']) ? $data['page'] : 1;
        $limit = 10;
        $start = ($page - 1) * $limit;

        $usergroupModel = new UserGroup();


        $result = $usergroupModel->getAllUsergroups($Search_params, $start, $limit);
        if (!$result) throw new NotFoundException;


        if (($result->pageCount != 0 && $page > $result->pageCount) || $page <= 0) throw new NotFoundException();


        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_USERS,
            self::BREADCRUM_MANAGE_USERGROUPS
        ];


        if (Application::getUserRole() <= 2) {
            $is_library_staff_member = true;
        } else if (Application::getUserRole() === 3) {
            $is_library_staff_member = false;
        }

        $this->render('admin/user/manage-all-user-groups', ['usergroups' => $result->payload, 'pageCount' => $result->pageCount, 'currentPage' => $page, 'search_params' => $Search_params, 'breadcrum' => $breadcrum, 'is_library_staff_member' => $is_library_staff_member]);
    }





    public function getAllLiveUsergroups(Request $request)
    {
        $data = $request->getBody();

        $Search_params = $data['q'] ?? '';
        $page = isset($data['page']) ? $data['page'] : 1;
        $limit = 10;
        $start = ($page - 1) * $limit;

        $usergroupModel = new UserGroup();

        $usergroups = $usergroupModel->getAllLiveUsergroups($Search_params, $start, $limit);

        // $row_count = $usergroupModel->getAllLiveUsergroups(
        //     $Search_params,
        //     true // Fetch row count
        // );
        // $pageCount = ceil($row_count / $limit);
        // $paginateController = new PaginatePathController();
        // if (($page > $pageCount)) {
        //     if ($pageCount) {
        //         $path = $paginateController->getNewPath($pageCount);
        //         Application::$app->response->redirect($path);
        //         exit;
        //     }
        // }
        // $paginateController->validatePage($page, $pageCount);

        // $usergroups = $usergroupModel->getAllLiveUsergroups(
        //     $Search_params,
        //     false, // Fetch Data
        //     $start,
        //     $limit
        // );

        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_USERS,
            self::BREADCRUM_VIEW_ALL_USER_GROUPS
        ];


        $this->render('admin/user/view-all-user-groups', ['usergroups_list' => $usergroups->payload, 'pageCount' => $usergroups->pageCount, 'currentPage' => $page, 'search_params' => $Search_params, 'breadcrum' => $breadcrum]);
    }


    public function requestApproval(Request $request)
    {
        $data  = $request->getBody();
        $usergroupModel = new UserGroup();

        var_dump($data);

        $res = $usergroupModel->requestApproval($data['group_id']);

        if ($res) {
            Application::$app->session->setFlashMessage('success', 'Request made successfull.');
        } else {
            Application::$app->session->setFlashMessage('error', 'Something went wrong.');
        }
        Application::$app->response->redirect('/admin/manage-usergroups');
    }

    public function removeGroup(Request $request)
    {
        $data = $request->getBody();

        $usergroupModel = new UserGroup();

        $res = $usergroupModel->removeGroup($data['group_id']);

        if ($res) {
            Application::$app->session->setFlashMessage('success', 'Request made successfull.');
        } else {
            Application::$app->session->setFlashMessage('error', 'Request made successfull.');
        }

        Application::$app->response->redirect('/admin/manage-usergroups');
    }


    public function approveUserGroup(Request $request)
    {
        $data = $request->getBody();
        $page = isset($data['page']) ? $data['page'] : 1;
        $limit  = 5;
        $start = ($page - 1) * $limit;
        $Search_params = $data['q'] ?? '';

        $usergroupModel = new UserGroup();
        $result = $usergroupModel->getAllRequests($Search_params, $start, $limit);



        if (!$result) throw new NotFoundException;
        if (($result->pageCount != 0 && $page > $result->pageCount) || $page <= 0) throw new NotFoundException();

        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_APPROVALS,
            self::BREADCRUM_APPROVE_USER_GROUPS
        ];

        return $this->render("admin/approve/approve-user-groups", ['breadcrum' => $breadcrum, 'requests' => $result->payload, 'pageCount' => $result->pageCount, 'currentPage' => $page]);
    }

    public function approveUGRequest(Request $request)
    {
        $data = $request->getBody();

        var_dump($data);

        $usergroupModel = new UserGroup();
        $res = $usergroupModel->approve($data['group-id']);

        if ($res) {
            Application::$app->session->setFlashMessage('success', 'Request made successfull.');
        } else {
            Application::$app->session->setFlashMessage('error', 'Something went wrong.');
        }

        Application::$app->response->redirect('/admin/approve-user-groups');
    }

    public function rejectUserGroup(Request $request)
    {
        $data = $request->getBody();

        $usergroupModel = new UserGroup();
        $res = $usergroupModel->reject($data['req_id'], $data['message']);

        if ($res) {
            Application::$app->session->setFlashMessage('success', 'Request made successfull.');
        } else {
            Application::$app->session->setFlashMessage('error', 'Something went wrong.');
        }

        Application::$app->response->redirect('/admin/approve-user-groups');
    }
}

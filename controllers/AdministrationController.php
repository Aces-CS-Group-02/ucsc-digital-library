<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\ForbiddenException;
use app\core\exception\NotFoundException;
use app\core\middlewares\AuthMiddleware;
use app\core\middlewares\LIAAccessPermissionMiddleware;
use app\core\middlewares\StaffAccessPermissionMiddleware;
use app\core\middlewares\StudentsAccessPermissionMiddleware;
use app\core\Request;
use app\models\PendingUserGroup;
use app\models\User;
use app\models\UserGroup;
use ErrorException;
use Exception;

class AdministrationController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware([]));

        $this->registerMiddleware(new LIAAccessPermissionMiddleware(
            [
                'createLibraryInformationAssistant',
                'removeLibraryInformationAssistant'
            ]
        ));

        $this->registerMiddleware(new StaffAccessPermissionMiddleware(
            [
                'manageApprovalsDashboard',
                'bulkUpload',
                'publishContent',
                'unpublishContent',
                'bulkRegister',
                'reviewUserGroup',
                'approveContentGroup',
                'approveUserGroup',
                'manageUsers',
            ]
        ));

        $this->registerMiddleware(new StudentsAccessPermissionMiddleware([]));
    }

    public function createLibraryInformationAssistant(Request $request)
    {
        $data = $request->getBody();
        $userModel = new User();

        $user = $userModel->findOne(['reg_no' => $data['reg_no']]);

        // Set academic/non academic staff member role ID here
        if ($user && $user->role_id == 3) {
            $userModel->loadData($user);


            $updateRequiredFields = ['role_id'];

            if ($userModel->upgradeToLIA() && $userModel->update($updateRequiredFields)) {
                Application::$app->session->setFlashMessage('success', 'Created new library information assistant');
                Application::$app->response->redirect('/admin/manage-library-information-assistant');
            } else {
                Application::$app->session->setFlashMessage('error', "Couldn't upgarade to library information assistant ");
                return $this->render("admin/manage-library-information-assistant");
            }
        } else {
            throw new NotFoundException();
        }
    }


    public function removeLibraryInformationAssistant(Request $request)
    {
        $data = $request->getBody();

        $userModel = new User();
        $user = $userModel->findOne(['reg_no' => $data['reg_no']]);

        //  Set LIA role id here
        if ($user && $user->role_id == 2) {
            $userModel->loadData($user);
        } else {
            Application::$app->session->setFlashMessage('error', "Something went wrong");
            Application::$app->response->redirect('/admin/manage-library-information-assistant');
            exit;
        }

        $updateRequiredFields = ['role_id'];

        if ($userModel->removeLIA() && $userModel->update($updateRequiredFields)) {
            Application::$app->session->setFlashMessage('success', 'Removed library information assistant');
            Application::$app->response->redirect('/admin/manage-library-information-assistant');
        } else {
            Application::$app->session->setFlashMessage('error', "Couldn't remove library information assistant");
            Application::$app->response->redirect('/admin/manage-library-information-assistant');
        }
    }


    public function adminDashboard(Request $request)
    {
        return $this->render("admin/admin-dashboard");
    }

    public function manageContentDashboard(Request $request)
    {
        return $this->render("admin/content/admin-manage-content");
    }

    public function manageUsersDashboard(Request $request)
    {
        return $this->render("admin/user/admin-manage-users");
    }


    public function manageApprovalsDashboard(Request $request)
    {
        return $this->render("admin/approve/admin-approvals");
    }

    public function bulkUpload(Request $request)
    {
        return $this->render("admin/content/bulk-upload");
    }

    public function uploadContent(Request $request)
    {
        return $this->render("admin/content/admin-upload-content");
    }

    public function publishContent(Request $request)
    {
        return $this->render("admin/content/publish-content");
    }

    public function unpublishContent(Request $request)
    {
        return $this->render("admin/content/unpublish-content");
    }

    public function editMetadata(Request $request)
    {
        return $this->render("admin/content/admin-add-update-metadata");
    }

    public function removeContent(Request $request)
    {
        return $this->render("admin/content/delete-content");
    }


    public function bulkRegister(Request $request)
    {
        if ($request->getMethod() === 'GET') {
            return $this->render("admin/user/admin-bulk-registering");
        }

        if ($request->getMethod() === 'POST') {
            return $this->render("admin/user/bulk-register");
        }
    }

    public function manageUsers(Request $request)
    {
        return $this->render("admin/user/users-view-update-delete");
    }

    public function createUserGroup(Request $request)
    {
        if ($request->getMethod() === 'POST') {

            $data = $request->getBody();

            if (Application::getUserRole() <= 2) {
                $userGroupModel = new UserGroup();
                $last_id = $userGroupModel->createUserGroup($data);
                if ($last_id) {
                    echo $last_id;
                    Application::$app->response->redirect('/admin/add-users?usergroup-id=' . $last_id);
                } else {
                    return $this->render("admin/user/admin-create-user-group", ['model' => $userGroupModel]);
                }
            } else if (Application::getUserRole() === 3) {
                $pendingUserGroupModel = new PendingUserGroup();
                if ($pendingUserGroupModel->createPendingUserGroup($data)) {
                    Application::$app->response->redirect('/admin/manage-my-user-groups');
                } else {
                    return $this->render("admin/user/admin-create-user-group", ['model' => $pendingUserGroupModel]);
                }
            } else {
                throw new ForbiddenException();
            }
        } else {
            return $this->render("admin/user/admin-create-user-group");
        }
    }

    public function manageMyUserGroups(Request $request)
    {
        $userGroupModel = new UserGroup();
        $user_groups_of_this_owner =  $userGroupModel->findUserGroups(['creator_reg_no' => Application::$app->user->reg_no]);


        return $this->render("admin/user/manage-my-user-groups", ['user-groups' => $user_groups_of_this_owner]);
    }

    public function addUsersToUserGroup(Request $request)
    {
        $data = $request->getBody();
        $userGroupModel = new UserGroup();
        $user_group = $userGroupModel->findOne(['group_id' => $data['usergroup-id']]);
        if ($user_group) {
            $users_list = $userGroupModel->getAllUsersNotInThisGroup($data['usergroup-id']);
            $this->render('admin/user/add-users', ['group' => $user_group, 'users_list' => $users_list]);
        } else {
            throw new NotFoundException();
        }
    }

    public function pushUserToUserGroup(Request $request)
    {
        $data = $request->getBody();
        $userGroupModel = new UserGroup();
        if ($userGroupModel->pushUserToUserGroup($data['usergroup_id'], $data['reg_no_list'])) {
            echo "success";
            exit;
        }

        echo 'failed';
        exit;
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

    public function reviewUserGroup(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            return $this->render("admin/user/review-user-group");
        }
    }

    public function manageUserGroup(Request $request)
    {
        return $this->render("admin/user/user-groups-vud");
    }

    public function approveContentGroup(Request $request)
    {
        return $this->render("admin/approve/approve-content-categories");
    }

    public function approveUserGroup(Request $request)
    {
        return $this->render("admin/approve/approve-user-groups");
    }
}

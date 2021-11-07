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
                'manageLibraryInformationAssistant',
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

    public function manageLibraryInformationAssistant(Request $request)
    {
        $userModel = new User();
        $allLIAMembers =  $userModel->findAll(['role_id' => 2]); // Set LIA role_id here

        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_USERS,
            self::BREADCRUM_MANAGE_LIA
        ];
        $this->render("admin/manage-library-information-assistant", ['allStaffMembers' => $allLIAMembers, 'breadcrum' => $breadcrum]);
    }

    public function createLibraryInformationAssistant(Request $request)
    {
        $userModel = new User();

        if ($request->getMethod() === 'GET') {
            $allStaffMembers =  $userModel->findAll(['role_id' => 3]); // Set Academic-Non academic staff role_id here

            $breadcrum = [
                self::BREADCRUM_DASHBOARD,
                self::BREADCRUM_MANAGE_USERS,
                self::BREADCRUM_MANAGE_LIA,
                self::BREADCRUM_CREATE_LIA

            ];
            $this->render("admin/create-library-information-assistant", ['allStaffMembers' => $allStaffMembers, 'breadcrum' => $breadcrum]);
        } else {
            $data = $request->getBody();
            $user = $userModel->findOne(['reg_no' => $data['reg_no']]);
            // Set academic/non academic staff member role ID here
            if ($user && $user->role_id == 3) {
                $userModel->loadData($user);
                $updateRequiredFields = ['role_id'];
                if ($userModel->upgradeToLIA() && $userModel->updateLIA($updateRequiredFields)) {
                    Application::$app->session->setFlashMessage('success', 'Created new library information assistant');
                    Application::$app->response->redirect('/admin/manage-library-information-assistant');
                } else {
                    Application::$app->session->setFlashMessage('error', "Couldn't upgarade to library information assistant ");
                    $breadcrum = [
                        self::BREADCRUM_DASHBOARD,
                        self::BREADCRUM_MANAGE_USERS,
                        self::BREADCRUM_APPROVE_NEW_USERS
                    ];
                    return $this->render("admin/manage-library-information-assistant", ['breadcrum' => $breadcrum]);
                }
            } else {
                throw new NotFoundException();
            }
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

        if ($userModel->removeLIA() && $userModel->updateLIA($updateRequiredFields)) {
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
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT
        ];
        return $this->render("admin/content/admin-manage-content", ['breadcrum' => $breadcrum]);
    }

    public function manageUsersDashboard(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_USERS
        ];
        return $this->render("admin/user/admin-manage-users", ['breadcrum' => $breadcrum]);
    }


    public function manageApprovalsDashboard(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_APPROVALS
        ];
        return $this->render("admin/approve/admin-approvals", ['breadcrum' => $breadcrum]);
    }

    public function bulkUpload(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_BULK_UPLOAD
        ];
        return $this->render("admin/content/admin-bulk-upload", ['breadcrum' => $breadcrum]);
    }

    public function bulkUploadReview(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_BULK_UPLOAD,
            self::BREADCRUM_BULK_UPLOAD_REVIEW
        ];
        return $this->render("admin/content/bulk-upload", ['breadcrum' => $breadcrum]);
    }

    public function uploadContent(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_UPLOAD_CONTENT
        ];
        return $this->render("admin/content/admin-upload-content", ['breadcrum' => $breadcrum]);
    }

    public function publishContent(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_PUBLISH_CONTENT
        ];
        return $this->render("admin/content/publish-content", ['breadcrum' => $breadcrum]);
    }

    public function unpublishContent(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_UNPUBLISH_CONTENT
        ];
        return $this->render("admin/content/unpublish-content", ['breadcrum' => $breadcrum]);
    }

    public function editMetadata(Request $request)
    {
        return $this->render("admin/content/admin-add-update-metadata");
    }

    public function removeContent(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_REMOVE_CONTENT
        ];
        return $this->render("admin/content/delete-content", ['breadcrum' => $breadcrum]);
    }


    public function bulkRegister(Request $request)
    {
        if ($request->getMethod() === 'GET') {
            $breadcrum = [
                self::BREADCRUM_DASHBOARD,
                self::BREADCRUM_MANAGE_USERS,
                self::BREADCRUM_BULK_REGISTER
            ];
            return $this->render("admin/user/admin-bulk-registering", ['breadcrum' => $breadcrum]);
        }

        if ($request->getMethod() === 'POST') {
            $breadcrum = [
                self::BREADCRUM_DASHBOARD,
                self::BREADCRUM_MANAGE_USERS,
                self::BREADCRUM_BULK_REGISTER
            ];
            return $this->render("admin/user/bulk-register", ['breadcrum' => $breadcrum]);
        }
    }

    public function manageUsers(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_USERS,
            self::BREADCRUM_UPDATE_USERS
        ];

        $users = new User();

        $users = $users->getAll();

        // echo '<pre>';
        // var_dump($users);
        // echo '</pre>';

        return $this->render("admin/user/users-view-update-delete", ['breadcrum' => $breadcrum , 'users' => $users]);
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

    public function manageContentCollections(Request $request)
    {
        return $this->render("admin/content/academic-manage-content-collection");
    }

    public function createContentCollection(Request $request)
    {
        return $this->render("admin/content/admin-create-content-collections");
    }

    public function contentCollections(Request $request)
    {
        return $this->render("admin/content/view-all-content-collections");
    }
    
    public function approveSubmissions(Request $request)
    {
        return $this->render("admin/approve/admin-approve-submission");
    }

    public function viewReports(Request $request)
    {
        return $this->render("admin/reports/admin-report-dashboard");
    }
}

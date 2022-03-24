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
use app\models\Content;
use app\models\PendingUser;
use app\models\User;
use app\models\UserApproval;
use app\models\UserGroup;
use app\models\UsersLoginCount;
use ErrorException;
use Exception;
use stdClass;

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

    public function manageAccess()
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_APPROVALS
        ];
        return $this->render("admin/approve/admin-approve-access", ['breadcrum' => $breadcrum]);
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

            $file = $_FILES['sheet'];

            move_uploaded_file($file['tmp_name'], "temp/sheet.csv");

            $file = fopen("temp/sheet.csv", "r");

            print_r(fgetcsv($file));

            $userArray = [];

            while (!feof($file)) {
                $user = new PendingUser();

                $row = fgetcsv($file);

                $user->first_name = $row[0];
                $user->last_name = $row[1];
                $user->email = $row[2];

                $user->validate();

                array_push($userArray, $user);

                print_r($userArray);
            }

            fclose($file);
            unlink("temp/sheet.csv");

            // exit;

            $breadcrum = [
                self::BREADCRUM_DASHBOARD,
                self::BREADCRUM_MANAGE_USERS,
                self::BREADCRUM_BULK_REGISTER
            ];
            return $this->render("admin/user/bulk-register", ['breadcrum' => $breadcrum, 'users' => $userArray]);
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

        return $this->render("admin/user/users-view-update-delete", ['breadcrum' => $breadcrum, 'users' => $users]);
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
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_APPROVALS,
            self::BREADCRUM_APPROVE_CONTENT_COLLECTIONS
        ];

        return $this->render("admin/approve/approve-content-categories", ['breadcrum' => $breadcrum]);
    }

    public function approveUserGroup(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_APPROVALS,
            self::BREADCRUM_APPROVE_USER_GROUPS
        ];

        return $this->render("admin/approve/approve-user-groups", ['breadcrum' => $breadcrum]);
    }

    public function createContentCollection(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_CREATE_CONTENT_COLLECTION
        ];
        return $this->render("admin/content/admin-create-content-collections", ['breadcrum' => $breadcrum]);
    }

    public function contentCollections(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_CONTENT_COLLECTIONS
        ];
        return $this->render("admin/content/view-all-content-collections", ['breadcrum' => $breadcrum]);
    }

    public function approveSubmissions(Request $request)
    {


        if ($request->isPOST()) {
        } else {

            $data = $request->getBody();

            $search_params =  $data['q'] ?? '';
            $page = isset($data['page']) ? $data['page'] : 1;
            if($page <= 0) $page = 1;
            $limit = 10;
            $start = ($page - 1) * $limit;

            $contents =  new Content();

            $contents = $contents -> getAllUnapprovedContent($search_params, $start, $limit);

            // echo '<pre>';
            // var_dump($contents);
            // echo '</pre>';
            // exit;

            foreach($contents->payload as $content)
            {
                $user = new User();
                $user = $user->findOne(['reg_no'=>$content->uploaded_by]);
                // var_dump($user->first_name + $user->last_name);

                $content->uploader = $user->first_name ." ".$user->last_name;
            }

            $breadcrum = [
                self::BREADCRUM_DASHBOARD,
                self::BREADCRUM_MANAGE_APPROVALS,
                self::BREADCRUM_APPROVE_SUBMISSIONS
            ];

            return $this->render("admin/approve/admin-approve-submission", ['breadcrum' => $breadcrum, 'contents'=>$contents->payload,'currentPage' => $page, 'pageCount' => $contents->pageCount, 'search_params' => $search_params]);
        }
    }

    public function viewReports(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_VIEW_REPORTS
        ];
        return $this->render("admin/reports/admin-report-dashboard", ['breadcrum' => $breadcrum]);
    }

    public function viewApprovalsReport(Request $request)
    {
        $userApproval = new UserApproval();
        $userList = $userApproval->getAll();
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_VIEW_REPORTS,
            self::BREADCRUM_USER_APPROVALS_REPORT
        ];
        return $this->render("admin/reports/user-approvals-report", ['breadcrum' => $breadcrum, 'userList' => $userList]);
    }

    public function viewLoginReport(Request $request)
    {
        $data = $request->getBody();
        $Search_params = $data['search-data'] ?? '';
        $page = isset($data['page']) ? $data['page'] : 1;
        $limit = 15;
        $start = ($page - 1) * $limit;

        $users = new User();
        $usersLoginCount = new UsersLoginCount();
        $loginData = $usersLoginCount->getLastRecords();

        $array = [];
        foreach ($loginData as $login) {

            $temp = new stdClass;
            $temp->x = $login->date;
            $temp->y = (int)$login->count;
            array_push($array, $temp);
        }
        $array = json_encode($array);

        if ($page <= 0) throw new NotFoundException;


        $result = $users->getUsersOrderedByLoginTime($Search_params, $start, $limit);
        if (($result->pageCount != 0 && $page > $result->pageCount)) throw new NotFoundException();


        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_VIEW_REPORTS,
            self::BREADCRUM_USERS_LOGIN_REPORT
        ];
        // echo '<pre>';
        // var_dump($result);
        // echo '</pre>';
        // exit;

        return $this->render("admin/reports/users-login-report", ['breadcrum' => $breadcrum, 'userList' => $result->payload, 'pageCount' => $result->pageCount, 'currentPage' => $page, 'search_params' => $Search_params, 'resultCount' => $result->resultCount, 'loginData' => $array]);
    }
}

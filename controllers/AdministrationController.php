<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Request;
use app\models\User;
use ErrorException;

class AdministrationController extends Controller
{
    public function createLibraryInformationAssistant(Request $request)
    {
        $data = $request->getBody();
        $userModel = new User();

        $user = $userModel->findOne(['reg_no' => $data['reg_no']]);

        // Set academic/non academic staff member role ID here
        if ($user && $user->role_id == 0) {
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

        if ($user && $user->role_id == 3) {
            $userModel->loadData($user);
        } else {
            Application::$app->session->setFlashMessage('error', "Couldn't remove library information assistant");
            Application::$app->response->redirect('/admin/manage-library-information-assistant');
            exit;
        }

        // echo '<pre>';
        // var_dump($userModel);
        // echo '</pre>';

        $updateRequiredFields = ['role_id'];

        if ($userModel->removeLIA() && $userModel->update($updateRequiredFields)) {
            Application::$app->session->setFlashMessage('success', 'Removed library information assistant');
            Application::$app->response->redirect('/admin/manage-library-information-assistant');
        }



        // return $this->render('admin/manage-library-information-assistant');
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

    public function verifyNewUsers(Request $request)
    {
        return $this->render("admin/user/verify-new-users");
    }

    public function manageUsers(Request $request)
    {
        return $this->render("admin/user/users-view-update-delete");
    }

    public function createUserGroup(Request $request)
    {

        return $this->render("admin/user/admin-create-user-group");
    }

    public function addUsersToUserGroup(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            return $this->render("admin/user/add-users");
        }
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

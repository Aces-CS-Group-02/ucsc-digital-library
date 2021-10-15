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
}

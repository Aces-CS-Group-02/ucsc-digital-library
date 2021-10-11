<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\exception\NotFoundException;
use app\models\Community;

class CommunitiesController extends Controller
{
    public function createNewCommunity(Request $request)
    {
        $communityModel = new Community();

        if ($request->getMethod() === 'POST') {
            $communityModel->loadData($request->getBody());

            if ($communityModel->validate() && $communityModel->save()) {
                Application::$app->session->setFlashMessage('success-community-creation', 'Top level community created');
                Application::$app->response->redirect('/communities');
                exit;
            }

            return $this->render('createtoplevelcommunities', ['model' => $communityModel]);
        }
    }


    public function update(Request $request)
    {
        $data = $request->getBody();

        $communityModel = new Community();

        if ($request->getMethod() === 'POST') {

            $communityModel->loadData($data);

            // wantstoUpdate returns array of update required filed names
            $updateRequiredFileds = $communityModel->wantsToUpdate();
            // If updateRequiredFields not empty means there is something to update (Name or Description)
            if (!empty($updateRequiredFileds)) {
                if (in_array("Name", $updateRequiredFileds)) {
                    // Need to validate and check wheater there already exsist any  other community with this new Name
                    if ($communityModel->validate() && $communityModel->update($data, $updateRequiredFileds)) {
                        Application::$app->session->setFlashMessage('update-success', 'community successfully updated');
                        return $this->render('Updatecommunities', ['model' => $communityModel]);
                    }
                } else {
                    // No need to validate if Name filed has no change
                    if ($communityModel->update($data, $updateRequiredFileds)) {
                        Application::$app->session->setFlashMessage('update-success', 'community successfully updated');
                        return $this->render('Updatecommunities', ['model' => $communityModel]);
                    }
                }
            }
            return $this->render('Updatecommunities', ['model' => $communityModel]);
        } else {

            if ($communityModel->loadCommunity($data['ID'])) {
                return $this->render('Updatecommunities', ['model' => $communityModel]);
            } else {
                throw new NotFoundException();
            };
        }
    }


    public function deleteCommunity(Request $request)
    {
        $data = $request->getBody();

        $communityModel = new Community();

        if ($data['deleteCommunity']) {

            if ($communityModel->deleteCommunity($data['communityID'])) {
                // Send success as response to AJAX request
                echo "success";
            } else {
                // Send error as response to AJAX request
                echo "error";
            }
        }
    }
}

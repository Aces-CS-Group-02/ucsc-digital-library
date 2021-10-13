<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\exception\NotFoundException;
use app\models\Community;
use Exception;

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

            return $this->render('admin/createtoplevelcommunities', ['model' => $communityModel]);
        }
    }


    public function update(Request $request)
    {
        $data = $request->getBody();

        $communityModel = new Community();

        if ($request->getMethod() === 'POST') {

            // db_data contains data fetched from the database about the community
            //  data contains user POST data
            $db_data = $communityModel->findCommunity($data['CommunityID']);

            if (!$db_data) {
                throw new NotFoundException();
            }

            $updateRequiredFileds = $communityModel->wantsToUpdate($data, $db_data);

            $communityModel->loadData($data);

            if (!empty($updateRequiredFileds)) {
                if (in_array("Name", $updateRequiredFileds)) {
                    if ($communityModel->validate()) {
                        if ($communityModel->update($updateRequiredFileds)) {
                            Application::$app->session->setFlashMessage('update-success', 'community successfully updated');
                            return $this->render('admin/updatecommunities', ['communityName' => $communityModel->Name, 'model' => $communityModel]);
                        } else {
                            Application::$app->session->setFlashMessage('update-fail', 'community successfully updated');
                            return $this->render('admin/updatecommunities', ['communityName' => $db_data->Name, 'model' => $communityModel]);
                        }
                    } else {
                        return $this->render('admin/updatecommunities', ['communityName' => $db_data->Name, 'model' => $communityModel]);
                    }
                } else {
                    if ($communityModel->update($updateRequiredFileds)) {
                        Application::$app->session->setFlashMessage('update-success', 'community successfully updated');
                        return $this->render('admin/updatecommunities', ['communityName' => $communityModel->Name, 'model' => $communityModel]);
                    } else {
                        Application::$app->session->setFlashMessage('update-fail', 'community successfully updated');
                        return $this->render('admin/updatecommunities', ['communityName' => $db_data->Name, 'model' => $communityModel]);
                    }
                }
            } else {
                return $this->render('admin/updatecommunities', ['communityName' => $communityModel->Name, 'model' => $communityModel]);
            }


            // Get request
        } else {
            if ($communityModel->loadCommunity($data['ID'])) {
                return $this->render('admin/updatecommunities', ['communityName' => $communityModel->Name, 'model' => $communityModel]);
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

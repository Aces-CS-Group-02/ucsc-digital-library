<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\exception\NotFoundException;
use app\models\Community;
use app\models\SubCommunity;
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
                Application::$app->response->redirect('/manage/communities');
                exit;
            }

            return $this->render('admin/createtoplevelcommunities', ['model' => $communityModel]);
        }
    }

    public function createNewSubCommunity(Request $request)
    {
        $data = $request->getBody();

        echo '<pre>';
        var_dump($data);
        echo '</pre>';

        $communityModel = new Community();
        $subcommunityModel = new SubCommunity();


        if ($request->getMethod() === 'POST') {
            $communityModel->loadData($data);

            echo '<pre>';
            var_dump($communityModel);
            echo '</pre>';



            if ($communityModel->validate() && $communityModel->createSubCommunity($subcommunityModel)) {
                Application::$app->session->setFlashMessage('success-community-creation', 'community successfully updated');
                Application::$app->response->redirect('/manage/community?ID=' . $communityModel->ParentCommunityID);
            } else {
            }
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

    public function manage(Request $request)
    {
        $data = $request->getBody();


        $subcommunityModel = new SubCommunity();
        $allsubcommunities = $subcommunityModel->getAllSubCommunities(['parent_id' => $data['ID']]);


        $allSubcommunities_ID_List = array();
        $communityModel = new Community();


        $communityModel->loadCommunity($data['ID']);




        $communities = [];


        if ($allsubcommunities) {
            foreach ($allsubcommunities as $subcommunity) {
                array_push($allSubcommunities_ID_List, $subcommunity->child_id);
            }

            $communities = $communityModel->getCommunitiesByID($allSubcommunities_ID_List);
        }




        return $this->render('admin/communities', ['parentID' => $data['ID'], 'communityType' => 'Sub communities', 'communityName' => $communityModel->Name, 'communities' => $communities]);
    }
}

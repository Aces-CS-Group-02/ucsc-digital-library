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
                Application::$app->session->setFlashMessage('success', 'Top level community created');
                Application::$app->response->redirect('/manage/communities');
                exit;
            }

            return $this->render('admin/createtoplevelcommunities', ['model' => $communityModel]);
        }
    }

    public function createNewSubCommunity(Request $request)
    {
        $data = $request->getBody();

        $communityModel = new Community();
        $subcommunityModel = new SubCommunity();

        if ($request->getMethod() === 'POST') {
            $communityModel->loadData($data);



            if ($communityModel->ParentCommunityID) {
                $statement_spec = "AND ParentCommunityID = " . $communityModel->ParentCommunityID;
            } else {
                $statement_spec = "AND ParentCommunityID IS NULL";
            }

            if ($communityModel->validate($statement_spec)) {
                if ($communityModel->createSubCommunity($subcommunityModel)) {
                    Application::$app->session->setFlashMessage('success', 'Sub community successfully created');
                    Application::$app->response->redirect('/manage/community?id=' . $communityModel->ParentCommunityID);
                } else {
                    Application::$app->session->setFlashMessage('error', 'Sub community creation failed');
                    Application::$app->response->redirect('/manage/community?id=' . $communityModel->ParentCommunityID);
                }
            } else {
                return $this->render('admin/createtoplevelcommunities', ['ParentID' => $communityModel->ParentCommunityID, 'model' => $communityModel]);
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
                            Application::$app->session->setFlashMessage('success', 'community successfully updated');
                            // return $this->render('admin/updatecommunities', ['communityName' => $communityModel->Name, 'model' => $communityModel]);
                            if ($db_data->ParentCommunityID) {
                                Application::$app->response->redirect('/manage/community?id=' . $db_data->ParentCommunityID);
                            } else {
                                Application::$app->response->redirect('/manage/communities');
                            }
                        } else {
                            Application::$app->session->setFlashMessage('error', 'community update error ocured');
                            // return $this->render('admin/updatecommunities', ['communityName' => $db_data->Name, 'model' => $communityModel]);
                            if ($db_data->ParentCommunityID) {
                                Application::$app->response->redirect('/manage/community?id=' . $db_data->ParentCommunityID);
                            } else {
                                Application::$app->response->redirect('/manage/communities');
                            }
                        }
                    } else {
                        return $this->render('admin/updatecommunities', ['communityName' => $db_data->Name, 'model' => $communityModel]);
                    }
                } else {
                    if ($communityModel->update($updateRequiredFileds)) {
                        Application::$app->session->setFlashMessage('success', 'community successfully updated');
                        // return $this->render('admin/updatecommunities', ['communityName' => $communityModel->Name, 'model' => $communityModel]);
                        if ($db_data->ParentCommunityID) {
                            Application::$app->response->redirect('/manage/community?id=' . $db_data->ParentCommunityID);
                        } else {
                            Application::$app->response->redirect('/manage/communities');
                        }
                    } else {
                        Application::$app->session->setFlashMessage('error', 'community update error ocured');
                        // return $this->render('admin/updatecommunities', ['communityName' => $db_data->Name, 'model' => $communityModel]);
                        if ($db_data->ParentCommunityID) {
                            Application::$app->response->redirect('/manage/community?id=' . $db_data->ParentCommunityID);
                        } else {
                            Application::$app->response->redirect('/manage/communities');
                        }
                    }
                }
            } else {
                return $this->render('admin/updatecommunities', ['communityName' => $communityModel->Name, 'model' => $communityModel]);
            }


            // Get request
        } else {
            if ($communityModel->loadCommunity($data['id'])) {
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
        $allsubcommunities = $subcommunityModel->getAllSubCommunities(['parent_id' => $data['id']]);


        $allSubcommunities_ID_List = array();
        $communityModel = new Community();


        $communityModel->loadCommunity($data['id']);




        $communities = [];


        if ($allsubcommunities) {
            foreach ($allsubcommunities as $subcommunity) {
                array_push($allSubcommunities_ID_List, $subcommunity->child_id);
            }

            $communities = $communityModel->getCommunitiesByID($allSubcommunities_ID_List);
        }




        return $this->render('admin/communities', ['parentID' => $data['id'], 'communityType' => 'Sub communities', 'communityName' => $communityModel->Name, 'communities' => $communities]);
    }
}

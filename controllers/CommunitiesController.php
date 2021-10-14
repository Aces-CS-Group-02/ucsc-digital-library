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



            if ($communityModel->parent_community_id) {
                $statement_spec = "AND parent_community_id = " . $communityModel->parent_community_id;
            } else {
                $statement_spec = "AND parent_community_id IS NULL";
            }

            if ($communityModel->validate($statement_spec)) {
                if ($communityModel->createSubCommunity($subcommunityModel)) {
                    Application::$app->session->setFlashMessage('success', 'Sub community successfully created');
                    Application::$app->response->redirect('/manage/community?id=' . $communityModel->parent_community_id);
                } else {
                    Application::$app->session->setFlashMessage('error', 'Sub community creation failed');
                    Application::$app->response->redirect('/manage/community?id=' . $communityModel->parent_community_id);
                }
            } else {
                return $this->render('admin/createtoplevelcommunities', ['parent_community_id' => $communityModel->parent_community_id, 'model' => $communityModel]);
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
            $db_data = $communityModel->findCommunity($data['community_id']);

            if (!$db_data) {
                throw new NotFoundException();
            }

            $updateRequiredFileds = $communityModel->wantsToUpdate($data, $db_data);

            $communityModel->loadData($data);

            if (!empty($updateRequiredFileds)) {
                if (in_array("name", $updateRequiredFileds)) {
                    if ($communityModel->validate()) {
                        if ($communityModel->update($updateRequiredFileds)) {
                            Application::$app->session->setFlashMessage('success', 'community successfully updated');
                            // return $this->render('admin/updatecommunities', ['communityname' => $communityModel->name, 'model' => $communityModel]);
                            if ($db_data->parent_community_id) {
                                Application::$app->response->redirect('/manage/community?id=' . $db_data->parent_community_id);
                            } else {
                                Application::$app->response->redirect('/manage/communities');
                            }
                        } else {
                            Application::$app->session->setFlashMessage('error', 'community update error ocured');
                            // return $this->render('admin/updatecommunities', ['communityname' => $db_data->name, 'model' => $communityModel]);
                            if ($db_data->parent_community_id) {
                                Application::$app->response->redirect('/manage/community?id=' . $db_data->parent_community_id);
                            } else {
                                Application::$app->response->redirect('/manage/communities');
                            }
                        }
                    } else {
                        return $this->render('admin/updatecommunities', ['communityname' => $db_data->name, 'model' => $communityModel]);
                    }
                } else {
                    if ($communityModel->update($updateRequiredFileds)) {
                        Application::$app->session->setFlashMessage('success', 'community successfully updated');
                        // return $this->render('admin/updatecommunities', ['communityname' => $communityModel->name, 'model' => $communityModel]);
                        if ($db_data->parent_community_id) {
                            Application::$app->response->redirect('/manage/community?id=' . $db_data->parent_community_id);
                        } else {
                            Application::$app->response->redirect('/manage/communities');
                        }
                    } else {
                        Application::$app->session->setFlashMessage('error', 'community update error ocured');
                        // return $this->render('admin/updatecommunities', ['communityname' => $db_data->name, 'model' => $communityModel]);
                        if ($db_data->parent_community_id) {
                            Application::$app->response->redirect('/manage/community?id=' . $db_data->parent_community_id);
                        } else {
                            Application::$app->response->redirect('/manage/communities');
                        }
                    }
                }
            } else {
                return $this->render('admin/updatecommunities', ['communityname' => $communityModel->name, 'model' => $communityModel]);
            }


            // Get request
        } else {
            if ($communityModel->loadCommunity($data['id'])) {
                return $this->render('admin/updatecommunities', ['communityname' => $communityModel->name, 'model' => $communityModel]);
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

            if ($communityModel->deleteCommunity($data['community_id'])) {
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
        $allsubcommunities = $subcommunityModel->getAllSubCommunities(['parent_community_id' => $data['id']]);


        $allSubcommunities_ID_List = array();
        $communityModel = new Community();


        $communityModel->loadCommunity($data['id']);




        $communities = [];


        if ($allsubcommunities) {
            foreach ($allsubcommunities as $subcommunity) {
                array_push($allSubcommunities_ID_List, $subcommunity->child_community_id);
            }

            $communities = $communityModel->getCommunitiesByID($allSubcommunities_ID_List);
        }




        return $this->render('admin/communities', ['parentID' => $data['id'], 'communityType' => 'Sub communities', 'communityname' => $communityModel->name, 'communities' => $communities]);
    }
}

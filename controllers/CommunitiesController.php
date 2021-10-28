<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\exception\NotFoundException;
use app\models\Collection;
use app\models\Community;
use app\models\SubCommunity;
use Exception;

class CommunitiesController extends Controller
{
    public function communities(Request $request)
    {
        $data = $request->getBody();
        $page = isset($data['page']) ? $data['page'] : 1;
        $limit = 5;
        $start = ($page - 1) * $limit;
        $community = new Community();
        $pageCount = $community->getPageCount($limit);
        $allTopCommunities = $community->getAllTopLevelCommunities($start, $limit);

        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_MANAGE_COMMUNITIES_N_COLLECTIONS
        ];

        return $this->render('admin/communities', ['communityType' => true, 'communities' => $allTopCommunities, 'breadcrum' => $breadcrum, 'pageCount' => $pageCount, 'currentPage' => $page]);
    }

    public function createTopLevelCommunities()
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_MANAGE_COMMUNITIES_N_COLLECTIONS,
            self::BREADCRUM_CREATE_TOP_LEVEL_COMMUNITY
        ];

        return $this->render('admin/createtoplevelcommunities', ['breadcrum' => $breadcrum]);
    }

    public function createSubCommunity(Request $request)
    {
        $data = $request->getBody();
        $communityModel = new Community();

        if (!array_key_exists("parent-id", $data)) {
            throw new NotFoundException();
        }

        if (!$communityModel->findCommunity($data['parent-id'])) {
            throw new NotFoundException();
        }

        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_MANAGE_COMMUNITIES_N_COLLECTIONS
        ];

        $breadcrumCommunities = $communityModel->communityBreadcrumGenerate($data['parent-id']);
        foreach ($breadcrumCommunities as $link) {
            $breadcrumLinkName =  $link['name'];
            $breadcrumLink = '/admin/manage-community?community-id=' . $link["community_id"];
            $val = ['name' => $breadcrumLinkName, 'link' => $breadcrumLink];
            array_push($breadcrum, $val);
        }
        array_push($breadcrum, self::BREADCRUM_CREATE_SUB_COMMUNITY);

        return $this->render('admin/createtoplevelcommunities', ['parent_community_id' => $data['parent-id'], 'breadcrum' => $breadcrum]);
    }

    public function createNewCommunity(Request $request)
    {
        $communityModel = new Community();
        if ($request->getMethod() === 'POST') {
            if ($communityModel->createTopLevelCommunity($request->getBody())) {
                Application::$app->session->setFlashMessage('success', 'Top level community created');
                Application::$app->response->redirect('/admin/manage-communities');
                exit;
            }

            $breadcrum = [
                self::BREADCRUM_DASHBOARD,
                self::BREADCRUM_MANAGE_CONTENT,
                self::BREADCRUM_MANAGE_COMMUNITIES_N_COLLECTIONS,
                self::BREADCRUM_CREATE_TOP_LEVEL_COMMUNITY
            ];
            return $this->render('admin/createtoplevelcommunities', ['model' => $communityModel, 'breadcrum' => $breadcrum]);
        }
    }

    public function createNewSubCommunity(Request $request)
    {
        $data = $request->getBody();

        $communityModel = new Community();
        $subcommunityModel = new SubCommunity();

        if ($request->getMethod() === 'POST') {
            $communityModel->loadData($data);
            $statement_spec = "AND parent_community_id = " . $communityModel->parent_community_id;

            if ($communityModel->validate($statement_spec)) {
                if ($communityModel->createSubCommunity($subcommunityModel)) {
                    Application::$app->session->setFlashMessage('success', 'Sub community successfully created');
                    Application::$app->response->redirect('/admin/manage-community?community-id=' . $communityModel->parent_community_id);
                } else {
                    Application::$app->session->setFlashMessage('error', 'Sub community creation failed');
                    Application::$app->response->redirect('/admin/manage-community?community-id=' . $communityModel->parent_community_id);
                }
            } else {

                $breadcrum = [
                    self::BREADCRUM_DASHBOARD,
                    self::BREADCRUM_MANAGE_CONTENT,
                    self::BREADCRUM_MANAGE_COMMUNITIES_N_COLLECTIONS
                ];
                $breadcrumCommunities = $communityModel->communityBreadcrumGenerate($data['parent_community_id']);
                foreach ($breadcrumCommunities as $link) {
                    $breadcrumLinkName =  $link['name'];
                    $breadcrumLink = '/admin/manage-community?community-id=' . $link["community_id"];
                    $val = ['name' => $breadcrumLinkName, 'link' => $breadcrumLink];
                    array_push($breadcrum, $val);
                }
                array_push($breadcrum, self::BREADCRUM_CREATE_SUB_COMMUNITY);

                return $this->render('admin/createtoplevelcommunities', ['parent_community_id' => $communityModel->parent_community_id, 'model' => $communityModel, 'breadcrum' => $breadcrum]);
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

            // Check whether the same name is allocated to any other community 
            if ($db_data->parent_community_id) {
                // If parent ID is not null then we have to check inside that community level
                $statement_spec = "AND parent_community_id = " . $db_data->parent_community_id;
            } else {
                // If parent community ID is null then it is a top level community. So check within top level communities level
                $statement_spec = "AND parent_community_id IS NULL";
            }

            if (!empty($updateRequiredFileds)) {
                if (in_array("name", $updateRequiredFileds)) {
                    if ($communityModel->validate($statement_spec)) {
                        if ($communityModel->updateCommunity($updateRequiredFileds)) {
                            Application::$app->session->setFlashMessage('success', 'community successfully updated');
                            // return $this->render('admin/updatecommunities', ['communityname' => $communityModel->name, 'model' => $communityModel]);
                            if ($db_data->parent_community_id) {
                                Application::$app->response->redirect('/admin/manage-community?community-id=' . $db_data->parent_community_id);
                            } else {
                                Application::$app->response->redirect('/admin/manage-communities');
                            }
                        } else {
                            Application::$app->session->setFlashMessage('error', 'community update error ocured');
                            // return $this->render('admin/updatecommunities', ['communityname' => $db_data->name, 'model' => $communityModel]);
                            if ($db_data->parent_community_id) {
                                Application::$app->response->redirect('/admin/manage-community?community-id=' . $db_data->parent_community_id);
                            } else {
                                Application::$app->response->redirect('/admin/manage-communities');
                            }
                        }
                    } else {
                        return $this->render('admin/updatecommunities', ['communityname' => $db_data->name, 'model' => $communityModel]);
                    }
                } else {
                    if ($communityModel->updateCommunity($updateRequiredFileds)) {
                        Application::$app->session->setFlashMessage('success', 'community successfully updated');
                        // return $this->render('admin/updatecommunities', ['communityname' => $communityModel->name, 'model' => $communityModel]);
                        if ($db_data->parent_community_id) {
                            Application::$app->response->redirect('/admin/manage-community?community-id=' . $db_data->parent_community_id);
                        } else {
                            Application::$app->response->redirect('/admin/manage-communities');
                        }
                    } else {
                        Application::$app->session->setFlashMessage('error', 'community update error ocured');
                        // return $this->render('admin/updatecommunities', ['communityname' => $db_data->name, 'model' => $communityModel]);
                        if ($db_data->parent_community_id) {
                            Application::$app->response->redirect('/admin/manage-community?community-id=' . $db_data->parent_community_id);
                        } else {
                            Application::$app->response->redirect('/admin/manage-communities');
                        }
                    }
                }
            } else {
                return $this->render('admin/updatecommunities', ['communityname' => $communityModel->name, 'model' => $communityModel]);
            }
            // Get request
        } else {
            if ($communityModel->loadCommunity($data['community-id'])) {
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
        $communityModel = new Community();

        if (!$communityModel->findCommunity($data['community-id'])) {
            throw new NotFoundException();
        }

        $allsubcommunities = $subcommunityModel->getAllSubCommunities(['parent_community_id' => $data['community-id']]);
        $allSubcommunities_ID_List = array();
        $communityModel->loadCommunity($data['community-id']);
        $communities = [];

        if ($allsubcommunities) {
            foreach ($allsubcommunities as $subcommunity) {
                array_push($allSubcommunities_ID_List, $subcommunity->child_community_id);
            }

            $communities = $communityModel->getCommunitiesByID($allSubcommunities_ID_List);
        }


        $collectionCount = Collection::getCollectionCount($data['community-id']);
        $subCommunityCount = SubCommunity::getSubcommunitiesCount($data['community-id']);


        $breadcrum = [
            ['name' => 'Dashboard', 'link' => '/admin/dashboard'],
            ['name' => 'Manage Content', 'link' => '/admin/dashboard/manage-content'],
            ['name' => "Communities & Collections", 'link' => '/admin/manage-communities']
        ];
        $breadcrumCommunities = $communityModel->communityBreadcrumGenerate($data['community-id']);
        foreach ($breadcrumCommunities as $link) {
            $breadcrumLinkName =  $link['name'];
            $breadcrumLink = '/admin/manage-community?community-id=' . $link["community_id"];
            $val = ['name' => $breadcrumLinkName, 'link' => $breadcrumLink];
            array_push($breadcrum, $val);
        }

        //  IF community type is sub community => value = false. If community is top level value is true
        return $this->render('admin/communities', ['parentID' => $data['community-id'], 'communityType' => false, 'communityname' => $communityModel->name, 'communities' => $communities, 'subCommunityCount' => $subCommunityCount->count, 'collectionCount' => $collectionCount->count, 'breadcrum' => $breadcrum]);
    }
}

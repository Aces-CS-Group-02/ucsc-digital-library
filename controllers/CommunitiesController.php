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

        if ($page <= 0) throw new NotFoundException();

        $community = new Community();
        $allTopCommunities = $community->getAllTopLevelCommunities($start, $limit);

        if ($allTopCommunities->pageCount > 0 && $page > $allTopCommunities->pageCount) throw new NotFoundException();


        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_MANAGE_COMMUNITIES_N_COLLECTIONS
        ];

        return $this->render('admin/communities', ['communityType' => true, 'communities' => $allTopCommunities->payload, 'breadcrum' => $breadcrum, 'pageCount' => $allTopCommunities->pageCount, 'currentPage' => $page]);
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

        $redirect = $data['redirect'] ?? false;

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

        return $this->render('admin/createtoplevelcommunities', ['parent_community_id' => $data['parent-id'], 'breadcrum' => $breadcrum, 'redirect' => $redirect]);
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

        $redirect = $data['redirect'] ?? false;

        $communityModel = new Community();
        $subcommunityModel = new SubCommunity();

        if ($request->getMethod() === 'POST') {
            $communityModel->loadData($data);
            $statement_spec = "AND parent_community_id = " . $communityModel->parent_community_id;

            if ($communityModel->validate($statement_spec)) {
                if ($communityModel->createSubCommunity($subcommunityModel)) {
                    Application::$app->session->setFlashMessage('success', 'Sub community successfully created');

                    if ($redirect == "browse") {
                        Application::$app->response->redirect('/browse/community?community_id=' . $communityModel->parent_community_id);
                    } else {
                        Application::$app->response->redirect('/admin/manage-community?community-id=' . $communityModel->parent_community_id);
                    }
                } else {
                    Application::$app->session->setFlashMessage('error', 'Sub community creation failed');

                    if ($redirect == "browse") {
                        Application::$app->response->redirect('/browse/community?community_id=' . $communityModel->parent_community_id);
                    } else {
                        Application::$app->response->redirect('/admin/manage-community?community-id=' . $communityModel->parent_community_id);
                    }
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

                return $this->render('admin/createtoplevelcommunities', ['parent_community_id' => $communityModel->parent_community_id, 'model' => $communityModel, 'breadcrum' => $breadcrum, 'redirect' => $redirect]);
            }
        }
    }


    public function update(Request $request)
    {
        $data = $request->getBody();

        $redirect = $data['redirect'] ?? false;

        var_dump($redirect);

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

                            if ($redirect == "browse") {
                                Application::$app->response->redirect('/browse/community?community_id=' . $db_data->community_id);
                            } elseif ($db_data->parent_community_id) {
                                Application::$app->response->redirect('/admin/manage-community?community-id=' . $db_data->parent_community_id);
                            } else {
                                Application::$app->response->redirect('/admin/manage-communities');
                            }
                        } else {
                            Application::$app->session->setFlashMessage('error', 'community update error ocured');
                            // return $this->render('admin/updatecommunities', ['communityname' => $db_data->name, 'model' => $communityModel]);
                            if ($redirect == "browse") {
                                Application::$app->response->redirect('/browse/community?community_id=' . $db_data->community_id);
                            } elseif ($db_data->parent_community_id) {
                                Application::$app->response->redirect('/admin/manage-community?community-id=' . $db_data->parent_community_id);
                            } else {
                                Application::$app->response->redirect('/admin/manage-communities');
                            }
                        }
                    } else {
                        return $this->render('admin/updatecommunities', ['communityname' => $db_data->name, 'model' => $communityModel, 'redirect' => $redirect]);
                    }
                } else {
                    if ($communityModel->updateCommunity($updateRequiredFileds)) {
                        Application::$app->session->setFlashMessage('success', 'community successfully updated');
                        // return $this->render('admin/updatecommunities', ['communityname' => $communityModel->name, 'model' => $communityModel]);
                        if ($redirect == "browse") {
                            Application::$app->response->redirect('/browse/community?community_id=' . $db_data->community_id);
                        } elseif ($db_data->parent_community_id) {
                            Application::$app->response->redirect('/admin/manage-community?community-id=' . $db_data->parent_community_id);
                        } else {
                            Application::$app->response->redirect('/admin/manage-communities');
                        }
                    } else {
                        Application::$app->session->setFlashMessage('error', 'community update error ocured');
                        // return $this->render('admin/updatecommunities', ['communityname' => $db_data->name, 'model' => $communityModel]);
                        if ($redirect == "browse") {
                            Application::$app->response->redirect('/browse/community?community_id=' . $db_data->community_id);
                        } elseif ($db_data->parent_community_id) {
                            Application::$app->response->redirect('/admin/manage-community?community-id=' . $db_data->parent_community_id);
                        } else {
                            Application::$app->response->redirect('/admin/manage-communities');
                        }
                    }
                }
            } else {
                return $this->render('admin/updatecommunities', ['communityname' => $communityModel->name, 'model' => $communityModel, 'redirect' => $redirect]);
            }


            // Get request
        } else {
            if ($communityModel->loadCommunity($data['community-id'])) {
                return $this->render('admin/updatecommunities', ['communityname' => $communityModel->name, 'model' => $communityModel, 'redirect' => $redirect]);
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


        $page = isset($data['page']) ? $data['page'] : 1;
        $limit = 5;
        $start = ($page - 1) * $limit;

        if (!$communityModel->findCommunity($data['community-id'])) {
            throw new NotFoundException();
        }

        if ($page <= 0) throw new NotFoundException();
        $allsubcommunities = $subcommunityModel->getAllSubCommunities($data['community-id'], $start, $limit);
        if ($allsubcommunities->pageCount > 0 && $page > $allsubcommunities->pageCount) throw new NotFoundException();


        $collectionCount = Collection::getCollectionCount($data['community-id']);
        $subCommunityCount = SubCommunity::getSubcommunitiesCount($data['community-id']);


        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_MANAGE_COMMUNITIES_N_COLLECTIONS
        ];
        $breadcrumCommunities = $communityModel->communityBreadcrumGenerate($data['community-id']);
        foreach ($breadcrumCommunities as $link) {
            $breadcrumLinkName =  $link['name'];
            $breadcrumLink = '/admin/manage-community?community-id=' . $link["community_id"];
            $val = ['name' => $breadcrumLinkName, 'link' => $breadcrumLink];
            array_push($breadcrum, $val);
        }

        //  IF community type is sub community => value = false. If community is top level value is true
        return $this->render('admin/communities', ['parentID' => $data['community-id'], 'communityType' => false, 'communityname' => $communityModel->name, 'communities' => $allsubcommunities->payload, 'subCommunityCount' => $subCommunityCount->count, 'collectionCount' => $collectionCount->count, 'breadcrum' => $breadcrum, 'pageCount' => $allsubcommunities->pageCount, 'currentPage' => $page]);
    }

    public function remove(Request $request)
    {
        $data = $request->getBody();
        $communityModel = new Community();
        $community = $communityModel->findOne(['community_id' => $data['community-id']]);
        if (!$community) throw new NotFoundException();

        // var_dump($data);

        if ($community->delete()) {
            Application::$app->session->setFlashMessage("success", "Collection successfully created");
        } else {
            Application::$app->session->setFlashMessage("error", "Collection successfully created");
        }


        if (!isset($data['redirect-parent'])) throw new NotFoundException();

        if ($data['redirect-parent'] == null) {
            Application::$app->response->redirect('/community-list');
        } else {
            Application::$app->response->redirect('/browse/community?community_id=' . $data['redirect-parent']);
        }
    }
}

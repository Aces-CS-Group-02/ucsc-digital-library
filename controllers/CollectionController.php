<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Request;
use app\models\Collection;
use app\models\Community;
use app\models\SubCommunity;

class CollectionController extends Controller
{
    public function manageCollections(Request $request)
    {
        $data = $request->getBody();
        $data_keys = array_keys($data);
        if (!in_array('community-id', $data_keys)) throw new NotFoundException();

        $page = isset($data['page']) ? $data['page'] : 1;
        $limit = 10;
        $start = ($page - 1) * $limit;

        $communityModel = new Community();
        $community = $communityModel->findCommunity($data['community-id']);
        if (!$community) throw new NotFoundException();

        if ($page <= 0) throw new NotFoundException();
        $collectionModel = new Collection();
        $allCollections = $collectionModel->getAllCollections($data['community-id'], $start, $limit);
        if ($allCollections->pageCount > 0 && $page > $allCollections->pageCount) throw new NotFoundException();


        $collectionCount = Collection::getCollectionCount($data['community-id']);
        $subCommunityCount = SubCommunity::getSubcommunitiesCount($data['community-id']);

        // ---------------------------------Breadcrum---------------------------------------------

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

        // --------------------------------------------------------------------------------------


        $this->render("admin/collections", ['parentID' => $data['community-id'], 'communityName' => $community->name, 'allCollections' => $allCollections->payload, 'subCommunityCount' => $subCommunityCount->count, 'collectionCount' => $collectionCount->count, 'breadcrum' => $breadcrum, 'currentPage' => $page, 'pageCount' => $allCollections->pageCount]);
    }

    public function createCollection(Request $request)
    {
        $data = $request->getBody();
        $data_keys = array_keys($data);
        if (!in_array('community-id', $data_keys)) throw new NotFoundException();


        $redirect = $data['redirect'] ?? false;

        $communityModel = new Community();

        $community_data = $communityModel->findCommunity($data['community-id']);

        if (!$community_data) throw new NotFoundException();

        // ---------------------------------Breadcrum---------------------------------------------
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
        array_push($breadcrum, self::BREADCRUM_CREATE_COLLECTION);
        // --------------------------------------------------------------------------------------

        if ($request->getMethod() === 'POST') {
            $collectionModel = new Collection();
            $return_val = $collectionModel->createNewCollection($data);
            if (is_array($return_val)) {
                $this->render("admin/createCollection", ['community-id' => $data['community-id'], 'model' => $return_val[1], 'breadcrum' => $breadcrum, 'redirect' => $redirect]);
                exit;
            }
            if (!$return_val) { // If return value is just false
                Application::$app->session->setFlashMessage("error", "Something went wrong");

                if ($redirect == "browse") {
                    Application::$app->response->redirect("/browse/community?community_id=" . $data['community-id']);
                } else {
                    Application::$app->response->redirect("/admin/manage-community/collections?community-id=" . $data['community-id']);
                }
            }
            // If operation successfull
            Application::$app->session->setFlashMessage("success", "Collection successfully created");
            if ($redirect == "browse") {
                Application::$app->response->redirect("/browse/community?community_id=" . $data['community-id']);
            } else {
                Application::$app->response->redirect("/admin/manage-community/collections?community-id=" . $data['community-id']);
            }
        }


        $this->render("admin/createCollection", ['community-id' => $data['community-id'], 'breadcrum' => $breadcrum, 'redirect' => $redirect]);
    }

    public function deleteCollection(Request $request)
    {
        $data = $request->getBody();
        $data_keys = array_keys($data);
        if (!in_array('collection-id', $data_keys)) {
            echo 'failed';
            exit;
        }

        var_dump($data);

        $collectionModel = new Collection();
        $collection = $collectionModel->findOne(['collection_id' => $data['collection-id']]);
        if ($collection) {
            if ($collection->delete()) {
                Application::$app->session->setFlashMessage("success", "Collection successfully created");
            } else {
                Application::$app->session->setFlashMessage("error", "Collection successfully created");
            }
        } else {
            Application::$app->session->setFlashMessage("error", "Collection successfully created");
        }
        Application::$app->response->redirect('/browse/community?community_id=' . $data['redirect-parent']);
        if ($data['deleteCollection']) $collectionModel->deleteCollection($data['collection-id']);
    }


    public function editCollection(Request $request)
    {
        $data = $request->getBody();

        $collectionID = $data['collection-id'];
        $redirect = $data['redirect'] ?? false;

        $collectionModel = new Collection();
        $collection = $collectionModel->findOne(['collection_id' => $collectionID]);

        if ($request->getMethod() == "POST") {
            // Post request

            $updateInfo = $collection->findOne(['collection_id' => $collectionID]);
            $updateInfo->name = $data['name'];
            $updateInfo->description = $data['description'];

            if ($updateInfo->validate()) {
                if ($updateInfo->update()) {
                    Application::$app->session->setFlashMessage("success", "Successfully updated");

                    if ($redirect == "browse") {
                        Application::$app->response->redirect('/browse/community?community_id=' . $updateInfo->collection_id);
                    } else {
                        Application::$app->response->redirect('/admin/manage-community/collections?community-id=' . $updateInfo->collection_id);
                    }
                } else {
                    Application::$app->session->setFlashMessage("error", "Something went wrong");
                    if ($redirect == "browse") {
                        Application::$app->response->redirect('/browse/community?community_id=' . $updateInfo->collection_id);
                    } else {
                        Application::$app->response->redirect('/admin/manage-community/collections?community-id=' . $updateInfo->collection_id);
                    }
                }
            } else {
                return $this->render('admin/updateCommunityCollection', ['collection-id' => $collectionID, 'model' => $updateInfo, 'redirect' => $redirect]);
            }

            var_dump($updateInfo);
        } else {
            // Get request
            return $this->render('admin/updateCommunityCollection', ['collection-id' => $collectionID, 'model' => $collection, 'redirect' => $redirect]);
        }
    }
}

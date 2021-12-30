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

        $communityModel = new Community();

        if (!$communityModel->findCommunity($data['community-id'])) throw new NotFoundException();

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
                $this->render("admin/createCollection", ['community-id' => $data['community-id'], 'model' => $return_val[1], 'breadcrum' => $breadcrum]);
                exit;
            }
            if (!$return_val) { // If return value is just false
                Application::$app->session->setFlashMessage("error", "Something went wrong");
                Application::$app->response->redirect("/admin/manage-community/collections?community-id=" . $data['community-id']);
            }
            // If operation successfull
            Application::$app->session->setFlashMessage("success", "Collection successfully created");
            Application::$app->response->redirect("/admin/manage-community/collections?community-id=" . $data['community-id']);
        }


        $this->render("admin/createCollection", ['community-id' => $data['community-id'], 'breadcrum' => $breadcrum]);
    }

    public function deleteCollection(Request $request)
    {
        $data = $request->getBody();
        $data_keys = array_keys($data);
        if (!in_array('collection-id', $data_keys)) {
            echo 'failed';
            exit;
        }

        $collectionModel = new Collection();
        if ($data['deleteCollection']) $collectionModel->deleteCollection($data['collection-id']);
    }
}

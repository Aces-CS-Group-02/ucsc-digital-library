<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Request;
use app\models\Collection;
use app\models\Community;

class CollectionController extends Controller
{
    public function manageCollections(Request $request)
    {
        $data = $request->getBody();
        $data_keys = array_keys($data);
        if (!in_array('community-id', $data_keys)) throw new NotFoundException();

        $communityModel = new Community();
        $community = $communityModel->findCommunity($data['community-id']);
        if (!$community) throw new NotFoundException();

        $collectionModel = new Collection();
        $allCollections = $collectionModel->getAllCollections($data['community-id']);

        $this->render("admin/collections", ['parentID' => $data['community-id'], 'communityName' => $community->name, 'allCollections' => $allCollections]);
    }

    public function createCollection(Request $request)
    {
        $data = $request->getBody();
        $data_keys = array_keys($data);
        if (!in_array('community-id', $data_keys)) throw new NotFoundException();

        $communityModel = new Community();

        if (!$communityModel->findCommunity($data['community-id'])) throw new NotFoundException();

        if ($request->getMethod() === 'POST') {
            $collectionModel = new Collection();
            $return_val = $collectionModel->createNewCollection($data);
            if (is_array($return_val)) {
                $this->render("admin/createCollection", ['community-id' => $data['community-id'], 'model' => $return_val[1]]);
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
        $this->render("admin/createCollection", ['community-id' => $data['community-id']]);
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

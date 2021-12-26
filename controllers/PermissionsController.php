<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Request;
use app\models\Collection;
use app\models\Community;
use app\models\SubCommunity;
use app\models\Usergroup;
use stdClass;

class PermissionsController extends Controller
{
    public function browsePermissions(Request $res)
    {
        $communityModel = new Community();

        $collectionModel = new Collection();
        $collections = $collectionModel->getCollections();


        $payload = [];
        foreach ($collections as $collection) {
            $res = $communityModel->communityBreadcrumGenerate($collection->community_id);
            array_push($res, ['name' => $collection->name]);

            $path_name = [];
            foreach ($res as $r) {
                array_push($path_name, $r['name']);
            }
            $path = implode(' > ', $path_name);
            $tempObj = new stdClass;
            $tempObj->path = $path;
            $tempObj->id = $collection->collection_id;

            array_push($payload, $tempObj);
        }

        return $this->render('admin/set-permissions-browse', ['data' => $payload]);
    }

    public function browseUsergroup(Request $request)
    {
        $data = $request->getBody();

        if (!isset($data['collection-id']) || $data['collection-id'] == '') {
            Application::$app->response->redirect('/admin/set-access-permission/collections');
        }

        $collectionModel = new Collection();
        $collection = $collectionModel->findOne(['collection_id' => $data['collection-id']]);
        if (!$collection) throw new NotFoundException();

        $usergroupModel = new Usergroup();
        // $usergroups = $usergroupModel->getAllLiveUsergroups();
        // var_dump($usergroups);
    }
}

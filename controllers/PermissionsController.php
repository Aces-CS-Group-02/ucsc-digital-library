<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Request;
use app\models\Collection;
use app\models\CollectionPermission;
use app\models\Community;
use app\models\SubCommunity;
use app\models\UserGroup;
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

        return $this->render('admin/set-permissions-browse', ['page_step' => 1, 'data' => $payload]);
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


        $communityModel = new Community();
        $res = $communityModel->communityBreadcrumGenerate($collection->community_id);


        // Build the path string of selected collection
        $temp_path = [];
        foreach ($res as $r) {
            array_push($temp_path, $r['name']);
        }
        array_push($temp_path, $collection->name);
        $collection_path_str = implode(' > ', $temp_path);

        $usergroupModel = new UserGroup();
        $usergroups = $usergroupModel->getAllLiveUsergroups("", 1, 100);


        return $this->render('admin/set-permissions-browse', ['page_step' => 2, 'data' => $usergroups->payload, 'collection' => $collection_path_str, 'collection-id' => $collection->collection_id]);
    }

    public function setPermissionToCollection(Request $request)
    {
        $data = $request->getBody();


        $collectionModel = new Collection();
        $collection = $collectionModel->findOne(['collection_id' => $data['collection-id']]);
        if (!$collection) throw new NotFoundException();


        // Usergroup info
        $usergroupModel = new UserGroup();
        $usergroup = $usergroupModel->getUsergroupInfo($data['usergroup-id']);
        if (!$usergroup) throw new NotFoundException();


        // Build the path string of selected collection
        $communityModel = new Community();
        $temp_path = [];
        $res = $communityModel->communityBreadcrumGenerate($collection->community_id);
        foreach ($res as $r) {
            array_push($temp_path, $r['name']);
        }
        array_push($temp_path, $collection->name);
        $collection_path_str = implode(' > ', $temp_path);


        if ($request->getMethod() === "POST") {
            $permissionModel = new CollectionPermission();
            $permission = isset($data['permission']) ? $data['permission'] : '';




            $permissionObj = $permissionModel->findOne(['collection_id' => $collection->collection_id, 'group_id' => $usergroup->id]);

            if ($permissionObj) {
                $permissionModel->loadData($permissionObj);
                $permissionModel->permission = $permission;
            } else {
                $permissionModel->loadData(['collection_id' => $collection->collection_id, 'group_id' => $usergroup->id, 'permission' => $permission]);
            }


            if ($permissionModel->validate()) {
                if ($permissionObj) {
                    if ($permissionModel->updatePermission()) {
                        Application::$app->response->redirect('/admin/set-access-permission/status-success');
                    } else {
                        Application::$app->response->redirect('/admin/set-access-permission/status-failed');
                    }
                } else {
                    if ($permissionModel->save()) {
                        Application::$app->response->redirect('/admin/set-access-permission/status-success');
                    } else {
                        Application::$app->response->redirect('/admin/set-access-permission/status-failed');
                    }
                }
            } else {
                return $this->render('admin/set-permissions-browse', ['page_step' => 3, 'usergroup' => $usergroup, 'collection' => $collection_path_str, 'collection-id' => $collection->collection_id, 'permissionModel' => $permissionModel]);
            }
        } else {
            return $this->render('admin/set-permissions-browse', ['page_step' => 3, 'usergroup' => $usergroup, 'collection' => $collection_path_str, 'collection-id' => $collection->collection_id]);
        }
    }






    public function statusSuccess()
    {
        return $this->render('admin/set-permissions-browse', ['page_step' => 4, 'status' => true]);
    }

    public function statusFailed()
    {
        return $this->render('admin/set-permissions-browse', ['page_step' => 4, 'status' => false]);
    }


    public function viewAccessPermissionOnCollections()
    {
        $permissionModel = new CollectionPermission();
        $data = $permissionModel->getAccessPermissionOnCollections();

        return $this->render('admin/set-permissions-browse', ['page_step' => 5, 'data' => $data]);
    }


    public function removePermissionOnCollections(Request $request)
    {
        $data = $request->getBody();

        $permissionModel = new CollectionPermission();
        $permission = $permissionModel->findOne(['collection_id' => $data['collection-id'], 'group_id' => $data['group-id']]);

        if (!$permission) {
            Application::$app->session->setFlashMessage('error', "Couldn't find the permission");
        } else {
            $res = $permissionModel->removeCollectionPermission($permission->collection_id, $permission->group_id);

            if ($res) {
                Application::$app->session->setFlashMessage('error', "Couldn't find the permission");
            } else {
                Application::$app->session->setFlashMessage('error', "Couldn't find the permission");
            }
        }

        Application::$app->response->redirect('/admin/view-access-permission');
    }
}

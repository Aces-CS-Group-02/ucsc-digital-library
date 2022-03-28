<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Request;
use app\models\Collection;
use app\models\CollectionPermission;
use app\models\Community;
use app\models\ContentCollection;
use app\models\ContentCollectionPermission;
use app\models\PendingCollectionPermission;
use app\models\PendingContentCollectionPermission;
use app\models\SubCommunity;
use app\models\UserGroup;
use stdClass;

class PermissionsController extends Controller
{
    public function browsePermissions(Request $request)
    {
        $data = $request->getBody();

        $Search_params = $data['q'] ?? '';
        $page = isset($data['page']) ? $data['page'] : 1;
        if ($page <= 0) $page = 1;
        $limit = 10;
        $start = ($page - 1) * $limit;


        $communityModel = new Community();

        $collectionModel = new Collection();
        $collections = $collectionModel->getCollections($start, $limit);


        $payload = [];
        foreach ($collections->payload as $collection) {
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

        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_COMMUNITY_COLLECTION_ACCESS_PERMISSION,
        ];

        return $this->render('admin/set-permissions-browse-collections', ['page_step' => 1, 'data' => $payload, 'currentPage' => $page, 'pageCount' => $collections->pageCount, 'breadcrum' => $breadcrum]);
    }

    public function browseUsergroup(Request $request)
    {
        // if (!isset($data['collection-id']) || $data['collection-id'] == '') {
        //     Application::$app->response->redirect('/admin/set-access-permission/collections');
        // }

        // $collectionModel = new Collection();
        // $collection = $collectionModel->findOne(['collection_id' => $data['collection-id']]);
        // if (!$collection) throw new NotFoundException();


        // $communityModel = new Community();
        // $res = $communityModel->communityBreadcrumGenerate($collection->community_id);


        // // Build the path string of selected collection
        // $temp_path = [];
        // foreach ($res as $r) {
        //     array_push($temp_path, $r['name']);
        // }
        // array_push($temp_path, $collection->name);
        // $collection_path_str = implode(' > ', $temp_path);

        // $usergroupModel = new UserGroup();
        // $usergroups = $usergroupModel->getAllLiveUsergroups("", $start, $limit);

        $data = $request->getBody();

        $Search_params = $data['q'] ?? '';
        $page = isset($data['page']) ? $data['page'] : 1;
        if ($page <= 0) $page = 1;
        $limit = 10;
        $start = ($page - 1) * $limit;

        $usergroupModel = new UserGroup();
        $res = $usergroupModel->browseUsergroup($Search_params, $start, $limit);

        $collectionModel = new Collection();
        $collection = $collectionModel->findOne(['collection_id' => $data['collection-id']]);
        if (!$collection) throw new NotFoundException();

        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_COMMUNITY_COLLECTION_ACCESS_PERMISSION,
        ];

        return $this->render('admin/set-permissions-browse-collections', ['page_step' => 2, 'data' => $res->payload, 'collection' => $collection, 'currentPage' => $page, 'pageCount' => $res->pageCount, 'breadcrum' => $breadcrum]);
    }

    public function setPermissionToCollection(Request $request)
    {
        $data = $request->getBody();

        $redirect = $data['redirect'] ?? false;

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

        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_COMMUNITY_COLLECTION_ACCESS_PERMISSION,
        ];

        if ($request->getMethod() === "POST") {
            $permissionInput = isset($data['permission']) ? $data['permission'] : '';
            $permissionModel = new CollectionPermission();
            $permission = $permissionModel->findOne(['collection_id' => $collection->collection_id, 'group_id' => $usergroup->id]);

            if ($permission && $permission->permission == $permissionInput) {
                $msg = 'Permission already granted';
                $msgType = 'alert';
            } else if ($permission && $permission->permission != $permissionInput) {
                if (Application::getUserRole() <= 2) {
                    $permissionModel->loadData($permission);
                    $permissionModel->permission = $permissionInput;
                    if ($permissionModel->validate()) {
                        if ($permissionModel->updatePermission()) {
                            $msg = 'Permission updated';
                            $msgType = 'success';
                        } else {
                            $msg = 'Something went wrong';
                            $msgType = 'error';
                        }
                    } else {
                        return $this->render('admin/set-permissions-select-collection-permissions', ['page_step' => 3, 'usergroup' => $usergroup, 'collection' => $collection_path_str, 'collection-id' => $collection->collection_id, 'permissionModel' => $permissionModel, 'redirect' => $redirect, 'breadcrum' => $breadcrum]);
                    }
                } else if (Application::getUserRole() == 3) {
                    $pendingContentCollectionPermissionModel = new PendingCollectionPermission();
                    $pendingPermission = $pendingContentCollectionPermissionModel->findOne(['collection_id' => $collection->collection_id, 'group_id' => $usergroup->id]);

                    if ($pendingPermission) {
                        if ($pendingPermission->permission == $permissionInput) {
                            $msg = 'Nothing to update. The permission you are selected is already in pending list';
                            $msgType = 'alert';
                        } else {
                            $pendingContentCollectionPermissionModel->loadData($pendingPermission);
                            $pendingContentCollectionPermissionModel->permission = $permissionInput;
                            if ($pendingContentCollectionPermissionModel->validate()) {
                                if ($pendingContentCollectionPermissionModel->updatePermission()) {
                                    $msg = 'Successfully updated pending permisson';
                                    $msgType = 'success';
                                } else {
                                    $msg = 'Something went wrong';
                                    $msgType = 'error';
                                }
                            } else {
                                return $this->render('admin/set-permissions-select-collection-permissions', ['page_step' => 3, 'usergroup' => $usergroup, 'collection' => $collection_path_str, 'collection-id' => $collection->collection_id, 'permissionModel' => $pendingContentCollectionPermissionModel, 'redirect' => $redirect, 'breadcrum' => $breadcrum]);
                            }
                        }
                    } else {
                        $pendingContentCollectionPermissionModel->loadData(['collection_id' => $collection->collection_id, 'group_id' => $usergroup->id, 'permission' => $permissionInput]);

                        if ($pendingContentCollectionPermissionModel->validate()) {


                            if ($pendingContentCollectionPermissionModel->save()) {
                                $msg = 'Successfully created new pending permisson request';
                                $msgType = 'success';
                            } else {
                                $msg = 'Something went wrong';
                                $msgType = 'error';
                            }
                        } else {

                            return $this->render('admin/set-permissions-select-collection-permissions', ['page_step' => 3, 'usergroup' => $usergroup, 'collection' => $collection_path_str, 'collection-id' => $collection->collection_id, 'permissionModel' => $pendingContentCollectionPermissionModel, 'redirect' => $redirect, 'breadcrum' => $breadcrum]);
                        }
                    }
                }
            } else {

                if (Application::getUserRole() <= 2) {
                    $permissionModel->loadData(['collection_id' => $collection->collection_id, 'group_id' => $usergroup->id, 'permission' => $permissionInput]);

                    if ($permissionModel->validate()) {
                        if ($permissionModel->save()) {
                            $msg = 'Successfully granted new permisson';
                            $msgType = 'success';
                        } else {
                            $msg = 'Something went wrong';
                            $msgType = 'error';
                        }
                    } else {
                        return $this->render('admin/set-permissions-select-collection-permissions', ['page_step' => 3, 'usergroup' => $usergroup, 'collection' => $collection_path_str, 'collection-id' => $collection->collection_id, 'permissionModel' => $permissionModel, 'redirect' => $redirect, 'breadcrum' => $breadcrum]);
                    }
                } else if (Application::getUserRole() == 3) {

                    $pendingContentCollectionPermissionModel = new PendingCollectionPermission();
                    $pendingPermission = $pendingContentCollectionPermissionModel->findOne(['collection_id' => $collection->collection_id, 'group_id' => $usergroup->id]);

                    if ($pendingPermission) {

                        if ($pendingPermission->permission == $permissionInput) {
                            $msg = 'Nothing to update. The permission you are selected is already in pending list.';
                            $msgType = 'alert';
                        } else {
                            $pendingContentCollectionPermissionModel->loadData($pendingPermission);
                            $pendingContentCollectionPermissionModel->permission = $permissionInput;

                            if ($pendingContentCollectionPermissionModel->validate()) {
                                if ($pendingContentCollectionPermissionModel->updatePermission()) {
                                    $msg = 'Successfully updated pending permisson';
                                    $msgType = 'success';
                                } else {
                                    $msg = 'Something went wrong';
                                    $msgType = 'error';
                                }
                            } else {
                                return $this->render('admin/set-permissions-select-collection-permissions', ['page_step' => 3, 'usergroup' => $usergroup, 'collection' => $collection_path_str, 'collection-id' => $collection->collection_id, 'permissionModel' => $pendingContentCollectionPermissionModel, 'redirect' => $redirect, 'breadcrum' => $breadcrum]);
                            }
                        }
                    } else {

                        $pendingContentCollectionPermissionModel->loadData(['collection_id' => $collection->collection_id, 'group_id' => $usergroup->id, 'permission' => $permissionInput]);

                        if ($pendingContentCollectionPermissionModel->validate()) {
                            if ($pendingContentCollectionPermissionModel->save()) {
                                $msg = 'Successfully created new pending permisson request';
                                $msgType = 'success';
                            } else {
                                $msg = 'Something went wrong';
                                $msgType = 'error';
                            }
                        } else {
                            return $this->render('admin/set-permissions-select-collection-permissions', ['page_step' => 3, 'usergroup' => $usergroup, 'collection' => $collection_path_str, 'collection-id' => $collection->collection_id, 'permissionModel' => $pendingContentCollectionPermissionModel, 'redirect' => $redirect, 'breadcrum' => $breadcrum]);
                        }
                    }
                }
            }

            Application::$app->session->setFlashMessage($msgType, $msg);

            if (isset($data['redirect']) && $data['redirect']) {
                Application::$app->response->redirect('/admin/view-collection-permission');
            } else {
                Application::$app->response->redirect('/admin/set-access-permission');
            }
        } else {

            $permissionModel = new CollectionPermission();
            $permission = $permissionModel->findOne(['collection_id' => $data['collection-id'], 'group_id' => $data['usergroup-id']]);

            return $this->render('admin/set-permissions-select-collection-permissions', ['page_step' => 3, 'usergroup' => $usergroup, 'collection' => $collection_path_str, 'collection-id' => $collection->collection_id, 'redirect' => $redirect, 'breadcrum' => $breadcrum, 'currentPermission' => $permission]);
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


    // public function viewAccessPermissionOnCollections()
    // {
    //     $permissionModel = new CollectionPermission();
    //     $data = $permissionModel->getAccessPermissionOnCollections();

    //     return $this->render('admin/set-permissions-browse', ['page_step' => 5, 'data' => $data]);
    // }


    public function viewAccessPermissionOnCollections(Request $request)
    {
        $data = $request->getBody();

        $Search_params = $data['q'] ?? '';
        $page = isset($data['page']) ? $data['page'] : 1;
        if ($page <= 0) $page = 1;
        $limit = 10;
        $start = ($page - 1) * $limit;

        $contentCollectionPermissionModel = new CollectionPermission();

        $res = $contentCollectionPermissionModel->getAccessPermissionOnCollections($start, $limit);

        // echo '<pre>';
        // var_dump($res->payload);
        // echo '</pre>';
        // $breadcrum = [
        //     self::BREADCRUM_DASHBOARD,
        //     self::BREADCRUM_MANAGE_CONTENT,
        //     self::BREADCRUM_
        // ]


        return $this->render('admin/view-collection-access-permission', ['data' => $res->payload, 'currentPage' => $page, 'pageCount' => $res->pageCount]);
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
                Application::$app->session->setFlashMessage('success', "Permission removed");
            } else {
                Application::$app->session->setFlashMessage('error', "Couldn't find the permission");
            }
        }

        Application::$app->response->redirect('/admin/view-collection-permission');
    }






    // ----------------------------------------------------------

    public function browseContentCollectionPermissions(Request $request)
    {
        $data = $request->getBody();

        $Search_params = $data['q'] ?? '';
        $page = isset($data['page']) ? $data['page'] : 1;
        if ($page <= 0) $page = 1;
        $limit = 10;
        $start = ($page - 1) * $limit;

        $contentCollectionModel = new ContentCollection();

        $res = $contentCollectionModel->browserContentCollections($Search_params, $start, $limit);


        return $this->render('admin/set-permissions-browse-content-collections', ['page_step' => 1, 'data' => $res->payload, 'currentPage' => $page, 'pageCount' => $res->pageCount]);
    }


    public function browseUsergroupForContentCollection(Request $request)
    {
        $data = $request->getBody();

        $Search_params = $data['q'] ?? '';
        $page = isset($data['page']) ? $data['page'] : 1;
        if ($page <= 0) $page = 1;
        $limit = 10;
        $start = ($page - 1) * $limit;

        $data = $request->getBody();
        $usergroupModel = new UserGroup();
        $res = $usergroupModel->browseUsergroup($Search_params, $start, $limit);

        $contentCollectionModel = new ContentCollection();
        $collection = $contentCollectionModel->loadContentCollection($data['collection-id']);

        return $this->render('admin/set-permissions-browse-content-collections', ['page_step' => 2, 'data' => $res->payload, 'collection' => $collection, 'currentPage' => $page, 'pageCount' => $res->pageCount]);
    }


    public function setPermissionToContentCollection(Request $request)
    {
        $data = $request->getBody();

        $collectionModel = new ContentCollection();
        $collection = $collectionModel->findOne(['id' => $data['collection-id']]);
        if (!$collection) throw new NotFoundException();

        $collection = $collectionModel->loadContentCollection($data['collection-id']);


        // Usergroup info
        $usergroupModel = new UserGroup();
        $usergroup = $usergroupModel->getUsergroupInfo($data['usergroup-id']);
        if (!$usergroup) throw new NotFoundException();


        if ($request->getMethod() === "POST") {

            $permissionInput = isset($data['permission']) ? $data['permission'] : '';
            $contentCollectionPermissionModel = new ContentCollectionPermission();
            $permission = $contentCollectionPermissionModel->findOne(['content_collection_id' => $collection->id, 'group_id' => $usergroup->id]);


            if ($permission && $permission->permission == $permissionInput) {
                $msg = 'Permission already granted';
                $msgType = 'alert';
            } else if ($permission && $permission->permission != $permissionInput) {
                if (Application::getUserRole() <= 2) {
                    $contentCollectionPermissionModel->loadData($permission);
                    $contentCollectionPermissionModel->permission = $permissionInput;


                    if ($contentCollectionPermissionModel->validate()) {

                        if ($contentCollectionPermissionModel->updatePermission()) {
                            $msg = 'Permission updated';
                            $msgType = 'success';
                        } else {
                            $msg = 'Something went wrong';
                            $msgType = 'error';
                        }
                    } else {
                        return $this->render('admin/set-permissions-select-permissions', ['page_step' => 3, 'usergroup' => $usergroup, 'collection' => $collection, 'permissionModel' => $contentCollectionPermissionModel]);
                    }
                } else if (Application::getUserRole() == 3) {
                    $pendingContentCollectionPermissionModel = new PendingContentCollectionPermission();
                    $pendingPermission = $pendingContentCollectionPermissionModel->findOne(['content_collection_id' => $collection->id, 'group_id' => $usergroup->id]);

                    if ($pendingPermission) {
                        if ($pendingPermission->permission == $permissionInput) {
                            $msg = 'Nothing to update. The permission you are selected is already in pending list';
                            $msgType = 'alert';
                        } else {
                            $pendingContentCollectionPermissionModel->loadData($pendingPermission);
                            $pendingContentCollectionPermissionModel->permission = $permissionInput;
                            if ($pendingContentCollectionPermissionModel->validate()) {
                                if ($pendingContentCollectionPermissionModel->updatePermission()) {
                                    $msg = 'Successfully updated pending permisson';
                                    $msgType = 'success';
                                } else {
                                    $msg = 'Something went wrong';
                                    $msgType = 'error';
                                }
                            } else {
                                return $this->render('admin/set-permissions-select-permissions', ['page_step' => 3, 'usergroup' => $usergroup, 'collection' => $collection, 'permissionModel' => $pendingContentCollectionPermissionModel]);
                            }
                        }
                    } else {
                        $pendingContentCollectionPermissionModel->loadData(['content_collection_id' => $collection->id, 'group_id' => $usergroup->id, 'permission' => $permissionInput]);

                        if ($pendingContentCollectionPermissionModel->validate()) {
                            if ($pendingContentCollectionPermissionModel->save()) {
                                $msg = 'Successfully created new pending permisson request';
                                $msgType = 'success';
                            } else {
                                $msg = 'Something went wrong';
                                $msgType = 'error';
                            }
                        } else {
                            return $this->render('admin/set-permissions-select-permissions', ['page_step' => 3, 'usergroup' => $usergroup, 'collection' => $collection, 'permissionModel' => $pendingContentCollectionPermissionModel]);
                        }
                    }
                }
            } else {
                if (Application::getUserRole() <= 2) {
                    $contentCollectionPermissionModel->loadData(['content_collection_id' => $collection->id, 'group_id' => $usergroup->id, 'permission' => $permissionInput]);

                    if ($contentCollectionPermissionModel->validate()) {
                        if ($contentCollectionPermissionModel->save()) {
                            $msg = 'Successfully granted new permisson';
                            $msgType = 'success';
                        } else {
                            $msg = 'Something went wrong';
                            $msgType = 'error';
                        }
                    } else {
                        return $this->render('admin/set-permissions-select-permissions', ['page_step' => 3, 'usergroup' => $usergroup, 'collection' => $collection, 'permissionModel' => $contentCollectionPermissionModel]);
                    }
                } else if (Application::getUserRole() == 3) {
                    $pendingContentCollectionPermissionModel = new PendingContentCollectionPermission();
                    $pendingPermission = $pendingContentCollectionPermissionModel->findOne(['content_collection_id' => $collection->id, 'group_id' => $usergroup->id]);


                    if ($pendingPermission) {

                        if ($pendingPermission->permission == $permissionInput) {
                            $msg = 'Nothing to update. The permission you are selected is already in pending list.';
                            $msgType = 'alert';
                        } else {
                            $pendingContentCollectionPermissionModel->loadData($pendingPermission);
                            $pendingContentCollectionPermissionModel->permission = $permissionInput;

                            if ($pendingContentCollectionPermissionModel->validate()) {
                                if ($pendingContentCollectionPermissionModel->updatePermission()) {
                                    $msg = 'Successfully updated pending permisson';
                                    $msgType = 'success';
                                } else {
                                    $msg = 'Something went wrong';
                                    $msgType = 'error';
                                }
                            } else {
                                return $this->render('admin/set-permissions-select-permissions', ['page_step' => 3, 'usergroup' => $usergroup, 'collection' => $collection, 'permissionModel' => $pendingContentCollectionPermissionModel]);
                            }
                        }
                    } else {
                        $pendingContentCollectionPermissionModel->loadData(['content_collection_id' => $collection->id, 'group_id' => $usergroup->id, 'permission' => $permissionInput]);

                        if ($pendingContentCollectionPermissionModel->validate()) {
                            if ($pendingContentCollectionPermissionModel->save()) {
                                $msg = 'Successfully created new pending permisson request';
                                $msgType = 'success';
                            } else {
                                $msg = 'Something went wrong';
                                $msgType = 'error';
                            }
                        } else {
                            return $this->render('admin/set-permissions-select-permissions', ['page_step' => 3, 'usergroup' => $usergroup, 'collection' => $collection, 'permissionModel' => $pendingContentCollectionPermissionModel]);
                        }
                    }
                }
            }

            Application::$app->session->setFlashMessage($msgType, $msg);
            Application::$app->response->redirect('/admin/set-content-collection-access-permission');
        } else {
            return $this->render('admin/set-permissions-select-permissions', ['page_step' => 3, 'usergroup' => $usergroup, 'collection' => $collection]);
        }
    }


    public function approveContentCollectionAccessPermission(Request $request)
    {
        $data = $request->getBody();

        $Search_params = $data['q'] ?? '';
        $page = isset($data['page']) ? $data['page'] : 1;
        if ($page <= 0) $page = 1;
        $limit = 10;
        $start = ($page - 1) * $limit;

        $pendingContentCollectionPermissionModel = new PendingContentCollectionPermission();
        $req = $pendingContentCollectionPermissionModel->getAllRequests($start, $limit);

        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_APPROVALS,
            self::BREADCRUM_APPROVE_ACCESS,
            self::BREADCRUM_REVIEW_CONTENT_COLLECTION_PERMISSION
        ];

        $this->render('admin/approve-content-collection-access-permission', ['data' => $req->payload, 'currentPage' => $page, 'pageCount' => $req->pageCount, 'breadcrum' => $breadcrum]);
    }

    public function reviewCollectionAccessPermission(Request $request)
    {
        $data = $request->getBody();

        $Search_params = $data['q'] ?? '';
        $page = isset($data['page']) ? $data['page'] : 1;
        if ($page <= 0) $page = 1;
        $limit = 10;
        $start = ($page - 1) * $limit;

        $pendingCollectionPermissionModel = new PendingCollectionPermission();
        $req = $pendingCollectionPermissionModel->getAllRequests($start, $limit);

        $communityModel = new Community();
        $paylaod = [];
        foreach ($req->payload as $i) {
            $res = $communityModel->communityBreadcrumGenerate($i->community_id);
            array_push($res, ['name' => $i->collection_name]);
            $path_name = [];
            foreach ($res as $r) {
                array_push($path_name, $r['name']);
            }
            $path = implode(' > ', $path_name);
            $i->collection_path = $path;
        }

        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_APPROVALS,
            self::BREADCRUM_APPROVE_ACCESS,
            self::BREADCRUM_REVIEW_COLLECTION_PERMISSION
        ];

        $this->render('admin/approve-collection-access-permission', ['data' => $req->payload, 'currentPage' => $page, 'pageCount' => $req->pageCount, 'breadcrum' => $breadcrum]);
    }

    public function approveCollectionAccessPermission(Request $request)
    {
        $data = $request->getBody();
        $pendingCollectionPermissionModel = new PendingCollectionPermission();
        $res = $pendingCollectionPermissionModel->approve($data['collection-id'], $data['group-id']);


        if ($res) {
            Application::$app->session->setFlashMessage('success', 'Access permission granted');
        } else {
            Application::$app->session->setFlashMessage('error', 'Something went wrong');
        }

        Application::$app->response->redirect('/admin/approve-access-permission/collections');
    }

    public function rejectCollectionAccessPermission(Request $request)
    {
        $data = $request->getBody();
        $pendingCollectionPermissionModel = new PendingCollectionPermission();
        $res = $pendingCollectionPermissionModel->reject($data['collection-id'], $data['group-id']);
        if ($res) {
            Application::$app->session->setFlashMessage('success', 'Access permission rejected');
        } else {
            Application::$app->session->setFlashMessage('error', 'Something went wrong');
        }
        Application::$app->response->redirect('/admin/approve-access-permission/collections');
    }

    public function approveAccessPermission(Request $request)
    {
        $data = $request->getBody();

        var_dump($data);
        $pendingContentCollectionPermissionModel = new PendingContentCollectionPermission();
        $res = $pendingContentCollectionPermissionModel->approve($data['collection-id'], $data['usergroup-id']);

        if ($res) {
            Application::$app->session->setFlashMessage('success', 'Access permission granted');
        } else {
            Application::$app->session->setFlashMessage('error', 'Something went wrong');
        }
        Application::$app->response->redirect('/admin/approve-access-permission/content-collections');
    }

    public function rejectAccessPermission(Request $request)
    {
        $data = $request->getBody();
        $pendingContentCollectionPermissionModel = new PendingContentCollectionPermission();
        $res = $pendingContentCollectionPermissionModel->reject($data['collection-id'], $data['usergroup-id']);
        if ($res) {
            Application::$app->session->setFlashMessage('success', 'Access permission rejected');
        } else {
            Application::$app->session->setFlashMessage('error', 'Something went wrong');
        }
        Application::$app->response->redirect('/admin/approve-access-permission/content-collections');
    }


    public function viewContentCollectionPermission(Request $request)
    {
        $data = $request->getBody();

        $Search_params = $data['q'] ?? '';
        $page = isset($data['page']) ? $data['page'] : 1;
        if ($page <= 0) $page = 1;
        $limit = 10;
        $start = ($page - 1) * $limit;

        $contentCollectionPermissionModel = new ContentCollectionPermission();

        if (Application::getUserRole() <= 2) {
            $res = $contentCollectionPermissionModel->viewContentCollectionPermissions($Search_params, $start, $limit);
            return $this->render('admin/view-access-permission', ['data' => $res->payload, 'currentPage' => $page, 'pageCount' => $res->pageCount]);
        } else if (Application::getUserRole() === 3) {
            $res = $contentCollectionPermissionModel->viewOnlyMyContentCollectionPermissions($Search_params, $start, $limit);
            return $this->render('admin/view-access-permission', ['data' => $res->payload, 'currentPage' => $page, 'pageCount' => $res->pageCount]);
        }
    }


    public function removeConentCollectionAccessPermission(Request $request)
    {
        $data = $request->getBody();
        var_dump($data);

        $contentCollectionPermissionModel = new ContentCollectionPermission();
        $res = $contentCollectionPermissionModel->removePermission($data['collection-id'], $data['group-id']);
        if ($res) {
            Application::$app->session->setFlashMessage('success', 'Access permission removed');
        } else {
            Application::$app->session->setFlashMessage('error', 'Something went wrong');
        }
        Application::$app->response->redirect('/admin/view-content-collection-permission');
    }
}

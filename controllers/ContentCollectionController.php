<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Request;
use app\models\ContentCollection;
use app\models\ContentCollectionContent;
use app\models\ContentCreator;

class ContentCollectionController extends Controller
{

    public function createContentCollection(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_USERS,
            self::BREADCRUM_CREATE_USER_GROUPS
        ];

        if ($request->getMethod() === 'POST') {
            $data = $request->getBody();
            $data_keys = array_keys($data);
            if (!in_array('name', $data_keys)) throw new NotFoundException();

            $contentCollection = new ContentCollection();
            $last_inserted_id = $contentCollection->createUsergroup($data);

            if ($last_inserted_id) {
                Application::$app->response->redirect('/admin/add-content?content-collection-id=' . $last_inserted_id);
                exit;
            }
            return $this->render("/admin/user/admin-create-content-collection", ['model' => $contentCollection, 'breadcrum' => $breadcrum]);
        }
        return $this->render("/admin/user/admin-create-content-collection", ['breadcrum' => $breadcrum]);
    }





    public function addContents(Request $request)
    {
        $data = $request->getBody();
        $data_keys = array_keys($data);
        if (!in_array('content-collection-id', $data_keys)) throw new NotFoundException();

        $Search_params = $data['q'] ?? '';

        $page = isset($data['page']) ? $data['page'] : 1;

        $limit = 20;
        $start = ($page - 1) * $limit;

        $contentCollectionModel = new ContentCollection();

        $content_collection = $contentCollectionModel->findOne(['id' => $data['content-collection-id']]);

        if ($content_collection) {
            $res = $contentCollectionModel->getAllContentsNotInThisGroup($content_collection->id, $Search_params, $start, $limit);
            $contentCreatorModel = new ContentCreator();
            $response = $contentCreatorModel->findAuthors($res->payload);

            $breadcrum = [
                self::BREADCRUM_DASHBOARD,
                self::BREADCRUM_MANAGE_CONTENT,
                self::BREADCRUM_MANAGE_CONTENT_COLLECTIONS,
            ];

            array_push($breadcrum, ['name' => $content_collection->name, 'link' => "/admin/manage-usergroup?usergroup-id=$content_collection->id"]);

            array_push($breadcrum, self::BREADCRUM_ADD_CONTENTS);



            $this->render('admin/user/add-contents', ['collection' => $content_collection, 'content_list' => $response, 'pageCount' => $res->pageCount, 'currentPage' => $page, 'search_params' => $Search_params, 'breadcrum' => $breadcrum]);
        } else {
            throw new NotFoundException();
        }
    }



    public function pushContentToContentCollection(Request $request)
    {
        $data = $request->getBody();

        $contentCollectionModel = new ContentCollection();


        if (isset($data['bulk_select_users_list'])) {

            $arr = explode(',', $data['bulk_select_users_list']);
            if ($contentCollectionModel->pushContentsToContentCollection($data['usergroup_id'], $arr)) {
                Application::$app->session->setFlashMessage('success', 'Users added successfully');
            } else {
                Application::$app->session->setFlashMessage('error', 'Something went wrong');
            }
        } else {

            if ($contentCollectionModel->pushContentToContentCollection($data['usergroup_id'], $data['user_reg_no'])) {
                echo '👉';
                Application::$app->session->setFlashMessage('success', 'User added successfully');
            } else {
                Application::$app->session->setFlashMessage('error', 'Something went wrong');
            }
        }

        $current_path = $_SERVER['REQUEST_URI'] ?? "/";
        Application::$app->response->redirect($current_path);
    }




    public function manageContentCollection(Request $request)
    {
        $data = $request->getBody();

        $Search_params = $data['q'] ?? '';
        $page = isset($data['page']) ? $data['page'] : 1;
        $limit = 10;
        $start = ($page - 1) * $limit;

        $contentCollectionModel = new ContentCollection();

        $content_collection = $contentCollectionModel->findOne(['id' => $data['content-collection-id']]);
        if (!$content_collection) throw new NotFoundException();

        $show_request_approval_btn = false;
        if ($content_collection->status === 3) $show_request_approval_btn = true;

        $res = $contentCollectionModel->getAllContentsInContentCollection($content_collection->id, $Search_params, $start, $limit);
        $contentCreatorModel = new ContentCreator();
        $response = $contentCreatorModel->findAuthors($res->payload);


        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_MANAGE_CONTENT_COLLECTIONS
        ];

        array_push($breadcrum, ['name' => $content_collection->name, 'link' => "/admin/manage-content-collection?content-collection-id=$content_collection->id"]);

        $this->render("admin/user/manage-content-collection", ['collection' => $content_collection, 'content_list' => $response, 'pageCount' => $res->pageCount, 'currentPage' => $page, 'search_params' => $Search_params, 'breadcrum' => $breadcrum, 'show_request_approval_btn' => $show_request_approval_btn]);
    }




    public function removeContent(Request $request)
    {
        $data = $request->getBody();
        // Validate request params
        $req_arr_keys = array_keys($data);
        if (!in_array('content-collection-id', $req_arr_keys) || !in_array('content-id', $req_arr_keys)) throw new NotFoundException();

        $contentCollectionContentModel = new ContentCollectionContent();

        if ($contentCollectionContentModel->removeContent($data['content-collection-id'], $data['content-id'])) {
            Application::$app->session->setFlashMessage('success', 'Success');
        } else {
            Application::$app->session->setFlashMessage('error', 'Something went wrong');
        }

        $content_collection = $data['content-collection-id'];

        Application::$app->response->redirect("/admin/manage-content-collection?content-collection-id=$content_collection");
    }


    public function requestApproval(Request $request)
    {
        $data  = $request->getBody();
        $contentCollectionModel = new ContentCollection();

        var_dump($data);

        $res = $contentCollectionModel->requestApproval($data['content-collection-id']);

        if ($res) {
            Application::$app->session->setFlashMessage('success', 'Request made successfull.');
        } else {
            Application::$app->session->setFlashMessage('error', 'Something went wrong.');
        }
        Application::$app->response->redirect('/admin/manage-content-collections');
    }





    public function manageAllUserGroups(Request $request)
    {

        $data = $request->getBody();
        $Search_params = $data['q'] ?? '';
        $page = isset($data['page']) ? $data['page'] : 1;
        $limit = 10;
        $start = ($page - 1) * $limit;

        $contentCollectionModel = new ContentCollection();


        $result = $contentCollectionModel->getAllContentCollections($Search_params, $start, $limit);
        if (!$result) throw new NotFoundException;

        if (($result->pageCount != 0 && $page > $result->pageCount) || $page <= 0) throw new NotFoundException();


        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_MANAGE_CONTENT_COLLECTIONS
        ];


        if (Application::getUserRole() <= 2) {
            $is_library_staff_member = true;
        } else if (Application::getUserRole() === 3) {
            $is_library_staff_member = false;
        }

        $this->render('admin/user/manage-all-content-collections', ['content-collections' => $result->payload, 'pageCount' => $result->pageCount, 'currentPage' => $page, 'search_params' => $Search_params, 'breadcrum' => $breadcrum, 'is_library_staff_member' => $is_library_staff_member]);
    }



    public function removeContentCollection(Request $request)
    {
        $data = $request->getBody();

        var_dump($data);

        $contentCollectionModel = new ContentCollection();

        $res = $contentCollectionModel->removeContentCollection($data['content-collection-id']);

        if ($res) {
            Application::$app->session->setFlashMessage('success', 'Request made successfull.');
        } else {
            Application::$app->session->setFlashMessage('error', 'Request made successfull.');
        }

        Application::$app->response->redirect('/admin/manage-content-collections');
    }




    public function approveContentCollections(Request $request)
    {
        $data = $request->getBody();
        $page = isset($data['page']) ? $data['page'] : 1;
        $limit  = 5;
        $start = ($page - 1) * $limit;
        $Search_params = $data['q'] ?? '';

        $contentCollectionModel = new ContentCollection();
        $result = $contentCollectionModel->getAllRequests($Search_params, $start, $limit);

        if (!$result) throw new NotFoundException;
        if (($result->pageCount != 0 && $page > $result->pageCount) || $page <= 0) throw new NotFoundException();


        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_APPROVALS,
            self::BREADCRUM_APPROVE_USER_GROUPS
        ];

        return $this->render("admin/approve/approve-content-collection", ['breadcrum' => $breadcrum, 'requests' => $result->payload, 'pageCount' => $result->pageCount, 'currentPage' => $page]);
    }




    public function approveCCRequest(Request $request)
    {
        $data = $request->getBody();

        $contentCollectionModel = new ContentCollection();
        $res = $contentCollectionModel->approve($data['content-collection-id']);

        if ($res) {
            Application::$app->session->setFlashMessage('success', 'Request made successfull.');
        } else {
            Application::$app->session->setFlashMessage('error', 'Something went wrong.');
        }

        Application::$app->response->redirect('/admin/approve-content-collections');
    }

    public function rejectContentCollection(Request $request)
    {
        $data = $request->getBody();

        var_dump($data);

        $contentCollectionModel = new ContentCollection();
        $res = $contentCollectionModel->reject($data['req_id'], $data['message']);

        if ($res) {
            Application::$app->session->setFlashMessage('success', 'Request made successfull.');
        } else {
            Application::$app->session->setFlashMessage('error', 'Something went wrong.');
        }

        Application::$app->response->redirect('/admin/approve-content-collections');
    }
}

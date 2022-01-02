<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\ForbiddenException;
use app\core\exception\NotFoundException;
use app\core\Request;
use app\models\CollectionPermission;
use app\models\Community;
use app\models\Content;
use app\models\ContentCollectionPermission;
use app\models\ContentSuggestion;
use app\models\Role;
use app\models\User;
use app\models\UserCollection;
use app\models\UserCollectionContent;
use stdClass;

class UserController extends Controller
{
    public function profile()
    {
        $userCollectionModel = new UserCollection();
        $userCollections = $userCollectionModel->getUserCollections();
        // var_dump($userCollections);
        // exit;
        return $this->render('user/profile', ['collections' => $userCollections]);
    }

    public function userCollection()
    {
        return $this->render('user/create-user-collection');
    }

    public function userCollections()
    {
        $userCollectionModel = new UserCollection();
        $allUserCollections = $userCollectionModel->getAllUserCollections();
        return $this->render('user/user-collections', ['allCollections' => $allUserCollections]);
    }

    //here
    public function getUserCollections()
    {
        $userCollectionModel = new UserCollection();
        $allUserCollections = $userCollectionModel->getAllUserCollections();
        return json_encode($allUserCollections);
    }

    public function manageCollectionTest()
    {
        return $this->render('user/test-user-collection');
    }

    public function manageCollection(Request $request)
    {
        $userCollectionModel = new UserCollection();
        $data = $request->getBody();
        $data_keys = array_keys($data);

        if (!in_array('collection-id', $data_keys)) {
            throw new NotFoundException();
        }
        // if (!$userCollectionModel->findUserCollection($data['user_collection_id'])) {
        //     throw new NotFoundException();
        // }
        $userCollectionID = $data['collection-id'];
        $userCollectionContentModel = new UserCollectionContent();
        $collectionContent = $userCollectionContentModel->getCollectionContent($userCollectionID);

        $userCollection = $userCollectionModel->findOne(['user_collection_id' => $data['collection-id']]);
        if ($userCollection) {
            // var_dump($userCollection);
            return $this->render('user/user-collection', ['model' => $userCollection, 'content' => $collectionContent]);
        }
        throw new NotFoundException();

        // var_dump($data);
        // exit;
    }

    public function viewPdfViewer(Request $request)
    {
        $data = $request->getBody();
        if (!isset($data['content_id'])) throw new NotFoundException();
        // if (!isset($data['reg_no'])) throw new ForbiddenException();

        $contentModel = new Content();
        $content = $contentModel->findOne(['content_id' => $data['content_id']]);
        if (!$content) throw new NotFoundException();

        // Access Permission
        $collectionPermissionModel = new CollectionPermission();
        $collectionPermissionObj = $collectionPermissionModel->checkAccessPermission($content->collection_id);

        $contentCollectionPermissionModel = new ContentCollectionPermission();
        $contentCollectionPermissionObj = $contentCollectionPermissionModel->checkAccessPermission($content->content_id);

        $permission = new stdClass;
        if ($collectionPermissionObj->permission || $contentCollectionPermissionObj->permission) {
            $permission->permission = true;

            if ($collectionPermissionObj->grant_type === "READ_DOWNLOAD" || $contentCollectionPermissionObj->grant_type === "READ_DOWNLOAD") {
                // $permission->grant_type = "READ_DOWNLOAD";
            } else {
                // $permission->grant_type = "READ";
            }
        } else {
            $permission->permission = false;
            // $permission->grant_type = "NULL";
            throw new ForbiddenException();
        }

        return $this->render('pdf-viewer', ['content' => $content]);
    }

    public function videoPlayer()
    {
        return $this->render('video-player');
    }

    public function suggestContent()
    {
        return $this->render('/user/suggest-content');
    }

    public function createNewUserCollection(Request $request)
    {
        $userCollectionModel = new UserCollection();
        // $userModel = new User();
        // echo "here";
        // var_dump($request->getBody());

        if ($request->getMethod() === 'POST') {
            if ($userCollectionModel->createUserCollection($request->getBody())) {
                Application::$app->session->setFlashMessage('success', 'Collection created');
                Application::$app->response->redirect('/profile');
                // echo Application::$app->session->getFlashMessage('success');
                exit;
            }
            return $this->render('/user/create-user-collection', ['model' => $userCollectionModel]);
        }
    }

    public function createContentSuggestion(Request $request)
    {
        $contentSuggestionModel = new ContentSuggestion();

        if ($request->getMethod() === 'POST') {
            if ($contentSuggestionModel->createContentSuggestion($request->getBody())) {
                Application::$app->session->setFlashMessage('success', 'New content suggestion added');
                Application::$app->response->redirect('/browse');
                exit;
            }
            return $this->render('/user/suggest-content', ['model' => $contentSuggestionModel]);
        }
    }

    public function editProfile()
    {
        return $this->render('user/edit-profile');
    }
}

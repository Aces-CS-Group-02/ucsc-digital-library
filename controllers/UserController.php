<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Request;
use app\models\Community;
use app\models\Role;
use app\models\User;
use app\models\UserCollection;

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

    public function manageCollectionTest()
    {
        return $this->render('user/test-user-collection');
    }

    public function manageCollection(Request $request)
    {
        $userCollectionModel = new UserCollection();
        $data = $request->getBody();

        // if (!$userCollectionModel->findUserCollection($data['user_collection_id'])) {
        //     throw new NotFoundException();
        // }

        // $userCollection = $userCollectionModel->findUserCollection($data['user_collection_id']);
        // var_dump($data);
        // exit;
        return $this->render('user/user-collection');
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

    public function editProfile()
    {
        return $this->render('user/edit-profile');
    }
}

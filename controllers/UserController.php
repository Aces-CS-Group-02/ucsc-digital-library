<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\ForbiddenException;
use app\core\exception\NotFoundException;
use app\core\Mail;
use app\core\Request;
use app\models\Bookmark;
use app\models\CollectionPermission;
use app\models\Community;
use app\models\Content;
use app\models\ContentCollectionPermission;
use app\models\ContentLanguage;
use app\models\ContentSuggestion;
use app\models\ContentViewRecords;
use app\models\Note;
use app\models\DeleteUsers;
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
        $userCollectionModel = new UserCollection();
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

        $userCollection = $userCollectionModel->findOne(['user_collection_id' => $userCollectionID]);
        if ($userCollection) {
            $userCollectionContentModel = new UserCollectionContent();
            $collectionContent = $userCollectionContentModel->getCollectionContent($userCollectionID);
            $contentModel = new Content();
            $contentData = [];
            $i = 0;
            foreach ($collectionContent as $content) {
                $content_id = $content["content_id"];
                $contentData[$i] = $contentModel->findOne(['content_id' => $content_id]);
                $i++;
            }
            // echo '<pre>';
            // var_dump($contentData);
            // echo '</pre>';
            // exit;
            return $this->render('user/user-collection', ['model' => $userCollection, 'content' => $collectionContent, 'content_data' => $contentData]);
        }
        throw new NotFoundException();

        // var_dump($data);
        // exit;
    }

    public function editCollection(Request $request)
    {
        $userCollectionModel = new UserCollection();
        $data = $request->getBody();
        $data_keys = array_keys($data);

        if (!in_array('collection-id', $data_keys)) {
            throw new NotFoundException();
        }

        // var_dump($data);
        // exit;
        $userCollectionID = $data['collection-id'];
        $userCollection = $userCollectionModel->findOne(['user_collection_id' => $userCollectionID]);
        if ($userCollection) {
            return $this->render('user/edit-user-collection', ['model' => $userCollection]);
        }
        throw new NotFoundException();
    }

    public function saveEditCollection(Request $request)
    {
        $userCollectionModel = new UserCollection();
        $data = $request->getBody();
        $data_keys = array_keys($data);

        if (!in_array('collection-id', $data_keys)) {
            throw new NotFoundException();
        }

        // var_dump($data);
        // exit;
        $userCollectionID = $data['collection-id'];
        $userCollection = $userCollectionModel->findOne(['user_collection_id' => $userCollectionID]);
        if ($userCollection) {
            if ($userCollectionModel->editUserCollection($data)) {
                Application::$app->session->setFlashMessage('success', 'Collection edited');
                Application::$app->response->redirect('/profile');
                exit;
            }
            return $this->render('/user/edit-user-collection', ['model' => $userCollectionModel]);

            // return $userCollectionModel->editUserCollection($data);
        }
        throw new NotFoundException();
    }

    public function removeUserCollection(Request $request)
    {
        $data = $request->getBody();
        // var_dump($data['user_collection_id']);
        $data_keys = array_keys($data);
        if (!in_array('user_collection_id', $data_keys)) {
            echo 'failed';
            exit;
        }

        $userCollectionModel = new userCollection();
        if ($userCollectionModel->deleteUserCollection($data['user_collection_id'])) {
            return Application::$app->session->setFlashMessage('success', 'Collection removed');
            // Application::$app->response->redirect('/profile');
            // echo Application::$app->session->getFlashMessage('success');
            exit;
        } else {
            return Application::$app->session->setFlashMessage('error', 'Something went wrong');
            // Application::$app->response->redirect('/profile');
            exit;
        }
    }

    public function getCollectionContent(Request $request)
    {
        $data = $request->getBody();
        // var_dump($request->getBody());

        $userCollectionContentModel = new UserCollectionContent();
        $contentExists = $userCollectionContentModel->findOne(['user_collection_id' => $data['user_collection_id'], 'content_id' => $data['content_id']]);
        if ($contentExists) return true;
        return false;
        // if($contentExists) var_dump($contentExists);
        // echo ("no content!");
    }

    public function addContentToCollection(Request $request)
    {
        $_POST = json_decode(file_get_contents('php://input'), true);
        // $data = $request->getBody();
        // $dataObject = json_decode($data);
        // var_dump($data);
        $collectionId = $_POST["user_collection_id"];
        $contentId = $_POST["content_id"];

        $userCollectionModel = new UserCollection();
        $collectionData = $userCollectionModel->findOne(['user_collection_id' => $collectionId]);
        // var_dump($collectionData->name);
        $returnData = new stdClass();
        if ($userCollectionModel->addContentToCollection($collectionId, $contentId)) {
            $returnData->action = "added";
            $returnData->message = '✔️ Content added to "' . $collectionData->name . '" !';
            return json_encode($returnData);
        } else {
            $returnData->action = "error";
            $returnData->message = '❗ Error. Something went wrong!';
            return json_encode($returnData);
        }
    }

    public function removeContentFromCollection(Request $request)
    {
        $_POST = json_decode(file_get_contents('php://input'), true);

        // $data = $request->getBody();
        // $dataObject = json_decode($data[]);

        // return $dataObject->name;
        $collectionId = $_POST["user_collection_id"];
        $contentId = $_POST["content_id"];
        // var_dump($_POST["user_collection_id"]);

        $userCollectionModel = new UserCollection();

        $userCollectionContentModel = new UserCollectionContent();
        $collectionData = $userCollectionModel->findOne(['user_collection_id' => $collectionId]);
        // var_dump($collectionData->name);
        $returnData = new stdClass();
        if ($userCollectionContentModel->removeContentFromCollection($collectionId, $contentId)) {
            $returnData->action = "removed";
            $returnData->message = '❌ Content removed from "' . $collectionData->name . '" !';
            return json_encode($returnData);
        } else {
            $returnData->action = "error";
            $returnData->message = '❗ Error. Something went wrong!';
            return json_encode($returnData);

            // echo 'Error. Something went worng!';
        }
    }

    public function createUserCollectionAndAddContent(Request $request)
    {
        $_POST = json_decode(file_get_contents('php://input'), true);

        // var_dump($_POST);

        $userCollectionModel = new UserCollection();

        if ($request->getMethod() === 'POST') {
            $returnData = new stdClass();
            if ($userCollectionModel->createUserCollectionAndAddContent($_POST)) {
                // echo "collection created!";
                $returnData->action = "added";
                $returnData->message = '✔️ Content added to new collection "' . $_POST["name"] . '" !';
                return json_encode($returnData);
            } else {
                $returnData->action = "error";
                $returnData->message = '❗ Error. Something went wrong!';
                return json_encode($returnData);
            }
        }
    }

    public function viewPdfViewer(Request $request)
    {
        $data = $request->getBody();
        if (!isset($data['content_id'])) throw new NotFoundException();

        $contentModel = new Content();
        $content = $contentModel->findOne(['content_id' => $data['content_id']]);
        if (!$content) throw new NotFoundException();


        $permission = ContentController::checkContentPermission($content->content_id);
        if (!$permission->permission) throw new ForbiddenException();
        // echo '<pre>';
        // var_dump($content->type);
        // echo '</pre>';
        // exit;
        if (Application::$app->user) {
            if (Application::$app->user->reg_no) {
                $regNo = Application::$app->user->reg_no;
            }
        } else {
            $regNo = 0;
        }
        if ($content->publish_state == 1 || $regNo == 2 || $regNo == 1) {
            if ($content->publish_state == 1) {
                $contentViewRecordsModel = new ContentViewRecords();
                $contentViewRecordsModel->addRecord(['content_id' => $data['content_id']]);
            }
            if ($content->type <= 6 && $content->type >= 1)
                return $this->render('pdf-viewer', ['content' => $content, 'permission' => $permission->grant_type, 'user_reg_no' => $regNo]);
        }
    }

    //here
    public function addContentBookmark()
    {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $contentId = $_POST["content_id"];
        $pageNo = $_POST["page_no"];
        // $data = $request->getBody();
        // var_dump($contentId,$pageNo);
        $bookmarkModel = new Bookmark();
        $reg_no = Application::$app->user->reg_no;
        $bookmark = $bookmarkModel->findOne(['content_id' => $contentId, 'reg_no' => $reg_no, 'page_no' => $pageNo]);
        if ($bookmark) {
            echo "Bookmark already exists on page " . $pageNo . "!";
        } else {
            $bookmarkModel->saveBookmark(['content_id' => $contentId, 'page_no' => $pageNo]);
            echo "Bookmark added for page " . $pageNo . "!";
        }
    }

    public function getContentBookmark()
    {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $contentId = $_POST["content_id"];

        // $data = $request->getBody();
        // var_dump($contentId,$pageNo);
        $bookmarkModel = new Bookmark();
        $reg_no = Application::$app->user->reg_no;
        $bookmarks = $bookmarkModel->findAll(['content_id' => $contentId, 'reg_no' => $reg_no]);
        $bookmarkData = [];
        foreach ($bookmarks as $bookmark) {
            $temp = new stdClass;
            $temp->id = $bookmark['bookmark_id'];
            $temp->page = $bookmark['page_no'];
            $temp->content = $bookmark['content_id'];
            array_push($bookmarkData, $temp);
        }
        return json_encode($bookmarkData);
        // var_dump($bookmarks);
        // return $bookmarks;
        // return "test";
        // return $bookmarks;
    }

    public function saveContentNote(Request $request)
    {
        $data = $request->getBody();
        $noteModel = new Note();
        $reg_no = Application::$app->user->reg_no;

        $note = $noteModel->findOne(['content_id' => $data['content_id'], 'reg_no' => $reg_no]);
        if ($note) {
            $ifUpdated = $noteModel->UpdateNote($data['note'], $note->note_id);
            // var_dump($ifUpdated);
        } else {
            $noteModel->saveNote($request->getBody());
            // echo "saved";
        }
    }

    public function getContentNote(Request $request)
    {
        $data = $request->getBody();
        // var_dump($request->getBody());
        $noteModel = new Note();
        $reg_no = Application::$app->user->reg_no;

        if ($request->getMethod() === 'GET') {
            $noteData = $noteModel->findOne(['content_id' => $data['content_id'], 'reg_no' => $reg_no]);
            // var_dump($noteData);
            if ($noteData) {
                $noteDataHtml = html_entity_decode(html_entity_decode($noteData->note));
                // var_dump($noteData->note);
                // var_dump($noteDataHtml);
                return $noteDataHtml;
            }
        }
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

    public function deleteUsers(Request $request)
    {
        $user = new User();

        if ($request->isPOST()) {
            $data = $request->getBody();
            $user = $user->findOne(["reg_no" => $data["reg_no"]]);
            $reason = $data["reason"];

            if ($user) {

                $deleteUser = new DeleteUsers();
                $deleteUser->email = $user->email;
                $deleteUser->reason = $reason;
                $deleteUser->deleted_by = Application::$app->user->reg_no;

                $subject = "Account is deleted";

                if ($reason) {
                    $body = "<h3> This email is to inform that your UCSC Digital Library account has been removed by the administration 
                            due to the following reason(s).</h3>
                            <p>{$reason}</p>";
                } else {
                    $body = "<h3> This email is to inform that your UCSC Digital Library account has been removed by the administration";
                }
                $altBody = "this is the alt body";
                $mail = new Mail([$user->email], $subject, $body, $altBody);
                $mail->sendMail();

                if ($user->delete() && $deleteUser->save()) {
                    Application::$app->session->setFlashMessage('success', 'Selected user is successfully deleted from the system');
                } else {
                    Application::$app->session->setFlashMessage('error', 'The user you are trying to delete does not exists');
                }
                Application::$app->response->redirect('/admin/users');
            } else {
                Application::$app->session->setFlashMessage('error', 'The user you are trying to delete does not exists');
                Application::$app->response->redirect('/admin/users');
            }
        }
    }
}

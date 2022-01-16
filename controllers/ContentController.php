<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Request;
use app\models\Collection;
use app\models\CollectionPermission;
use app\models\Community;
use app\models\Content;
use app\models\ContentCollectionPermission;
use app\models\ContentCreator;
use app\models\ContentKeyword;
use app\models\ContentLanguage;
use app\models\ContentPublishStateChange;
use app\models\ContentType;
use app\models\Creator;
use app\models\DeleteContent;
use DateTime;
use Dotenv\Util\Regex;
use Exception;
use stdClass;

class ContentController extends Controller
{

    public function insertMetaData(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_UPLOAD_CONTENT
        ];

        return $this->render("admin/content/insert-metadata", ['breadcrum' => $breadcrum]);
    }

    public function insertKeywordAbstract(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_UPLOAD_CONTENT
        ];

        return $this->render("admin/content/insert-keyword-abstract", ['breadcrum' => $breadcrum]);
    }

    public function submitContent(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_UPLOAD_CONTENT
        ];

        return $this->render("admin/content/submit-content", ['breadcrum' => $breadcrum]);
    }

    public function verifySubmission(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_UPLOAD_CONTENT
        ];

        return $this->render("admin/content/verify-submission", ['breadcrum' => $breadcrum]);
    }

    public function mySubmissions(Request $request)
    {
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_MY_SUBMISSIONS
        ];
        return $this->render("admin/content/admin-my-submission", ['breadcrum' => $breadcrum]);
    }



    public function uploadContent(Request $request)
    {
        $content = new Content();

        if ($request->isPOST()) {

            $data = [];
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }

            $data_keys = array_keys($data);

            if (in_array('content_id', $data_keys)) {
                $content = $content->findOne(['content_id' => $data['content_id']]);

                if (!$content) {
                    throw new NotFoundException();
                }

                $content->loadData($request->getBody());

                if ($content->update()) {
                    Application::$app->response->redirect('/admin/upload-content/metadata?content_id=' . $data['content_id']);
                }
            } else {
                $input = $request->getBody();

                $content->collection_id = $input['collection_id'];

                $content->upload_steps = 1;
                $content->publish_state = 0;

                // var_dump($content);

                if ($content->save()) {
                    $last_inserted_id = Application::$app->db->pdo->lastInsertId();
                    Application::$app->response->redirect('/admin/upload-content/metadata?content_id=' . $last_inserted_id);
                }
            }
        } else {
            $breadcrum = [
                self::BREADCRUM_DASHBOARD,
                self::BREADCRUM_MANAGE_CONTENT,
                self::BREADCRUM_UPLOAD_CONTENT
            ];

            $data = $request->getBody();
            $data_keys = array_keys($data);

            $collection_id = 0;

            $collections = new Collection();

            $collections = $collections->getAll();

            $collection_id = $collections[0]->collection_id;

            foreach ($collections as $collection) {

                $community =  new Community();

                $community =  $community->findCommunity($collection->community_id);
                $collection->parent_community = $community->name;
            }

            $upload_steps = 0;

            if (in_array('content_id', $data_keys)) {
                $content = new Content();
                $content = $content->findOne(['content_id' => $data['content_id']]);

                if (!$content) {
                    throw new NotFoundException();
                }

                $collection_id = $content->collection_id;
                $upload_steps = $content->upload_steps;
            }

            return $this->render("admin/content/select-collection", ['breadcrum' => $breadcrum, 'collections' => $collections, 'collection_id' => $collection_id, 'upload_steps' => $upload_steps, 'data' => $data]);
        }
    }

    public function updateMetadata(Request $request)
    {

        $content = new Content();

        // var_dump($_GET);

        if ($request->isPOST()) {
            $data = [];
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
            if (!$content->findOne(['content_id' => $data['content_id']])) {
                throw new NotFoundException();
            }

            $content = $content->findOne(['content_id' => $data['content_id']]);

            $form_input = $request->getBody();

            $content_creator = new ContentCreator();

            $where = [
                'content_id' => $data['content_id']
            ];

            try {
                Application::$app->db->pdo->beginTransaction();
                $content_creator->deleteAll($where);


                foreach ($form_input['creators'] as $creator) {
                    $content_creator = new ContentCreator();
                    $content_creator->content_id = $data['content_id'];
                    $content_creator->creator = $creator;

                    $content_creator->save();
                }

                $content->loadData($request->getBody());
                if ($content->upload_steps < 2) $content->upload_steps = 2;


                $content->update();
                // exit;

                Application::$app->db->pdo->commit();
            } catch (Exception $e) {
                Application::$app->db->pdo->rollBack();
            }

            // exit;

            Application::$app->response->redirect('/admin/upload-content/insert-keyword-abstract?content_id=' . $data['content_id']);
        } else {

            $data = $request->getBody();
            $upload_steps = 0;

            $content = $content->findOne(['content_id' => $data['content_id']]);
            if (!$content) {
                throw new NotFoundException();
            }

            $upload_steps = $content->upload_steps;
            $breadcrum = [
                self::BREADCRUM_DASHBOARD,
                self::BREADCRUM_MANAGE_CONTENT,
                self::BREADCRUM_UPLOAD_CONTENT
            ];

            $contentTypes = new ContentType();

            $contentTypes = $contentTypes->getAll();

            $languages = new ContentLanguage();
            $languages = $languages->getAll();
            $creators = [];
            $content_creators = new ContentCreator();

            $content_creators = $content_creators->findAll(['content_id' => $data['content_id']]);

            foreach ($content_creators as $content_creator) {
                array_push($creators, $content_creator['creator']);
            }

            return $this->render("admin/content/insert-metadata", ['breadcrum' => $breadcrum, 'content' => $content, 'creators' => $creators, 'languages' => $languages, 'contentTypes' => $contentTypes, 'upload_steps' => $upload_steps, 'data' => $data]);
        }
    }

    public function updateKeywordAbstract(Request $request)
    {
        $content =  new Content();

        if ($request->isPOST()) {
            $data = [];
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
            if (!$content->findOne(['content_id' => $data['content_id']])) {
                throw new NotFoundException();
            }

            $content = $content->findOne(['content_id' => $data['content_id']]);

            $form_input = $request->getBody();

            var_dump($form_input);

            $content_keyword = new ContentKeyword();

            $where = [
                'content_id' => $data['content_id']
            ];

            try {
                Application::$app->db->pdo->beginTransaction();
                $content_keyword->deleteAll($where);


                foreach ($form_input['keywords'] as $keyword) {
                    $content_keyword = new ContentKeyword();
                    $content_keyword->content_id = $data['content_id'];
                    $content_keyword->keyword = $keyword;

                    // echo '<pre>';
                    // var_dump($content_keyword);
                    // echo '<pre>';

                    $content_keyword->save();
                }

                $content->loadData($request->getBody());

                if ($content->upload_steps < 3) $content->upload_steps = 3;



                $content->update();

                Application::$app->db->pdo->commit();
            } catch (Exception $e) {
                Application::$app->db->pdo->rollBack();
            }

            Application::$app->response->redirect('/admin/upload-content/upload-file?content_id=' . $data['content_id']);
        } else {
            $data = $request->getBody();

            $content = $content->findOne(['content_id' => $data['content_id']]);

            if (!$content) {
                throw new NotFoundException();
            }

            $upload_steps = $content->upload_steps;

            $breadcrum = [
                self::BREADCRUM_DASHBOARD,
                self::BREADCRUM_MANAGE_CONTENT,
                self::BREADCRUM_UPLOAD_CONTENT
            ];

            $content_keywords = new ContentKeyword();
            $keywords = [];

            $content_keywords = $content_keywords->findAll(['content_id' => $data['content_id']]);

            foreach ($content_keywords as $content_keyword) {
                array_push($keywords, $content_keyword['keyword']);
            }

            // var_dump($keywords);

            return $this->render("admin/content/insert-keyword-abstract", ['breadcrum' => $breadcrum, 'content' => $content, 'keywords' => $keywords, 'upload_steps' => $upload_steps, 'data' => $data]);
        }
    }

    public function uploadFile(Request $request)
    {
        $content = new Content();

        if ($request->isPOST()) {
            $data = [];
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
            if (!$content->findOne(['content_id' => $data['content_id']])) {
                var_dump($data);
                throw new NotFoundException();
            }

            $content = $content->findOne(['content_id' => $data['content_id']]);

            // $form_input = $request->getBody();


            $file = $_FILES['content-file'];
            var_dump($file);


            if ($file['tmp_name'] == "" and $content->url != "") {
                Application::$app->response->redirect('/admin/upload-content/verify?content_id=' . $data['content_id']);
            }

            $temp = explode(".", $file["name"]);
            $newfilename =  $data['content_id'] . '.' . end($temp);


            $file['name'] = $newfilename;
            $content->url = "data/content/uploads/" . $file['name'];

            if ($content->upload_steps < 4) $content->upload_steps = 4;



            $content->update();

            if (move_uploaded_file($file['tmp_name'], $content->url)) {
                Application::$app->response->redirect('/admin/upload-content/verify?content_id=' . $data['content_id']);
            }
        } else {
            $data = $request->getBody();

            $content = $content->findOne(['content_id' => $data['content_id']]);

            if (!$content) {
                throw new NotFoundException();
            }

            $breadcrum = [
                self::BREADCRUM_DASHBOARD,
                self::BREADCRUM_MANAGE_CONTENT,
                self::BREADCRUM_UPLOAD_CONTENT
            ];

            $upload_steps = $content->upload_steps;

            return $this->render("admin/content/submit-content", ['breadcrum' => $breadcrum, 'upload_steps' => $upload_steps, 'data' => $data]);
        }
    }

    public function verify(Request $request)
    {
        $content = new Content();

        if ($request->isPOST()) {
            $data = [];
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
            if (!$content->findOne(['content_id' => $data['content_id']])) {
                throw new NotFoundException();
            }

            $content = $content->findOne(['content_id' => $data['content_id']]);

            if ($content->upload_steps < 5) $content->upload_steps = 5;

            $content->update();

            Application::$app->response->redirect('/admin/my-submissions');
        } else {
            $data = $request->getBody();

            $content = $content->findOne(['content_id' => $data['content_id']]);

            if (!$content) {
                throw new NotFoundException();
            }

            $collection = new Collection();
            $community =  new Community();
            $creators = new ContentCreator();
            $keywords = new ContentKeyword();
            $language = new ContentLanguage();
            $type = new ContentType();

            $collection = $collection->findOne(['collection_id' => $content->collection_id]);
            $collection->parent = $community->findCommunity($collection->community_id);
            $creators = $creators->findAll(['content_id' => $data['content_id']]);
            $keywords = $keywords->findAll(['content_id' => $data['content_id']]);
            $language = $language->findOne(['language_id' => $content->language]);
            $type = $type->findOne(['content_type_id' => $content->type]);

            $breadcrum = [
                self::BREADCRUM_DASHBOARD,
                self::BREADCRUM_MANAGE_CONTENT,
                self::BREADCRUM_UPLOAD_CONTENT
            ];

            $upload_steps = $content->upload_steps;

            return $this->render("admin/content/verify-submission", ['breadcrum' => $breadcrum, 'content' => $content, 'collection' => $collection, 'creators' => $creators, 'keywords' => $keywords, 'language' => $language, 'type' => $type, 'upload_steps' => $upload_steps, 'data' => $data]);
        }
    }

    public function loadPublishContentPage(Request $request)
    {

        $data = $request->getBody();

        $search_params = $data['q'] ?? '';
        $page = isset($data['page']) ? $data['page'] : 1;
        if ($page <= 0) $page = 1;
        $limit = 10;
        $start = ($page - 1) * $limit;

        $contentModel = new Content();
        $allUnpublishedContent = $contentModel->getAllUnpublishContent($search_params, $start, $limit);

        foreach ($allUnpublishedContent->payload as $c) {
            $content_creators = new ContentCreator();
            $content_keywords = new ContentKeyword();

            $content_creators = $content_creators->findAll(['content_id' => $c->content_id]);
            $content_keywords = $content_keywords->findAll(['content_id' => $c->content_id]);

            $c->creators = $content_creators;
            $c->keywords = $content_keywords;
        }

        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_PUBLISH_CONTENT
        ];

        return $this->render('admin/content/publish-content', ['content' => $allUnpublishedContent->payload, 'currentPage' => $page, 'pageCount' => $allUnpublishedContent->pageCount, 'search_params' => $search_params, 'breadcrum' => $breadcrum]);
    }
    public function loadUnpublishContentPage(Request $request)
    {
        $data = $request->getBody();

        $search_params = $data['q'] ?? '';
        $page = isset($data['page']) ? $data['page'] : 1;
        if ($page <= 0) $page = 1;
        $limit = 10;
        $start = ($page - 1) * $limit;

        $contentModel = new Content();
        $allPublishedContent = $contentModel->getAllPublishContent($search_params, $start, $limit);


        foreach ($allPublishedContent->payload as $c) {
            $content_creators = new ContentCreator();
            $content_keywords = new ContentKeyword();

            $content_creators = $content_creators->findAll(['content_id' => $c->content_id]);
            $content_keywords = $content_keywords->findAll(['content_id' => $c->content_id]);

            $c->creators = $content_creators;
            $c->keywords = $content_keywords;
        }
        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_UNPUBLISH_CONTENT
        ];

        return $this->render('admin/content/unpublish-content', ['content' => $allPublishedContent->payload, 'currentPage' => $page, 'pageCount' => $allPublishedContent->pageCount, 'search_params' => $search_params, 'breadcrum' => $breadcrum]);
    }
    public function viewUnpublishContentDetails(Request $request)
    {
        $contentModel = new Content();

        $data = $request->getBody();
        $data_keys = array_keys($data);

        if (!in_array('content_id', $data_keys)) {
            throw new NotFoundException();
        }

        $contentData = $contentModel->findOne(['content_id' => $data['content_id']]);

        $infoPublishContent = $contentModel->getInfoPublishedContent($contentData->content_id);


        $content_creators = new ContentCreator();
        $content_keywords = new ContentKeyword();

        $content_creators = $content_creators->findAll(['content_id' => $infoPublishContent->content_id]);
        $content_keywords = $content_keywords->findAll(['content_id' => $infoPublishContent->content_id]);

        $infoPublishContent->creators = $content_creators;
        $infoPublishContent->keywords = $content_keywords;
        // echo '<pre>';
        // var_dump($infoPublishContent);
        // echo '</pre>';
        // exit;
        if ($contentData) {
            $breadcrum = [
                self::BREADCRUM_DASHBOARD,
                self::BREADCRUM_MANAGE_CONTENT,
                self::BREADCRUM_PUBLISH_CONTENT,
                self::BREADCRUM_PUBLISH_CONTENT_VIEW
            ];

            return $this->render('admin/content/info-unpublish-content', ['model' => $infoPublishContent, 'breadcrum' => $breadcrum]);
        }
        throw new NotFoundException();
    }
    public function viewPublishContentDetails(Request $request)
    {
        $contentModel = new Content();

        $data = $request->getBody();
        $data_keys = array_keys($data);

        if (!in_array('content_id', $data_keys)) {
            throw new NotFoundException();
        }

        $contentData = $contentModel->findOne(['content_id' => $data['content_id']]);

        $infoUnpublishContent = $contentModel->getInfoUnpublishedContent($contentData->content_id);

        $content_creators = new ContentCreator();
        $content_keywords = new ContentKeyword();


        $content_creators = $content_creators->findAll(['content_id' => $infoUnpublishContent->content_id]);
        $content_keywords = $content_keywords->findAll(['content_id' => $infoUnpublishContent->content_id]);

        $infoUnpublishContent->creators = $content_creators;
        $infoUnpublishContent->keywords = $content_keywords;

        if ($contentData) {
            $breadcrum = [
                self::BREADCRUM_DASHBOARD,
                self::BREADCRUM_MANAGE_CONTENT,
                self::BREADCRUM_PUBLISH_CONTENT,
                self::BREADCRUM_UNPUBLISH_CONTENT_VIEW
            ];

            return $this->render('admin/content/info-publish-content', ['model' => $infoUnpublishContent, 'breadcrum' => $breadcrum]);
        }
        throw new NotFoundException();
    }

    public function publishingContent(Request $request)
    {
        $contentModel = new Content();

        if ($request->isPOST()) {

            $data = $request->getBody();
            $contentData = $contentModel->findOne(['content_id' => $data['content_id']]);

            if ($contentData) {
                $updatePublishState = $contentModel->doPublishContent($contentData->content_id);

                if ($updatePublishState) {
                    Application::$app->session->setFlashMessage('success', 'Selected content was successfully published on the system');
                    Application::$app->response->redirect('/admin/publish-content');
                } else {
                    Application::$app->session->setFlashMessage('error', 'Selected content was not published on the system');
                    Application::$app->response->redirect('/admin/publish-content');
                }
            } else {
                Application::$app->session->setFlashMessage('error', 'Selected content does not exist on the system');
                Application::$app->response->redirect('/admin/publish-content');
            }
        }
    }
    public function unpublishingContent(Request $request)
    {
        $contentModel = new Content();

        if ($request->isPOST()) {

            $data = $request->getBody();
            $contentData = $contentModel->findOne(['content_id' => $data['content_id']]);

            if ($contentData) {
                $updatePublishState = $contentModel->doUnpublishContent($contentData->content_id);

                if ($updatePublishState) {
                    Application::$app->session->setFlashMessage('success', 'Selected content was successfully unpublished on the system');
                    Application::$app->response->redirect('/admin/unpublish-content');
                } else {
                    Application::$app->session->setFlashMessage('error', 'Selected content was not unpublished on the system');
                    Application::$app->response->redirect('/admin/unpublish-content');
                }
            } else {
                Application::$app->session->setFlashMessage('error', 'Selected content does not exist on the system');
                Application::$app->response->redirect('/admin/publish-content');
            }
        }
    }
    public function manageContent(Request $request)
    {

        $data = $request->getBody();

        $search_params = $data['q'] ?? '';
        $page = isset($data['page']) ? $data['page'] : 1;
        if ($page <= 0) $page = 1;
        $limit = 10;
        $start = ($page - 1) * $limit;

        $contentModel = new Content();
        $allContent = $contentModel->getAllContent($search_params, $start, $limit);

        foreach ($allContent->payload as $c) {
            $content_creators = new ContentCreator();
            $content_keywords = new ContentKeyword();

            $content_creators = $content_creators->findAll(['content_id' => $c->content_id]);
            $content_keywords = $content_keywords->findAll(['content_id' => $c->content_id]);

            $c->creators = $content_creators;
            $c->keywords = $content_keywords;
        }

        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_CONTENT,
            self::BREADCRUM_MANAGE_CONTENTS
        ];
        return $this->render("admin/content/admin-inner-manage-content", ['content' => $allContent->payload, 'currentPage' => $page, 'pageCount' => $allContent->pageCount, 'search_params' => $search_params, 'breadcrum' => $breadcrum]);
    }
    public function viewContent(Request $request)
    {
        $contentModel = new Content();

        $data = $request->getBody();
        $data_keys = array_keys($data);

        if (!in_array('content_id', $data_keys)) {
            throw new NotFoundException();
        }

        $contentData = $contentModel->findOne(['content_id' => $data['content_id']]);

        $infoContent = $contentModel->getInfoContent($contentData->content_id);

        $content_creators = new ContentCreator();
        $content_keywords = new ContentKeyword();


        $content_creators = $content_creators->findAll(['content_id' => $infoContent->content_id]);
        $content_keywords = $content_keywords->findAll(['content_id' => $infoContent->content_id]);

        $infoContent->creators = $content_creators;
        $infoContent->keywords = $content_keywords;

        if ($contentData) {
            $breadcrum = [
                self::BREADCRUM_DASHBOARD,
                self::BREADCRUM_MANAGE_CONTENT,
                self::BREADCRUM_MANAGE_CONTENTS,
                self::BREADCRUM_MANAGE_CONTENTS_VIEW

            ];

            return $this->render('admin/content/info-content', ['model' => $infoContent, 'breadcrum' => $breadcrum]);
        }
        throw new NotFoundException();
    }

    public function deleteContent(Request $request)
    {
        $contentModel = new Content();

        if ($request->isPost()) {

            $data = $request->getBody();
            $contentData = $contentModel->findOne(['content_id' => $data['content_id']]);

            if ($contentData) {
                $deleteCon = new DeleteContent();
                $deleteCon->deleted_by = Application::$app->user->reg_no;

                // $deleteContent = $contentModel->deleteContent($contentData->content_id);

                // echo '<pre>';
                // var_dump($contentData);
                // echo '</pre>';
                // exit;
                if ($contentData->deleteContent($contentData->content_id) & $deleteCon->save()) {
                    Application::$app->session->setFlashMessage('success', 'Selected content was successfully deleted from the system');
                    Application::$app->response->redirect('/admin/manage-content');
                } else {
                    Application::$app->session->setFlashMessage('error', 'Selected content was not deleted from the system');
                    Application::$app->response->redirect('/admin/manage-content');
                }
            } else {
                Application::$app->session->setFlashMessage('error', 'Selected content does not exist on the system');
                Application::$app->response->redirect('/admin/manage-content');
            }
        }
    }



    public function viewContentAbstract(Request $request)
    {
        $data = $request->getBody();
        if (!isset($data['content_id'])) throw new NotFoundException();

        $contentModel = new Content();
        $content = $contentModel->findOne(['content_id' => $data['content_id']]);
        if (!$content) throw new NotFoundException();

        $contentKeywordModel = new ContentKeyword();
        $contentKeywords = $contentKeywordModel->findAll(['content_id' => $content->content_id]);

        $contentLanguageModel = new ContentLanguage();
        $contentLanguage = $contentLanguageModel->findOne(['language_id' => $content->language]);

        $contentCreatorModel = new ContentCreator();
        $authors = $contentCreatorModel->findContentAuthors($content->content_id);

        // Access Permission
        $collectionPermissionModel = new CollectionPermission();
        $collectionPermissionObj = $collectionPermissionModel->checkAccessPermission($content->collection_id);

        $contentCollectionPermissionModel = new ContentCollectionPermission();
        $contentCollectionPermissionObj = $contentCollectionPermissionModel->checkAccessPermission($content->content_id);

        $permission = new stdClass;
        if ($collectionPermissionObj->permission || $contentCollectionPermissionObj->permission) {
            $permission->permission = true;

            if ($collectionPermissionObj->grant_type === "READ_DOWNLOAD" || $contentCollectionPermissionObj->grant_type === "READ_DOWNLOAD") {
                $permission->grant_type = "READ_DOWNLOAD";
            } else {
                $permission->grant_type = "READ";
            }
        } else {
            $permission->permission = false;
            $permission->grant_type = "NULL";
        }


        $collectionModel = new Collection();
        $collection = $collectionModel->findOne(['collection_id' => $content->collection_id]);

        $communityModel = new Community();
        $res = $communityModel->communityBreadcrumGenerate($collection->community_id);
        array_push($res, ['name' => $collection->name]);

        $path_name = [];
        foreach ($res as $r) {
            array_push($path_name, $r['name']);
        }
        $path = implode(' > ', $path_name);


        $contentObj = new stdClass;
        $contentObj->contentInfo = $content;
        $contentObj->authors = $authors ? $authors :  '';
        $contentObj->language = $contentLanguage ?  $contentLanguage->language : '';
        $contentObj->keywords = $contentKeywords ?  $contentKeywords : '';
        $contentObj->permission = $permission;
        $contentObj->path = $path;

        // echo '<pre>';
        // var_dump($contentObj);
        // echo '</pre>';


        $this->render('content-abstract-info', ['content' => $contentObj]);
    }
}

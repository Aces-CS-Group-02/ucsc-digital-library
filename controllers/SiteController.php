<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\middlewares\LIAAccessPermissionMiddleware;
use app\core\Request;
use app\models\Community;
use app\models\Content;
use app\models\Notification;
use app\models\User;
use app\models\Collection;
use app\models\ContentCreator;
use app\models\LendPermission;
use app\models\LendRequest;
use app\models\SubCommunity;
use DateTime;
use stdClass;

class SiteController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware(new LIAAccessPermissionMiddleware(
            [
                'manageLibraryInformationAssistant',
                'createLibraryInformationAssistant',
            ]
        ));
    }

    public function home()
    {

        $topLevelCommunities = new Community();
        $topLevelCommunities = $topLevelCommunities->getAllTopLevelCommunities(0, 10000000);

        $latestContents = new Content();
        $latestContents = $latestContents->getLatestContents();

        $popularContents = new Content();
        $popularContents = $popularContents->getPopularContents();

        

        return $this->render('home', ['communities' => $topLevelCommunities->payload, 'latestContents' => $latestContents, 'popularContent' => $popularContents]);
    }

    public function search()
    {
        return $this->render('search');
    }

    public function browse(Request $request)
    {
        $data = $request->getBody();
        $page = isset($data['page']) ? $data['page'] : 1;
        if ($page <= 0) $page = 1;

        $contentModel = new Content();

        $collections = [];

        $browseType = false;
        $typeDataId = false;
        $browseCollectionOrCommunityName = "";
        if (isset($data['community']) xor isset($data['collection'])) {
            if (isset($data['community'])) {
                $communityModel = new Community();
                $selected_community = $communityModel->findOne(['community_id' => $data['community']]);
                $browseCollectionOrCommunityName = $selected_community->name;
                $communties = [];
                array_push($communties, $data['community']);
                for ($i = 0; $i < count($communties); $i++) {
                    $community = new Community();
                    $colection = new Collection();
                    $c = $communties[$i];
                    $collection = $colection->findAll(['community_id' => $c]);
                    $community = $community->findAll(['parent_community_id' => $c]);
                    foreach ($collection as $col) {
                        array_push($collections, $col['collection_id']);
                    }
                    foreach ($community as $com) {
                        array_push($communties, $com['community_id']);
                    }
                }
                $browseType = "community";
                $typeDataId = $data['community'];
            } else if (isset($data['collection'])) {
                $collections = [$data['collection']];
                $browseType = "collection";
                $typeDataId = $data['collection'];

                $colectionModel = new Collection();
                $selected_collection = $colectionModel->findOne(['collection_id' => $data['collection']]);
                $browseCollectionOrCommunityName = $selected_collection->name;
            }

            if (empty($collections)) {
                $collections = [-1];
            }
        }


        switch ($data['type']) {
            case 'dateissued':

                $year = $data['year'] ?? '';
                $order = $data['order'] ?? '';
                $month = $data['month'] ?? '';
                $rpp = $data['rpp'] ?? 20;
                if ($rpp < 5  || $rpp > 100) $rpp = 20;
                $limit = $rpp;
                $start = ($page - 1) * $limit;

                $res = $contentModel->browseByDateIssued($start, $limit, $year, $month, $order, $rpp, $collections);

                if (!$res) throw new NotFoundException();

                return $this->render('browse', ['type' => 'dateissued', 'data' => $res->payload, 'pageCount' => $res->pageCount, 'currentPage' => $page, 'browse-type' => $browseType, 'typeDataId' => $typeDataId, 'browseCollectionOrCommunityName' => $browseCollectionOrCommunityName]);

            case 'title':

                $starts_with = $data['starts_with'] ?? '';
                $order = $data['order'] ?? '';
                $rpp = $data['rpp'] ?? 20;
                if ($rpp < 5  || $rpp > 100) $rpp = 20;
                $limit = $rpp;
                $start = ($page - 1) * $limit;

                $res = $contentModel->browseByTitle($start, $limit, $starts_with, $order, $rpp, $collections);

                if (!$res) throw new NotFoundException();

                return $this->render('browse', ['type' => 'title', 'data' => $res->payload, 'pageCount' => $res->pageCount, 'currentPage' => $page, 'browse-type' => $browseType, 'typeDataId' => $typeDataId, 'browseCollectionOrCommunityName' => $browseCollectionOrCommunityName]);
            default:
                throw new NotFoundException();
        }
    }

    public function advancedSearch()
    {
        return $this->render('advanced-search');
    }

    public function openNotification()
    {
        $notificationModel = new Notification();
        $res = $notificationModel->openNotification();
        if ($res) {
            return "viewed";
        } else {
            return "not-viewed";
        }
    }

    public function browseByCommunitiesAndCollections(Request $request)
    {
        $communityModel = new Community();
        $topLevelCommunities = $communityModel->getAllTopLevelCommunities(0, 1000);

        $breadcrum = [self::BREADCRUM_HOME, self::BREADCRUM_COMMUNITY_LIST];

        return $this->render('browse-by-communities-and-collections-into-view', ['topLevelCommunities' => $topLevelCommunities->payload, 'breadcrum' => $breadcrum, 'redirect-parent' => null]);
    }

    public function browseByCommunity(Request $request)
    {
        $data = $request->getBody();
        // $data = $request->getBody();
        // $page = isset($data['page']) ? $data['page'] : 1;
        // if ($page <= 0) $page = 1;

        // $rpp = $data['rpp'] ?? 20;
        // if ($rpp < 5  || $rpp > 100) $rpp = 20;
        // $limit = $rpp;
        // $start = ($page - 1) * $limit;


        $communityModel = new Community();
        $selected_community = $communityModel->findOne(['community_id' => $data['community_id']]);


        $breadcrumData = $communityModel->communityBreadcrumGenerate($selected_community->community_id);

        // var_dump($breadcrum);

        $breadcrum = [self::BREADCRUM_HOME, self::BREADCRUM_COMMUNITY_LIST];
        foreach ($breadcrumData as $link) {
            $breadcrumLinkName =  $link['name'];
            $breadcrumLink = '/browse/community?community_id=' . $link["community_id"];
            $val = ['name' => $breadcrumLinkName, 'link' => $breadcrumLink];
            array_push($breadcrum, $val);
        }






        // $communties = [];
        // array_push($communties, $data['community_id']);

        // $collections = [];

        // for ($i = 0; $i < count($communties); $i++) {
        //     $community = new Community();
        //     $colection = new Collection();

        //     $c = $communties[$i];

        //     $collection = $colection->findAll(['community_id' => $c]);
        //     $community = $community->findAll(['parent_community_id' => $c]);

        //     foreach ($collection as $col) {
        //         array_push($collections, $col['collection_id']);
        //     }

        //     foreach ($community as $com) {
        //         array_push($communties, $com['community_id']);
        //     }
        // }


        // $contentModel = new Content();
        // $contents = $contentModel->getAllContents($collections, $start, $limit);

        // $content_data = [];
        // $pageCount = 0;
        // if ($contents) {
        //     $content_data = $contents->payload;
        //     $pageCount = $contents->pageCount;
        // };


        $subCommunityModel = new SubCommunity();
        $sub_communities_of_dir = $subCommunityModel->selectAllSubCommunities($data['community_id']);

        $collectionModel = new Collection();
        $collections_of_dir = $collectionModel->findAll(['community_id' => $data['community_id']]);


        return $this->render('browse-by-communities-and-collections', ['type' => 'community', 'selected-item' => $selected_community, 'communities_of_dir' => $sub_communities_of_dir, 'collections_of_dir' => $collections_of_dir, 'breadcrum' => $breadcrum, 'redirect-parent' => $selected_community->community_id]);
    }

    public function browseByCollection(Request $request)
    {
        $data = $request->getBody();
        // $data = $request->getBody();
        // $page = isset($data['page']) ? $data['page'] : 1;
        // if ($page <= 0) $page = 1;

        // $rpp = $data['rpp'] ?? 20;
        // if ($rpp < 5  || $rpp > 100) $rpp = 20;
        // $limit = $rpp;
        // $start = ($page - 1) * $limit;

        $collectionModel = new Collection();
        $collection = $collectionModel->findOne(['collection_id' => $data['collection_id']]);
        if (!$collection) throw new NotFoundException();


        $collections = [$collection->collection_id];

        // $contentModel = new Content();
        // $contents = $contentModel->getAllContents($collections, $start, $limit);

        // $content_data = [];
        // $pageCount = 0;
        // if ($contents) {
        //     $content_data = $contents->payload;
        //     $pageCount = $contents->pageCount;
        // };


        $communityModel = new Community();
        $selected_community = $communityModel->findOne(['community_id' => $collection->community_id]);


        $breadcrumData = $communityModel->communityBreadcrumGenerate($selected_community->community_id);

        // var_dump($breadcrum);

        $breadcrum = [self::BREADCRUM_HOME, self::BREADCRUM_COMMUNITY_LIST];
        foreach ($breadcrumData as $link) {
            $breadcrumLinkName =  $link['name'];
            $breadcrumLink = '/browse/community?community_id=' . $link["community_id"];
            $val = ['name' => $breadcrumLinkName, 'link' => $breadcrumLink];
            array_push($breadcrum, $val);
        }



        return $this->render('browse-by-communities-and-collections', ['type' => 'collection', 'selected-item' => $collection, 'breadcrum' => $breadcrum]);
    }
    public function help()
    {
        return $this->render('help');
    }

    public function getAccess(Request $request)
    {
        $data = $request->getBody();

        $_POST = json_decode(file_get_contents('php://input'), true);

        if (!isset($_POST['content-id'])) throw new NotFoundException();

        $contentModel = new Content();
        $content = $contentModel->findOne(['content_id' => $_POST['content-id']]);

        $contentObj = new stdClass;

        if (!Application::$app->user) {
            return "false";
        }

        if ($content) {
            $contentObj->status = true;
            $contentObj->content_id = $content->content_id;
            $contentObj->title = $content->title;
        } else {
            $contentObj->status = false;
        }

        return json_encode($contentObj);
        // return $this->render('/user/get-access', ['content' => $content]);
    }

    public function getAccessRequest(Request $request)
    {
        $_POST = json_decode(file_get_contents('php://input'), true);

        $data = $request->getBody();


        $contentModel = new Content();
        $content = $contentModel->findOne(['content_id' => $_POST['content-id']]);
        if (!$content) throw new NotFoundException();

        // If user not logged in, then redirect
        if (!Application::$app->user) {
            // Application::$app->response->redirect('/login');
            // exit;
            return "false";
        }




        $duration = $_POST['lend-duration'];
        $currentUser = Application::$app->user->reg_no;

        $lendRequestModel = new LendRequest();

        // Check wheather a lend request is already exists for the current content by current user
        $record = $lendRequestModel->findOne(['content_id' => $content->content_id, 'user_id' => $currentUser, 'status' => 0]);


        $retObj = new stdClass;
        if ($record && $record->status == 0) {
            // return $this->render('/user/get-access', ['content' => $content, 'record-exists' => true, 'err-msg' => "You have already requested to lend this book"]);
            $retObj->status = false;
            $retObj->msg = "You have already requested to lend this book";
            return json_encode($retObj);
        }

        // Check wheather the permission is alreaty exists
        $lendPermissionModel = new LendPermission();
        $lendPermissionRecords = $lendPermissionModel->findAll(['content_id' => $content->content_id, 'user_id' => Application::$app->user->reg_no]);
        if ($lendPermissionRecords) {
            $flag = false;
            date_default_timezone_set('Asia/Colombo');
            $currentTime = date('Y-m-d H:i:s');
            $currentTime = new DateTime($currentTime);
            foreach ($lendPermissionRecords as $lend_perm) {
                $exp = new DateTime($lend_perm['lend_exp_date']);
                if ($currentTime < $exp) {
                    $flag = true;
                }
            }
            if ($flag) {
                // return $this->render('/user/get-access', ['content' => $content, 'record-exists' => true, 'err-msg' => "Already you have permission to access this content."]);
                $retObj->status = false;
                $retObj->msg = "Already you have permission to access this content.";
                return json_encode($retObj);
            }
        }


        $lendRequestModel->loadData(['content_id' => $content->content_id, 'user_id' => $currentUser, 'duration' => $duration]);
        if ($lendRequestModel->save()) {
            // Application::$app->session->setFlashMessage("success", "Request made success");
            // return $this->render('/user/get-access', ['content' => $content]);
            $retObj->status = true;
            $retObj->msg = "Success";
            return json_encode($retObj);
        } else {
            // Application::$app->session->setFlashMessage("error", "Something went wrong");
            // return $this->render('/user/get-access', ['content' => $content]);
            $retObj->status = false;
            $retObj->msg = "Something went wrong";
            return json_encode($retObj);
        }
    }

    public function reviewLendRequests()
    {
        $lendRequestModel = new LendRequest();
        $requests = $lendRequestModel->findAll(['status' => 0]);

        $contentModel = new Content();
        $userModel = new User();

        $requestInfo = [];

        foreach ($requests as $request) {
            $content = $contentModel->findOne(['content_id' => $request['content_id']]);
            $user = $userModel->findOne(['reg_no' => $request['user_id']]);

            $temp = new stdClass;
            $temp->request_id = $request['id'];
            $temp->content_id = $content->content_id;
            $temp->content_title = $content->title;
            $temp->user_reg_no = $user->reg_no;
            $temp->user_first_name = $user->first_name;
            $temp->user_last_name = $user->last_name;
            $temp->lend_duration = $request['duration'];

            array_push($requestInfo, $temp);
        }

        $breadcrum = [
            self::BREADCRUM_DASHBOARD,
            self::BREADCRUM_MANAGE_APPROVALS,
            self::BREADCRUM_REVIEW_LEND_REQUESTS
        ];

        return $this->render('admin/approve/review-lend-requests', ['requests' => $requestInfo, 'breadcrum' => $breadcrum]);
    }

    public function processLendRequest(Request $request)
    {
        $data = $request->getBody();

        switch ($data['action']) {
            case 1:
                $lendPermissionModel = new LendPermission;
                if (!($lendPermissionModel->findOne(['content_id' => $data['content_id'], 'user_id' => $data['user_reg_no']]))) {
                    if ($lendPermissionModel->acceptRequest($data)) {
                        Application::$app->response->redirect('/admin/review-lend-requests');
                    } else {
                        Application::$app->response->redirect('/admin/review-lend-requests');
                    }
                    // } else {
                    //     Application::$app->response->redirect('/admin/review-lend-requests');
                    // }
                } else {
                    // Checl dates (Expired or not)
                    $lendPermission = $lendPermissionModel->findAll(['content_id' => $data['content_id'], 'user_id' => Application::$app->user->reg_no]);

                    $flag = false;
                    date_default_timezone_set('Asia/Colombo');
                    $currentTime = date('Y-m-d H:i:s');
                    $currentTime = new DateTime($currentTime);
                    foreach ($lendPermission as $lend_perm) {
                        $exp = new DateTime($lend_perm['lend_exp_date']);
                        if ($currentTime < $exp) {
                            $flag = true;
                        }
                        // var_dump($lend_perm['lend_exp_date']);
                    }
                    if (!$flag) {
                        if ($lendPermissionModel->acceptRequest($data)) {
                            Application::$app->response->redirect('/admin/review-lend-requests');
                        } else {
                            Application::$app->response->redirect('/admin/review-lend-requests');
                        }
                    } else {
                        Application::$app->response->redirect('/admin/review-lend-requests');
                    }
                }
                break;
            case 2:
                $lendRequestModel = new LendRequest;
                if ($lendRequestModel->reject($data['content_id'], $data['user_reg_no'])) {
                    Application::$app->response->redirect('/admin/review-lend-requests');
                } else {
                    Application::$app->response->redirect('/admin/review-lend-requests');
                }
                break;
        }
    }

    public function approveLendRequest(Request $request)
    {
        $data = $request->getBody();

        $lendRequest = new LendRequest;
        $req = $lendRequest->findOne(['id' => $data['request_id']]);
        var_dump($req);

        $lendPermissionModel = new LendPermission;
        if (!($lendPermissionModel->findOne(['content_id' => $req->content_id, 'user_id' => $req->user_id]))) {
            if ($lendPermissionModel->acceptRequest($req)) {
                Application::$app->response->redirect('/admin/review-lend-requests');
            } else {
                Application::$app->response->redirect('/admin/review-lend-requests');
            }
        } else {
            // Checl dates (Expired or not)
            $lendPermission = $lendPermissionModel->findAll(['content_id' => $req->content_id, 'user_id' => Application::$app->user->reg_no]);

            $flag = false;
            date_default_timezone_set('Asia/Colombo');
            $currentTime = date('Y-m-d H:i:s');
            $currentTime = new DateTime($currentTime);
            foreach ($lendPermission as $lend_perm) {
                $exp = new DateTime($lend_perm['lend_exp_date']);
                if ($currentTime < $exp) {
                    $flag = true;
                }
                // var_dump($lend_perm['lend_exp_date']);
            }
            if (!$flag) {
                if ($lendPermissionModel->acceptRequest($data)) {
                    Application::$app->session->setFlashMessage('success', 'Lend request approved');
                } else {
                    Application::$app->session->setFlashMessage('error', 'Lend request rejected');
                }
                Application::$app->response->redirect('/admin/review-lend-requests');
            } else {
                Application::$app->response->redirect('/admin/review-lend-requests');
            }
        }
    }

    public function rejectLendRequest(Request $request)
    {
        $data = $request->getBody();
        var_dump($data);
        $lendRequestModel = new LendRequest;
        if ($lendRequestModel->reject($data['req_id'])) {
            Application::$app->session->setFlashMessage('success', 'Lend request rejected');
        } else {
            Application::$app->session->setFlashMessage('error', 'Something went wrong');
        }
        Application::$app->response->redirect('/admin/review-lend-requests');
    }
}

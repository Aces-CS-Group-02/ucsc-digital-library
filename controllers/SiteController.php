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
use app\models\SubCommunity;

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
        return $this->render('home', ['communities' => $topLevelCommunities->payload]);
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
        return $this->render('browse-by-communities-and-collections-into-view', ['topLevelCommunities' => $topLevelCommunities->payload]);
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

        $breadcrum = [self::BREADCRUM_HOME];
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


        return $this->render('browse-by-communities-and-collections', ['type' => 'community', 'selected-item' => $selected_community, 'communities_of_dir' => $sub_communities_of_dir, 'collections_of_dir' => $collections_of_dir, 'breadcrum' => $breadcrum]);
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

        $breadcrum = [self::BREADCRUM_HOME];
        foreach ($breadcrumData as $link) {
            $breadcrumLinkName =  $link['name'];
            $breadcrumLink = '/browse/community?community_id=' . $link["community_id"];
            $val = ['name' => $breadcrumLinkName, 'link' => $breadcrumLink];
            array_push($breadcrum, $val);
        }



        return $this->render('browse-by-communities-and-collections', ['type' => 'collection', 'selected-item' => $collection, 'breadcrum' => $breadcrum]);
    }
}

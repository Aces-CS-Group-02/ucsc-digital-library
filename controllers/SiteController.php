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


        switch ($data['type']) {
            case 'dateissued':

                $year = $data['year'] ?? '';
                $order = $data['order'] ?? '';
                $month = $data['month'] ?? '';
                $rpp = $data['rpp'] ?? 20;
                if ($rpp < 5  || $rpp > 100) $rpp = 20;
                $limit = $rpp;
                $start = ($page - 1) * $limit;

                $res = $contentModel->browseByDateIssued($start, $limit, $year, $month, $order, $rpp);

                if (!$res) throw new NotFoundException();

                return $this->render('browse', ['type' => 'dateissued', 'data' => $res->payload, 'pageCount' => $res->pageCount, 'currentPage' => $page]);

            case 'title':

                $starts_with = $data['starts_with'] ?? '';
                $order = $data['order'] ?? '';
                $rpp = $data['rpp'] ?? 20;
                if ($rpp < 5  || $rpp > 100) $rpp = 20;
                $limit = $rpp;
                $start = ($page - 1) * $limit;

                $res = $contentModel->browseByTitle($start, $limit, $starts_with, $order, $rpp);

                if (!$res) throw new NotFoundException();

                return $this->render('browse', ['type' => 'title', 'data' => $res->payload, 'pageCount' => $res->pageCount, 'currentPage' => $page]);
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
}

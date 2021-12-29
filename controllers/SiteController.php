<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\middlewares\LIAAccessPermissionMiddleware;
use app\core\Request;
use app\models\Community;
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

    public function browse()
    {
        return $this->render('browse');
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

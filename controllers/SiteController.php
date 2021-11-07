<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\middlewares\LIAAccessPermissionMiddleware;
use app\core\Request;
use app\models\Community;
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
        $topLevelCommunities = $topLevelCommunities->getAllTopLevelCommunities(1,1000000000);

        return $this->render('home', ['communities' => $topLevelCommunities]);
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
}

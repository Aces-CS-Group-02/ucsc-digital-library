<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Community;

class SiteController extends Controller
{

    public function home()
    {
        return $this->render('Home');
    }

    public function communities()
    {
        $community = new Community();
        $allTopCommunities = $community->getAllTopLevelCommunities();
        return $this->render('admin/communities', ['allTopLevelCommunities' => $allTopCommunities]);
    }

    public function createTopLevelCommunities()
    {
        return $this->render('admin/createtoplevelcommunities');
    }
}

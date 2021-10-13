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
        return $this->render('admin/communities', ['communityType' => 'Top level communities', 'communities' => $allTopCommunities]);
    }

    public function createTopLevelCommunities()
    {
        return $this->render('admin/createtoplevelcommunities');
    }

    public function createSubCommunity(Request $request)
    {
        $data = $request->getBody();
        return $this->render('admin/createtoplevelcommunities', ['ParentID' => $data['parent-ID']]);
    }
}

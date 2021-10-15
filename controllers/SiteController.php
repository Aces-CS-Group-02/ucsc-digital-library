<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
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
        $communityModel = new Community();

        if (!array_key_exists("parent-id", $data)) {
            throw new NotFoundException();
        }

        if (!$communityModel->findCommunity($data['parent-id'])) {
            throw new NotFoundException();
        }
        return $this->render('admin/createtoplevelcommunities', ['parent_community_id' => $data['parent-id']]);
    }
}

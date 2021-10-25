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
        return $this->render('home');
    }

    public function search()
    {
        return $this->render('search');
    }

    public function browse()
    {
        return $this->render('browse');
    }

    public function communities()
    {
        $community = new Community();
        $allTopCommunities = $community->getAllTopLevelCommunities();
        return $this->render('admin/communities', ['communityType' => true, 'communities' => $allTopCommunities]);
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

    public function manageLibraryInformationAssistant(Request $request)
    {
        $userModel = new User();
        $allLIAMembers =  $userModel->findAll(['role_id' => 2]); // Set LIA role_id here
        $this->render("admin/manage-library-information-assistant", ['allStaffMembers' => $allLIAMembers]);
    }

    public function createLibraryInformationAssistant(Request $request)
    {
        $userModel = new User();
        $allStaffMembers =  $userModel->findAll(['role_id' => 3]); // Set Academic-Non academic staff role_id here
        $this->render("admin/create-library-information-assistant", ['allStaffMembers' => $allStaffMembers]);
    }
}

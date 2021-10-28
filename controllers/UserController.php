<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Community;
use app\models\Role;

class UserController extends Controller
{
    public function profile()
    {
        return $this->render('user/profile');
    }

    public function editProfile()
    {
        return $this->render('user/edit-profile');
    }
}

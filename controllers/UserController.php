<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Community;

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

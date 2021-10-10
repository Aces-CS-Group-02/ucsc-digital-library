<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Communities;
use app\core\exception\NotFoundException;

class CommunitiesController extends Controller
{
    public function createNewCommunity(Request $request)
    {
        $communityModel = new Communities();
        $communityModel->loadData($request->getBody());

        if ($communityModel->validate() && $communityModel->save()) {
            Application::$app->session->setFlashMessage('success-community-creation', 'Top level community Successfully created');
            Application::$app->response->redirect('/communities');
            // return $this->render('communities', ['model' => $communityModel]);
        }
        return $this->render('createtoplevelcommunities', ['model' => $communityModel]);
    }


    public function update(Request $request)
    {
        $data = $request->getBody();

        $communityModel = new Communities();

        if ($request->getMethod() === 'POST') {

            $communityModel->loadData($data);

            if ($communityModel->validate()) {

                $updateRequiredFileds = $communityModel->wantsToUpdate($data['ID']);

                if (!empty($updateRequiredFileds)) {

                    echo "You have to update";
                    echo '<pre>';
                    var_dump($data);
                    echo '</pre>';

                    $communityModel->update($data, $updateRequiredFileds);
                }


                return $this->render('Updatecommunities', ['model' => $communityModel]);
            }

            return $this->render('Updatecommunities', ['model' => $communityModel]);
        } else {
            if ($communityModel->loadCommunity($data['ID'])) {
                return $this->render('Updatecommunities', ['model' => $communityModel]);
            } else {
                throw new NotFoundException();
            };
        }
    }


    public function deleteCommunity(Request $request)
    {
        $data = $request->getBody();

        // var_dump($data);


        $communityModel = new Communities();

        if ($data['deleteCommunity']) {

            if ($communityModel->deleteCommunity($data['communityID'])) {
                echo "success";
            } else {
                echo "error";
            }
        }


        // var_dump($data);

        // echo $data['communityID'];
        // echo $data['community-ID'];
    }
}

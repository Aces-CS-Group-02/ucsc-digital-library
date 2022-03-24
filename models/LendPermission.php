<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use Exception;

class LendPermission extends DbModel
{

    public $content_id;
    public $user_id;
    public $lend_exp_date;
    public $permission;

    public static function primaryKey(): string
    {
        return "id";
    }

    public static function tableName(): string
    {
        return "lend_permission";
    }

    public function attributes(): array
    {
        return ['content_id', 'user_id', 'lend_exp_date', 'permission'];
    }

    public function rules(): array
    {
        return [];
    }

    public function acceptRequest($reqInfo)
    {
        $lendRequestModel = new LendRequest;
        $req = $lendRequestModel->findOne(['content_id' => $reqInfo->content_id, 'user_id' => $reqInfo->user_id, 'status' => 0]);

        if (!$req) return false;

        date_default_timezone_set('Asia/Colombo');
        $date = date("Y-m-d H:i:s");

        switch ($req->duration) {
            case 1:
                $expDate = date("Y-m-d H:i:s", strtotime($date . ' + 7 days'));
                break;
            case 2:
                $expDate = date("Y-m-d H:i:s", strtotime($date . ' + 14 days'));
                break;
            case 3:
                $expDate = date("Y-m-d H:i:s", strtotime($date . ' + 21 days'));
                break;
            case 4:
                $expDate = date("Y-m-d H:i:s", strtotime($date . ' + 28 days'));
                break;
        }

        var_dump($expDate);

        $this->loadData(['content_id' => $req->content_id, 'user_id' => $req->user_id, 'lend_exp_date' => $expDate, 'permission' => 1]);


        try {
            Application::$app->db->pdo->beginTransaction();
            $this->save();
            $stmt = "UPDATE lend_requests SET status = 1 WHERE id = :id";
            $stmt = self::prepare($stmt);
            $stmt->bindValue(":id", $req->id);
            $stmt->execute();
            Application::$app->db->pdo->commit();
            return true;
        } catch (Exception $e) {
            Application::$app->db->pdo->rollBack();
            return false;
        }
    }
}

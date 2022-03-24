<?php

namespace app\models;

use app\core\DbModel;

class LendRequest extends DbModel
{
    public $content_id;
    public $user_id;
    public $duration;

    public static function tableName(): string
    {
        return "lend_requests";
    }

    public function attributes(): array
    {
        return ['content_id', 'user_id', 'duration'];
    }

    public static function primaryKey(): string
    {
        return "id";
    }

    public function rules(): array
    {
        return [];
    }

    public function reject($req_id)
    {
        $lendRequestTable = self::tableName();

        $lendRequestModel = new LendRequest;
        // $req = $lendRequestModel->findOne(['content_id' => $contentID, 'user_id' => $userRegNo, 'status' => 0]);
        $req = $lendRequestModel->findOne(['id' => $req_id]);

        if (!$req) return false;

        $stmt = "UPDATE $lendRequestTable SET status = 2 WHERE id=:id";
        $stmt = self::prepare($stmt);
        $stmt->bindValue(":id", $req->id);
        return $stmt->execute();
    }
}

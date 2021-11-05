<?php

namespace app\models;

use app\core\DbModel;

class UserCollectionContent extends DbModel{
    public int $id;
    public int $content_id;
    public int $user_collection_id;

    public static function tableName(): string
    {
        return "user_collection_content";
    }

    public function attributes(): array
    {
        return ['content_id', 'user_collection_id'];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        return [
            'content_id' => [self::RULE_REQUIRED],
            'user_collection_id' => [self::RULE_REQUIRED]
        ];
    }

    public function getCollectionContent($data)
    {
        $tableName = static::tableName();
        // $userCollectionModel = new UserCollection();
        $this->user_collection_id = $data;
        // $this->user_collection_idf = $userCollectionModel->user_collection_id;
        $statement = self::prepare("SELECT * FROM $tableName WHERE user_collection_id = $this->user_collection_id");
        $statement->execute();
        return $statement->fetchAll();
    }
}
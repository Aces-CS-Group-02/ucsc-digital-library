<?php

namespace app\models;

use app\core\DbModel;

class UserCollectionContent extends DbModel
{
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
        return '';
    }

    public function rules(): array
    {
        return [];
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

    public function addContentToCollection($collectionId, $contentId)
    {
        $tableName = self::tableName();
        $statement = self::prepare("INSERT INTO $tableName (user_collection_id, content_id) VALUES ($collectionId, $contentId)");

        // var_dump($statement);
        return $statement->execute();
    }

    public function removeContentFromCollection($collectionId, $contentId)
    {
        $userCollectionModel = new UserCollection();
        if (!$userCollectionModel->findOne(['user_collection_id' => $collectionId])) return false;

        $tableName = self::tableName();
        $statement = self::prepare("DELETE FROM $tableName WHERE user_collection_id=$collectionId AND content_id=$contentId");
        return $statement->execute();
    }
}

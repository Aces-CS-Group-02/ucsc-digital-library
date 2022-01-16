<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use PDO;

class UserCollection extends DbModel
{
    public int $reg_no = 0;
    public int $user_collection_id = 0;
    public string $name = '';

    public static function tableName(): string
    {
        return "user_collection";
    }

    public function attributes(): array
    {
        return ['name', 'reg_no'];
    }

    public static function primaryKey(): string
    {
        return 'user_collection_id';
    }

    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]]
        ];
    }

    public function createUserCollection($data)
    {
        // var_dump($data);
        // var_dump(Application::$app->user->reg_no);

        $this->loadData($data);
        $this->reg_no = Application::$app->user->reg_no;

        // if($this->validate()){
        //     echo "hwrw";
        //     var_dump($this);
        // }

        if ($this->validate("AND reg_no = $this->reg_no") && $this->save()) {
            // echo "Done!!!";
            return true;
        }
        return false;
    }

    public function createUserCollectionAndAddContent($data)
    {
        // var_dump($data);

        $this->loadData($data);
        if ($this->validate("AND reg_no = $this->reg_no") && $this->save()) {
            $collectioName = $data["name"];
            $regNo = $data["reg_no"];
            $newCollectionData = $this->findOne(['name' => $collectioName, 'reg_no' => $regNo]);
            $collectionId = $newCollectionData->user_collection_id;
            $contentId = $data["content_id"];
            if ($this->addContentToCollection($collectionId, $contentId)) return true;
        }
    }

    public function getUserCollections()
    {
        $tableName = static::tableName();
        $this->reg_no = Application::$app->user->reg_no;
        $statement = self::prepare("SELECT * FROM $tableName WHERE reg_no = $this->reg_no LIMIT 3");
        $statement->execute();
        return $statement->fetchAll();
        // var_dump($statement);
    }

    public function getAllUserCollections()
    {
        $this->reg_no = Application::$app->user->reg_no;
        return $this->findAll(['reg_no' => $this->reg_no]) ?? false;
    }

    // public function findUserCollection($data)
    // {
    //     $tableName = static::tableName();
    //     $statement = self::prepare("SELECT * FROM $tableName WHERE user_collection_id = $data");
    //     $statement->execute();
    //     return $statement->fetchAll();
    // }

    public function addContentToCollection($collectionId, $contentId)
    {
        $contentModel = new Content();
        // If collection does not exist return false
        if (!$this->findOne(['user_collection_id' => $collectionId])) return false;

        //  If content does not exist return false
        if (!$contentModel->findOne(['content_id' => $contentId])) return false;

        $userCollectionContentModel = new UserCollectionContent();
        if ($userCollectionContentModel->addContentToCollection($collectionId, $contentId)) return true;
        return false;
    }

    public function deleteUserCollection($user_collection_id)
    {
        $tableName = static::tableName();
        if ($this->findOne(['user_collection_id' => $user_collection_id])) {
            $statement = self::prepare("DELETE FROM $tableName WHERE " . self::primaryKey() . " = $user_collection_id");
            return $statement->execute();
        }
    }
}

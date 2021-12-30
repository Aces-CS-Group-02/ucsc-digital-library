<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use app\core\exception\ForbiddenException;

class ContentCollectionContent extends DbModel

{
    public int $collection_ids;
    public int $content_id;

    public static function tableName(): string
    {
        return 'content_collection_content';
    }

    public static function primaryKey(): string
    {
        return '';
    }

    public function attributes(): array
    {
        return ['collection_id', 'content_id'];
    }


    public function rules(): array
    {
        return [];
    }

    public function addContent($collection_id, $content)
    {
        $tableName = self::tableName();
        $value = "($collection_id, $content)";
        $statement = self::prepare("INSERT INTO $tableName (collection_id, content_id) VALUES $value");
        return $statement->execute();
    }

    public function addContents($collection_id, $content_list_validated)
    {
        $tableName = self::tableName();
        $values = array();
        foreach ($content_list_validated as $content) {
            $value = "($collection_id, $content)";
            array_push($values, $value);
        }
        $values = implode(',', $values);



        $statement = self::prepare("INSERT INTO $tableName (collection_id, content_id) VALUES $values");

        // var_dump($statement);


        return $statement->execute();
    }

    public function removeContent($content_collection_id, $content_id)
    {
        var_dump($content_collection_id, $content_id);

        $currentUserRegNo = Application::$app->user->reg_no;
        $contentCollectionModel = new ContentCollection();

        $content_collection = $contentCollectionModel->findOne(['id' => $content_collection_id]);
        // If usergroup not exsist
        if (!$content_collection) return false;

        // If current user is not a LIA/AL and not the owner of usergroup
        if (Application::getUserRole() > 2 && (int)$currentUserRegNo != (int)$content_collection->creator) throw new ForbiddenException();

        $targetContent = $this->findOne(['content_id' => $content_id]);
        // If the user that tring to remove from the group is not exist in usegroup
        if (!$targetContent) return  false;


        $tableName = self::tableName();
        $statement = self::prepare("DELETE FROM $tableName WHERE content_id=$content_id ");
        return $statement->execute();
    }
}

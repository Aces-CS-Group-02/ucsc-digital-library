<?php

namespace app\models;

use app\core\DbModel;
use PDO;
use stdClass;

class ContentCreator extends DbModel
{

    public int $content_id = 0;
    public string $creator = '';

    public static function tableName(): string
    {
        return 'content_creator';
    }

    public function attributes(): array
    {
        return ['content_id', 'creator'];
    }

    public static function primaryKey(): string
    {
        return 'content_id'; //this is not the correct primary key
    }

    public function rules(): array
    {
        return [];
    }

    public function findAuthors($data)
    {
        $content_creator_table = self::tableName();

        $dataArray = [];

        foreach ($data as $content) {
            $content_id = $content->content_id;
            $sql = "SELECT creator FROM $content_creator_table WHERE content_id = $content_id";
            $statement = self::prepare($sql);
            $statement->execute();
            $authors = $statement->fetchAll(PDO::FETCH_OBJ);

            $dataItemObj = new stdClass;
            $dataItemObj->authors = $authors;
            $dataItemObj->contentInfo = $content;
            array_push($dataArray, $dataItemObj);
        }
        return $dataArray;
    }
}

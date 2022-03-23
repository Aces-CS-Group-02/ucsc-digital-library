<?php

namespace app\models;

use app\core\DbModel;

class citationCount extends DbModel{
    public int $id = 0;
    public int $content_id = 0;
    public int $count = 0;

    public static function tableName(): string
    {
        return "citation_count";
    }

    public function attributes(): array
    {
        return ["id", "count", "content_id"];
    }

    public static function primaryKey(): string
    {
        return "id";
    }

    public function rules(): array
    {
        return [];
    }

    public function addRecord($data)
    {
        $this->loadData($data);
        $dataExists = $this->findOne(['content_id' => $this->content_id]);
        if ($dataExists) {
            $tableName = self::tableName();
            $sql = "UPDATE $tableName set count = count+1 WHERE content_id = $this->content_id";
            $statement = self::prepare($sql);
            // echo $sql;
            return $statement->execute();
        } else {
            $this->count = 1;
            if ($this->save()) {
                return true;
            }
        }

        return false;
    }
}
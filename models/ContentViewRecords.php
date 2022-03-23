<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use PDO;

class ContentViewRecords extends DbModel
{
    public int $record_id = 0;
    public int $reg_no = 0;
    public int $content_id = 0;
    // public string $date = '';

    public static function tableName(): string
    {
        return "content_view_records";
    }

    public function attributes(): array
    {
        return ["record_id", "reg_no", "content_id"];
    }

    public static function primaryKey(): string
    {
        return "record_id";
    }

    public function rules(): array
    {
        return [];
    }

    public function addRecord($data)
    {
        $this->loadData($data);
        $this->reg_no = Application::$app->user->reg_no;
        $dataExists = $this->findOne(['reg_no' => $this->reg_no, 'content_id' => $this->content_id]);
        if ($dataExists) {
            $tableName = self::tableName();
            $sql = "UPDATE $tableName set timestamp = CURRENT_TIMESTAMP WHERE reg_no = $this->reg_no AND content_id = $this->content_id";
            $statement = self::prepare($sql);
            // echo $sql;
            return $statement->execute();
        } else {
            if ($this->save()) {
                return true;
            }
        }

        return false;
    }

    public function getLatestRecord($data)
    {
        $this->loadData($data);
        $this->reg_no = Application::$app->user->reg_no;
        $tableName = self::tableName();
        $sql = "SELECT * FROM $tableName WHERE content_id = $this->content_id ORDER BY timestamp DESC LIMIT 1";
        $statement = self::prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
}

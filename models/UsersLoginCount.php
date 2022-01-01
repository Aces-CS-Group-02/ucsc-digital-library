<?php

namespace app\models;

use app\core\DbModel;
use PDO;

class UsersLoginCount extends DbModel
{
    public int $id = 0;
    public int $count = 0;
    public string $date = '';

    public static function tableName(): string
    {
        return "users_login_count";
    }

    public function attributes(): array
    {
        return ["date", "count"];
    }

    public static function primaryKey(): string
    {
        return "id";
    }

    public function rules(): array
    {

        return [
            'date' => [self::RULE_UNIQUE]
        ];
    }

    public function findLoginDate($value)
    {
        $tableName = self::tableName();
        $sql = "SELECT count(*) FROM $tableName WHERE date = '$value'";
        // $sql = "SELECT Format(DCount("*", $tableName, date='$value') > 0, 'True/False') AS value_exists;";
        $statement = self::prepare($sql);
        // echo $sql;
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getCount($value)
    {
        $tableName = self::tableName();
        $sql = "SELECT count FROM $tableName WHERE date = '$value'";
        $statement = self::prepare($sql);
        // echo $sql;
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateCount($value)
    {
        $tableName = self::tableName();
        $sql = "UPDATE $tableName set count = count+1 WHERE date = '$value'";
        $statement = self::prepare($sql);
        // echo $sql;
        return $statement->execute();
    }

    public function addRecord($addDate, $amount)
    {
        $tableName = self::tableName();
        $sql = "INSERT INTO $tableName (date,count) VALUES ('$addDate','$amount')";
        $statement = self::prepare($sql);
        // echo $sql;
        return $statement->execute();
    }

    public function getLastRecords()
    {
        $tableName = self::tableName();
        $sql = "SELECT * FROM (
            SELECT * FROM $tableName ORDER BY id DESC LIMIT 30
        ) sub
        ORDER BY id ASC";
        $statement = self::prepare($sql);
        // echo $sql;
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
}

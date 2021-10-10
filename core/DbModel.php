<?php

namespace app\core;


abstract class DbModel extends Model
{
    abstract public static function tableName(): string;

    abstract public function attributes(): array;

    abstract public static function primaryKey(): string;

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn ($attr) => ":$attr", $attributes);



        // $sql = "INSERT INTO " . $tableName . "(" . implode(',', $attributes) . ") VALUES(" . implode(',', $params) . ")";

        $statement = self::prepare("INSERT INTO " . $tableName . "(" . implode(',', $attributes) . ") VALUES(" . implode(',', $params) . ")");


        foreach ($attributes as $attribute) {
            // echo ":$attribute" . '<br>';
            // echo $this->{$attribute} . '<br>';
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        // echo '<pre>';
        // var_dump($statement);
        // echo '</pre>';

        $statement->execute();
        return true;
    }

    public static function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(fn ($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}

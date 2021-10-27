<?php

namespace app\core;

use PDO;

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

        return $statement->execute();;
    }

    public function update()
    {
        $tableName =  $this->tableName();
        $attributes = $this->attributes();

        $updateArray = [];
        foreach ($attributes as $attr) {
            array_push($updateArray, $attr . '="' . $this->{$attr} . '"');
        }
        $updateArray = implode(", ", $updateArray);

        $primaryKey = $this->primaryKey();
        $id = $this->$primaryKey;

        $statement = self::prepare("UPDATE $tableName SET $updateArray WHERE $primaryKey = $id");

        return $statement->execute();
    }

    public static function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn ($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public function findAll($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn ($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");

        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
        return $statement->fetchAll();
    }

    public function getAll()
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName");

        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function delete()
    {
        $tableName = $this->tableName();
        $primaryKey = $this->primaryKey();

        $id = $this->$primaryKey;

        $statement = self::prepare("DELETE FROM $tableName WHERE $primaryKey = $id");

        return $statement->execute();
    }
    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}

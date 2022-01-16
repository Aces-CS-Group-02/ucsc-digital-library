<?php

namespace app\core;

use Exception;
use PDO;
use stdClass;

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

    public function deleteAll($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn ($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("DELETE FROM $tableName WHERE $sql");

        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        return $statement->execute();
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }


    public static function paginate($query, $start, $limit)
    {
        $sql = $query;

        $statement = self::prepare($sql);
        $statement->execute();
        $rowCount = $statement->rowCount();
        $pageCount = ceil($rowCount / $limit);

        if ($limit)  $sql = $sql . " LIMIT $start, $limit";

        $statement = self::prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_OBJ);

        $response = new stdClass;
        $response->pageCount = $pageCount;
        $response->payload = $data;
        $response->resultCount = $rowCount;

        return $response;
    }


    public static function paginate2($sql, $bindData, $start, $limit)
    {
        // Fetching and calculating page count --------------------------------
        $stmt = self::prepare($sql);

        // Bind values
        $i = 1;
        foreach ($bindData as $arr) {
            $stmt->bindValue($i, $arr['value'], $arr['type']);
            $i++;
        }

        try {
            $stmt->execute();
        } catch (Exception $e) {
            return false;
        }

        $rowCount = $stmt->rowCount();
        $pageCount = ceil($rowCount / $limit);


        // Fetching data------------------------------------------------------

        $sql = $sql . " LIMIT ? , ?";

        array_push($bindData, ['value' => $start, 'type' => PDO::PARAM_INT]);
        array_push($bindData, ['value' => $limit, 'type' => PDO::PARAM_INT]);

        $stmt_2 = self::prepare($sql);

        // Bind values
        $i = 1;
        foreach ($bindData as $arr) {
            $stmt_2->bindValue($i, $arr['value'], $arr['type']);
            $i++;
        }

        try {
            $stmt_2->execute();
        } catch (Exception $e) {
            return false;
        }

        $payload = $stmt_2->fetchAll(PDO::FETCH_OBJ);


        // Include all the data into a response Object and return it
        $responseObj = new stdClass();
        $responseObj->pageCount = $pageCount;
        $responseObj->payload = $payload;
        return $responseObj;
    }
}

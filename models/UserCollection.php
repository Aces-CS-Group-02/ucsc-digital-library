<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use PDO;

class UserCollection extends DbModel
{
    public int $reg_no;
    public int $user_collection_id;
    public string $name;

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
            'name' => [self::RULE_REQUIRED, [self::RULE_UNIQUE,'class' => self::class]]
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
}

<?php

namespace app\models;

use app\core\DbModel;

class UsergroupUser extends DbModel

{
    public int $group_id;
    public int $user_reg_no;

    public static function tableName(): string
    {
        return 'usergroup_user';
    }

    public static function primaryKey(): string
    {
        return '';
    }

    public function attributes(): array
    {
        return ['group_id', 'user_reg_no'];
    }


    public function rules(): array
    {
        return [];
    }

    public function addUser($group_id, $user)
    {
        $tableName = self::tableName();
        $value = "($group_id, $user)";
        $statement = self::prepare("INSERT INTO $tableName (group_id, user_reg_no) VALUES $value");
        return $statement->execute();
    }

    public function addUsers($group_id, $users_list_validated)
    {
        $tableName = self::tableName();
        $values = array();
        foreach ($users_list_validated as $user) {
            $value = "($group_id, $user)";
            array_push($values, $value);
        }
        $values = implode(',', $values);
        $statement = self::prepare("INSERT INTO $tableName (group_id, user_reg_no) VALUES $values");
        return $statement->execute();
    }
}

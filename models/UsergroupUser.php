<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use app\core\exception\ForbiddenException;

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

    public function removeUser($groupID, $regNo){
        var_dump($groupID, $regNo);

        $currentUserRegNo = Application::$app->user->reg_no;
        $usergroupModel = new Usergroup();

        $group = $usergroupModel->findOne(['group_id' => $groupID]);
        // If usergroup not exsist
        if(!$group) return false;

        // If current user is not a LIA/AL and not the owner of usergroup
        if(Application::getUserRole() > 2 && (int)$currentUserRegNo != (int)$group->creator_reg_no) throw new ForbiddenException();

        $targetUser = $this->findOne(['user_reg_no' => $regNo]);
        // If the user that tring to remove from the group is not exist in usegroup
        if(!$targetUser) return  false;


        $tableName = self::tableName();
        $statement = self::prepare("DELETE FROM $tableName WHERE user_reg_no=$regNo ");
        return $statement->execute();
    }
}

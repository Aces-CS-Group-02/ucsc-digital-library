<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use PDO;

class Usergroup extends DbModel
{
    public int $group_id;
    public string $name = '';
    public int $creator_reg_no;

    public static function tableName(): string
    {
        return 'usergroup';
    }

    public function attributes(): array
    {
        return ['name', 'creator_reg_no'];
    }

    public static function primaryKey(): string
    {
        return 'group_id';
    }

    public function rules(): array
    {

        return [
            'name' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]],
        ];
    }


    public function createUserGroup($data)
    {
        $this->loadData($data);
        $this->creator_reg_no = Application::$app->user->reg_no;
        if ($this->validate()) {
            if ($this->save()) return Application::$app->db->pdo->lastInsertId();
            return true;
        }
        return false;
    }

    public function findUserGroups($where)
    {
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn ($attr) => "$attr = :$attr", $attributes));

        $statement = self::prepare("SELECT U.name, U.completed_status ,COUNT(R.user_reg_no)users_count 
                                    FROM usergroup U
                                    LEFT OUTER JOIN usergroup_user R ON R.group_id =U.group_id 
                                    WHERE U.$sql
                                    GROUP BY  U.group_id ,U.name");

        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function getAllUsersNotInThisGroup($group_id)
    {

        $statement = self::prepare("SELECT * FROM user t1
                                    LEFT JOIN (SELECT * FROM usergroup_user WHERE group_id = $group_id) t2 
                                    ON t2.user_reg_no = t1.reg_no
                                    WHERE t2.user_reg_no IS NULL");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function pushUserToUserGroup($group_id, $reg_no)
    {
        $userModel = new User();
        // If group not exist return false
        if (!$this->findOne(['group_id' => $group_id])) return false;
        //  If user id not exist return false
        if (!$userModel->findOne(['reg_no' => $reg_no])) return false;

        $usergroupUserModel = new UsergroupUser;

        if ($usergroupUserModel->addUser($group_id, $reg_no)) return true;
        return false;
    }

    public function pushUsersToUserGroup($group_id, $users_list)
    {
        // If group not exist return false
        if (!$this->findOne(['group_id' => $group_id])) return false;
        $userModel = new User();
        $usergroupUserModel = new UsergroupUser();

        $users_list_validated = array();
        foreach ($users_list as $user) {
            if ($userModel->findOne(['reg_no' => $user]) && !$usergroupUserModel->findOne(['group_id' => $group_id, 'user_reg_no' => $user])) array_push($users_list_validated, $user);
        }

        if ($usergroupUserModel->addUsers($group_id, $users_list_validated)) return true;
        return false;
    }
}

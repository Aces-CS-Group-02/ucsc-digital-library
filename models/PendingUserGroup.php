<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use app\core\Request;
use PDO;

class PendingUserGroup extends DbModel
{
    public int $group_id;
    public string $name;
    public int $creator_reg_no;
    public bool $completed_status = false;

    public static function tableName(): string
    {
        return 'pending_usergroup';
    }

    public function attributes(): array
    {
        return ['name', 'creator_reg_no', 'completed_status'];
    }

    public static function primaryKey(): string
    {
        return 'group_id';
    }

    public function rules(): array
    {

        return [
            'name' => [self::RULE_REQUIRED],
        ];
    }

    public function getAllUsersNotInThisGroup($group_id)
    {
        $statement = self::prepare("SELECT * FROM user t1
                                    LEFT JOIN (SELECT * FROM pending_usergroup_users WHERE group_id = $group_id) t2 
                                    ON t2.user_reg_no = t1.reg_no
                                    WHERE t2.user_reg_no IS NULL AND t1.role_id >= 4");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function createPendingUserGroup($data)
    {
        $tempUserGroupModel = new UserGroup();
        $tempUserGroupModel->loadData($data);
        $this->loadData($data);

        $statement_spec = 'AND creator_type = 0';
        $this->creator_reg_no = Application::$app->user->reg_no;

        if ($tempUserGroupModel->validate($statement_spec) && $this->validate()) {
            if (Application::getUserRole() === 3) {
                if ($this->save()) return true;
            }
        }
        return false;
    }


    public function createCustomUsergroup($data)
    {
        $this->loadData($data);
        $this->creator_reg_no = Application::$app->user->reg_no;

        if ($this->validate()) {
            if ($this->save()) return Application::$app->db->pdo->lastInsertId();
        }
        return false;
        //     if ($this->save()) return Application::$app->db->pdo->lastInsertId();
        // }
        // return false;
    }



    public function pushUserToUserGroup($group_id, $reg_no)
    {
        $userModel = new User();
        // If group not exist return false
        if (!$this->findOne(['group_id' => $group_id])) return false;
        //  If user id not exist return false
        if (!$userModel->findOne(['reg_no' => $reg_no])) return false;

        $usergroupUserModel = new PendingUsergroupUser();

        if ($usergroupUserModel->addUser($group_id, $reg_no)) return true;
        return false;
    }


    public function getAllUsersInUserGroup($group_id)
    {
        $userModel = new User();
        $usergroupUserModel = new PendingUsergroupUser();

        $tableName_1 = $userModel::tableName();
        $tableName_2 = $usergroupUserModel::tableName();

        $statement = self::prepare("SELECT t2.reg_no, t2.first_name, t2.last_name, t2.email
                                    FROM $tableName_2 t1
                                    JOIN $tableName_1 t2
                                    ON t2.reg_no = t1.user_reg_no
                                    WHERE group_id = $group_id");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function requestApproval($group_id)
    {
        $tableName = self::tableName();
        $pending_group = $this->findOne(['group_id' => $group_id]);

        if ($pending_group && !$pending_group->completed_status) {
            $statement = self::prepare("UPDATE $tableName SET completed_Status = true WHERE group_id = $group_id");
            return $statement->execute();
        }
        return false;
    }
}

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
    public string $description;
    public int $creator_reg_no;
    public bool $completed_status = false;

    public static function tableName(): string
    {
        return 'pending_usergroup';
    }

    public function attributes(): array
    {
        return ['name', 'description', 'creator_reg_no', 'completed_status'];
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

    // public function getAllUsersNotInThisGroup($group_id)
    // {
    //     $statement = self::prepare("SELECT * FROM user t1
    //                                 LEFT JOIN (SELECT * FROM pending_usergroup_users WHERE group_id = $group_id) t2 
    //                                 ON t2.user_reg_no = t1.reg_no
    //                                 WHERE t2.user_reg_no IS NULL AND t1.role_id >= 4");
    //     $statement->execute();
    //     return $statement->fetchAll(PDO::FETCH_OBJ);
    // }

    public function createUsergroup($data)
    {
        $this->loadData($data);
        $this->creator_reg_no = Application::$app->user->reg_no;
        if ($this->validate()) {
            if ($this->save()) return Application::$app->db->pdo->lastInsertId();
            return true;
        }
        return false;
    }

    public function getAllUsersNotInThisGroup($group_id, $search_params = '', $getRecordsCount = false, $start = false, $limit = false)
    {
        $sql = "SELECT * FROM user t1
                LEFT JOIN (SELECT * FROM pending_usergroup_users WHERE group_id = $group_id) t2 
                ON t2.user_reg_no = t1.reg_no
                WHERE t2.user_reg_no IS NULL AND t1.role_id >= 4 AND
                (first_name LIKE '%$search_params%'
                OR last_name LIKE '%$search_params%'
                OR email LIKE '%$search_params%')";

        if ($getRecordsCount) {
            $statement = self::prepare($sql);
            $statement->execute();
            return $statement->rowCount();
        } else {
            if ($limit)  $sql = $sql . " LIMIT $start, $limit";
            $statement = self::prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_OBJ);
        }
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


    public function pushUsersToUserGroup($group_id, $users_list)
    {
        // If group not exist return false
        if (!$this->findOne(['group_id' => $group_id])) return false;
        $userModel = new User();
        $usergroupUserModel = new PendingUsergroupUser();

        $users_list_validated = array();
        foreach ($users_list as $user) {
            if ($userModel->findOne(['reg_no' => $user]) && !$usergroupUserModel->findOne(['group_id' => $group_id, 'user_reg_no' => $user])) array_push($users_list_validated, $user);
        }

        // var_dump($users_list_validated);

        if ($usergroupUserModel->addUsers($group_id, $users_list_validated)) return true;
        return false;
    }



    public function getAllUsersInUserGroup($group_id, $search_params = '', $getRecordsCount = false, $start = false, $limit = false)
    {
        $userModel = new User();
        $usergroupUserModel = new PendingUsergroupUser();

        $tableName_1 = $userModel::tableName();
        $tableName_2 = $usergroupUserModel::tableName();

        $sql = "SELECT t2.reg_no, t2.first_name, t2.last_name, t2.email
                FROM $tableName_2 t1
                JOIN $tableName_1 t2
                ON t2.reg_no = t1.user_reg_no
                WHERE group_id = $group_id AND
                (first_name LIKE '%$search_params%'
                OR last_name LIKE '%$search_params%'
                OR email LIKE '%$search_params%')";


        if ($getRecordsCount) {
            $statement = self::prepare($sql);
            $statement->execute();
            return $statement->rowCount();
        } else {
            if ($limit)  $sql = $sql . " LIMIT $start, $limit";
            $statement = self::prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_OBJ);
        }
    }
}

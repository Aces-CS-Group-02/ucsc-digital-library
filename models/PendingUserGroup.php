<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use app\core\Request;
use Exception;
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


    public function requestApproval($group_id)
    {
        $usergroup = $this->findOne(['group_id' => $group_id]);
        $tableName = self::tableName();
        if ($usergroup && !$usergroup->completed_status && $usergroup->creator_reg_no == Application::$app->user->reg_no) {
            $sql = "UPDATE $tableName SET `completed_status`=1 WHERE group_id = $group_id";
            $statement = self::prepare($sql);
            return $statement->execute();
        } else {
            return false;
        }
    }


    public function removeGroup($group_id)
    {
        $tableName = self::tableName();
        $primaryKey = self::primaryKey();

        $user = Application::$app->user->reg_no;

        $group = $this->findOne(['group_id' => $group_id]);

        if (!$group) return false;
        if ($user != $group->creator_reg_no) return false;

        $statement = self::prepare("DELETE FROM $tableName WHERE $primaryKey = $group_id");
        return $statement->execute();
    }


    public function getAllRequests($start, $limit)
    {
        $tableName1 = self::tableName();
        $tableName2 = User::tableName();
        $statement =
            "SELECT g.group_id, DATE(g.created_date)as date, g.name, g.description, u.first_name, u.last_name 
            FROM $tableName1 g
            JOIN $tableName2 u ON g.creator_reg_no = u.reg_no";
        // $statement->execute();
        // return $statement->fetchAll(PDO::FETCH_OBJ);



        return $this->paginate($statement, $start, $limit);
    }

    public function approve($group_id)
    {

        $usergroup_table = Usergroup::tableName();
        $pendingug_table = self::tableName();
        $pendingug_user_table = PendingUsergroupUser::tableName();
        $usergroup_user_table = UsergroupUser::tableName();

        $primaryKey = self::primaryKey();
        $statement = self::prepare("SELECT * FROM $pendingug_table WHERE $primaryKey = $group_id");
        $statement->execute();
        $group = $statement->fetch(PDO::FETCH_OBJ);
        if (!$group) return false;

        $ugModel = new Usergroup();

        $ugModel->name = $group->name;
        $ugModel->description = $group->description;
        $ugModel->creator_reg_no = $group->creator_reg_no;

        if (!$ugModel->validate()) return false;

        // var_dump($ugModel);


        // Get all pending users from pending usergroup users table
        $statement = PendingUsergroupUser::prepare("SELECT user_reg_no FROM $pendingug_user_table WHERE group_id = $group_id");
        $statement->execute();
        $pending_users = $statement->fetchAll(PDO::FETCH_OBJ);

        $users_list = array();
        foreach ($pending_users as $pu) {
            array_push($users_list, $pu->user_reg_no);
        }



        // Remove group from pending table
        $statement2 = self::prepare("DELETE FROM $pendingug_table WHERE $primaryKey = $group_id");

        // Remove all users from pending usergroup users table
        $statement3 = self::prepare("DELETE FROM $pendingug_user_table WHERE group_id = $group_id");

        $ug_user_model = new UsergroupUser();


        try {
            Application::$app->db->pdo->beginTransaction();
            echo 'Transaction started... ';

            $ugModel->save();
            echo 'Inserted into usergroup table ';


            $statement2->execute();
            echo 'Remove from pending ug table  ';


            $statement3->execute();
            echo 'Removed users  ';

            $ug_user_model->addUsers($group_id, $users_list);
            echo "👉 ";
            echo 'Inserted users  ';

            Application::$app->db->pdo->commit();
        } catch (Exception $e) {

            Application::$app->db->pdo->rollBack();
            echo 'Rolling back  ';
        }
    }
}

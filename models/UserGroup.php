<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use PDO;

class Usergroup extends DbModel
{
    public int $group_id;
    public string $name = '';
    public string $description = '';
    public int $creator_reg_no;

    public static function tableName(): string
    {
        return 'usergroup';
    }

    public function attributes(): array
    {
        return ['name', 'description', 'creator_reg_no'];
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


    /*-------------------------------------------------------------------------------------------
    \ This getAllUsersNotInThisGroup function takes group_id,getRecordsCount, start and limit. 
    \ 
    \ If we specify getRecordsCount true then it doesn't care about rest parameters and it 
    \ returns row count
    \
    \ If we specify getRecordsCount false then returns All fetched data. Here we can specify 
    \ start position and limit                           
    ---------------------------------------------------------------------------------------------*/
    public function getAllUsersNotInThisGroup($group_id, $search_params = '', $getRecordsCount = false, $start = false, $limit = false)
    {
        $sql = "SELECT * FROM user t1
                LEFT JOIN (SELECT * FROM usergroup_user WHERE group_id = $group_id) t2 
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

        // var_dump($users_list_validated);

        if ($usergroupUserModel->addUsers($group_id, $users_list_validated)) return true;
        return false;
    }

    // public function getAllUsersInUserGroup($group_id)
    // {
    //     $userModel = new User();
    //     $usergroupUserModel = new UsergroupUser();

    //     $tableName_1 = $userModel::tableName();
    //     $tableName_2 = $usergroupUserModel::tableName();

    //     $statement = self::prepare("SELECT t2.reg_no, t2.first_name, t2.last_name, t2.email
    //                                 FROM $tableName_2 t1
    //                                 JOIN $tableName_1 t2
    //                                 ON t2.reg_no = t1.user_reg_no
    //                                 WHERE group_id = $group_id");
    //     $statement->execute();
    //     return $statement->fetchAll(PDO::FETCH_OBJ);
    // }



    public function getAllUsersInUserGroup($group_id, $search_params = '', $getRecordsCount = false, $start = false, $limit = false)
    {
        $userModel = new User();
        $usergroupUserModel = new UsergroupUser();

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

    public function getAllUsergroups($search_params = '', $getRecordsCount = false, $start = false, $limit = false)
    {

        $creator = Application::$app->user->reg_no;


        // $inject = '';
        // if (Application::getUserRole() === 3) $inject = "t1.creator_reg_no = $creator AND";


        if (Application::getUserRole() <= 2) {
            $sql = "SELECT t1.group_id, t1.name, t1.description, t2.first_name, t2.last_name FROM 
                usergroup t1 LEFT JOIN user t2
                ON t1.creator_reg_no = t2.reg_no
                WHERE
                (name LIKE '%$search_params%'
                OR description LIKE '%$search_params%'
                OR first_name LIKE '%$search_params%'
                OR last_name LIKE '%$search_params%')";
        }

        if (Application::getUserRole() === 3) {
            $sql = "SELECT group_id, name, description, creator_reg_no, created_date, 'live' as completed_status FROM
                    usergroup
                    WHERE creator_reg_no = $creator AND
                    (name LIKE '%$search_params%'
                    OR description LIKE '%$search_params%')
                    UNION
                    SELECT group_id, name, description, creator_reg_no, created_date, completed_status FROM 
                    pending_usergroup
                    WHERE creator_reg_no = $creator AND
                    (name LIKE '%$search_params%'
                    OR description LIKE '%$search_params%')
                    ORDER BY name";
        }

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


    public function getAllLiveUsergroups($search_params = '', $getRecordsCount = false, $start = false, $limit = false)
    {
        $sql = "SELECT t1.group_id, t1.name, t1.description, t2.first_name, t2.last_name FROM 
                usergroup t1 LEFT JOIN user t2
                ON t1.creator_reg_no = t2.reg_no
                WHERE
                (name LIKE '%$search_params%'
                OR description LIKE '%$search_params%'
                OR first_name LIKE '%$search_params%'
                OR last_name LIKE '%$search_params%')";

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

    public function removeGroup($group_id)
    {
        $tableName = self::tableName();
        $primaryKey = self::primaryKey();

        $user = Application::$app->user->reg_no;


        $statement = self::prepare("SELECT * FROM pending_usergroup WHERE $primaryKey = $group_id");
        $statement->execute();
        $group = $statement->fetchAll(PDO::FETCH_OBJ);

        var_dump($group);

        if (!$group) return false;
        // if (Application::getUserRole() >= 3 && $user != $group->creator_reg_no) return false;




        if (Application::getUserRole() <= 2) {
            if ($this->findOne(['group_id' => $group_id])) {
                $statement = self::prepare("DELETE FROM pending_usergroup WHERE $primaryKey = $group_id");
                return $statement->execute();
            }
        }
    }
}

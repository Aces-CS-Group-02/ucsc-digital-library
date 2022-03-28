<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use Exception;
use PDO;

class Usergroup extends DbModel
{
    public int $id;
    public string $name;
    public string $description;
    public int $creator;
    public int $status;
    public $created_date;

    public static function tableName(): string
    {
        return 'usergroup';
    }

    public function attributes(): array
    {
        return ['name', 'description', 'creator', 'status'];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {

        return [
            'name' => [self::RULE_REQUIRED],
            'creator' => [self::RULE_REQUIRED],
            'status' => [self::RULE_REQUIRED]
        ];
    }


    public function createUserGroup($data)
    {
        $this->loadData($data);
        $this->creator = Application::$app->user->reg_no;

        if (Application::getUserRole() <= 2) {
            $this->status = 1;
        } else {
            $this->status = 3;
        }

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
    // public function getAllUsersNotInThisGroup($group_id, $search_params = '', $getRecordsCount = false, $start = false, $limit = false)
    // {
    //     $sql = "SELECT * FROM user t1
    //             LEFT JOIN (SELECT * FROM usergroup_user WHERE group_id = $group_id) t2 
    //             ON t2.user_reg_no = t1.reg_no
    //             WHERE t2.user_reg_no IS NULL AND t1.role_id >= 4 AND
    //             (first_name LIKE '%$search_params%'
    //             OR last_name LIKE '%$search_params%'
    //             OR email LIKE '%$search_params%')";

    //     if ($getRecordsCount) {
    //         $statement = self::prepare($sql);
    //         $statement->execute();
    //         return $statement->rowCount();
    //     } else {
    //         if ($limit)  $sql = $sql . " LIMIT $start, $limit";
    //         $statement = self::prepare($sql);
    //         $statement->execute();
    //         return $statement->fetchAll(PDO::FETCH_OBJ);
    //     }
    // }


    public function getAllUsersNotInThisGroup($group_id, $search_params, $start, $limit)
    {

        if (Application::getUserRole() <= 2) {
            // Get All user (Excepting user role)
            $sql = "SELECT * FROM user t1
                    LEFT JOIN (SELECT * FROM usergroup_user WHERE group_id = $group_id) t2 
                    ON t2.user_reg_no = t1.reg_no
                    JOIN role t3
                    ON t1.role_id = t3.role_id
                    WHERE t2.user_reg_no IS NULL
                    AND
                    (first_name LIKE '%$search_params%'
                    OR last_name LIKE '%$search_params%'
                    OR email LIKE '%$search_params%'
                    OR t3.name LIKE '%$search_params%')";
        } else if (Application::getUserRole() == 3) {
            // Get only students (user role >= 4)
            $sql = "SELECT * FROM user t1
                    LEFT JOIN (SELECT * FROM usergroup_user WHERE group_id = $group_id) t2 
                    ON t2.user_reg_no = t1.reg_no
                    WHERE t2.user_reg_no IS NULL AND t1.role_id >= 4 AND
                    (first_name LIKE '%$search_params%'
                    OR last_name LIKE '%$search_params%'
                    OR email LIKE '%$search_params%')";
        }

        return $this->paginate($sql, $start, $limit);
    }

    public function pushUserToUserGroup($group_id, $reg_no)
    {
        $userModel = new User();
        // If group not exist return false
        if (!$this->findOne(['id' => $group_id])) return false;

        //  If user id not exist return false
        if (!$userModel->findOne(['reg_no' => $reg_no])) return false;

        $usergroupUserModel = new UsergroupUser;

        if ($usergroupUserModel->addUser($group_id, $reg_no)) return true;
        return false;
    }

    public function pushUsersToUserGroup($group_id, $users_list)
    {
        // If group not exist return false
        if (!$this->findOne(['id' => $group_id])) return false;
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



    // public function getAllUsersInUserGroup($group_id, $search_params = '', $getRecordsCount = false, $start = false, $limit = false)
    // {
    //     $userModel = new User();
    //     $usergroupUserModel = new UsergroupUser();

    //     $tableName_1 = $userModel::tableName();
    //     $tableName_2 = $usergroupUserModel::tableName();

    //     $sql = "SELECT *
    //             FROM $tableName_2 t1
    //             JOIN $tableName_1 t2
    //             ON t2.reg_no = t1.user_reg_no
    //             WHERE group_id = $group_id AND
    //             (first_name LIKE '%$search_params%'
    //             OR last_name LIKE '%$search_params%'
    //             OR email LIKE '%$search_params%')";


    //     if ($getRecordsCount) {
    //         $statement = self::prepare($sql);
    //         $statement->execute();
    //         return $statement->rowCount();
    //     } else {
    //         if ($limit)  $sql = $sql . " LIMIT $start, $limit";
    //         $statement = self::prepare($sql);
    //         $statement->execute();
    //         return $statement->fetchAll(PDO::FETCH_OBJ);
    //     }
    // }

    public function getAllUsersInUserGroup($group_id, $search_params, $start, $limit)
    {
        $userModel = new User();
        $usergroupUserModel = new UsergroupUser();

        $tableName_1 = $userModel::tableName();
        $tableName_2 = $usergroupUserModel::tableName();

        $sql = "SELECT *
                FROM $tableName_2 t1
                JOIN $tableName_1 t2
                ON t2.reg_no = t1.user_reg_no
                JOIN role t3
                ON t2.role_id = t3.role_id
                WHERE group_id = $group_id AND
                (first_name LIKE '%$search_params%'
                OR last_name LIKE '%$search_params%'
                OR email LIKE '%$search_params%'
                OR t3.name LIKE '%$search_params%')";

        return $this->paginate($sql, $start, $limit);
    }


    public function getAllUsergroups($search_params = '', $start, $limit)
    {

        $creator = Application::$app->user->reg_no;
        $tableName = self::tableName();

        // $inject = '';
        // if (Application::getUserRole() === 3) $inject = "t1.creator_reg_no = $creator AND";


        // if (Application::getUserRole() <= 2) {
        //     $sql = "SELECT t1.group_id, t1.name, t1.description, t2.first_name, t2.last_name, 'live' as completed_status FROM 
        //         usergroup t1 LEFT JOIN user t2
        //         ON t1.creator_reg_no = t2.reg_no
        //         WHERE
        //         (name LIKE '%$search_params%'
        //         OR description LIKE '%$search_params%'
        //         OR first_name LIKE '%$search_params%'
        //         OR last_name LIKE '%$search_params%')";
        // }

        // if (Application::getUserRole() === 3) {
        //     $sql = "SELECT group_id, name, description, creator_reg_no, created_date, 'live' as completed_status FROM
        //             usergroup
        //             WHERE creator_reg_no = $creator AND
        //             (name LIKE '%$search_params%'
        //             OR description LIKE '%$search_params%')
        //             UNION
        //             SELECT group_id, name, description, creator_reg_no, created_date, completed_status FROM 
        //             pending_usergroup
        //             WHERE creator_reg_no = $creator AND
        //             (name LIKE '%$search_params%'
        //             OR description LIKE '%$search_params%')
        //             ORDER BY name";
        // }

        if (Application::getUserRole() <= 2) {
            $sql = "SELECT g.*, u.first_name, u.last_name FROM usergroup g
                    JOIN user u on u.reg_no = g.creator
                    WHERE status=1";

            if ($search_params != '') $sql = $sql . " AND (name LIKE '%$search_params%' OR first_name LIKE '%$search_params%' OR last_name LIKE '%$search_params%')";
        } else if (Application::getUserRole() === 3) {
            $sql = "SELECT g.*, u.first_name, u.last_name FROM usergroup g
                    JOIN user u on u.reg_no = g.creator
                    WHERE creator=$creator AND g.status != 4";

            if ($search_params != '') $sql = $sql . " AND name LIKE '%$search_params%'";
        } else {
            return false;
        }



        return $this->paginate($sql, $start, $limit);
    }


    // public function getAllLiveUsergroups($search_params = '', $getRecordsCount = false, $start = false, $limit = false)
    // {
    //     $sql = "SELECT t1.group_id, t1.name, t1.description, t2.first_name, t2.last_name FROM 
    //             usergroup t1 LEFT JOIN user t2
    //             ON t1.creator_reg_no = t2.reg_no
    //             WHERE
    //             (name LIKE '%$search_params%'
    //             OR description LIKE '%$search_params%'
    //             OR first_name LIKE '%$search_params%'
    //             OR last_name LIKE '%$search_params%')";

    //     if ($getRecordsCount) {
    //         $statement = self::prepare($sql);
    //         $statement->execute();
    //         return $statement->rowCount();
    //     } else {
    //         if ($limit)  $sql = $sql . " LIMIT $start, $limit";
    //         $statement = self::prepare($sql);
    //         $statement->execute();
    //         return $statement->fetchAll(PDO::FETCH_OBJ);
    //     }
    // }


    public function getAllLiveUsergroups($search_params = '', $start, $limit)
    {
        $sql = "SELECT t1.id, t1.name, t1.description, t2.first_name, t2.last_name FROM 
                usergroup t1 
                JOIN user t2
                ON t1.creator = t2.reg_no
                WHERE status=1 
                AND (name LIKE '%$search_params%'
                OR description LIKE '%$search_params%'
                OR first_name LIKE '%$search_params%'
                OR last_name LIKE '%$search_params%')
                ORDER BY t1.name";

        return $this->paginate($sql, $start, $limit);

        // if ($getRecordsCount) {
        //     $statement = self::prepare($sql);
        //     $statement->execute();
        //     return $statement->rowCount();
        // } else {
        //     if ($limit)  $sql = $sql . " LIMIT $start, $limit";
        //     $statement = self::prepare($sql);
        //     $statement->execute();
        //     return $statement->fetchAll(PDO::FETCH_OBJ);
        // }
    }

    public function removeGroup($group_id)
    {
        $usergroupTable = self::tableName();
        $primaryKey = self::primaryKey();

        $user = Application::$app->user->reg_no;

        $group = $this->findOne(['id' => $group_id]);

        if (!$group) return false;
        if (Application::getUserRole() === 3 && $user != $group->creator) return false;

        $statement = self::prepare("DELETE FROM $usergroupTable WHERE $primaryKey = $group_id");
        return $statement->execute();
    }

    public function requestApproval($group_id)
    {

        $group = $this->findOne(['id' => $group_id]);
        $currentUser = Application::$app->user->reg_no;

        if (!$group) return false;

        // var_dump($group);

        if ($group->status == 3 && $group->creator == $currentUser) {
            $this->loadData($group);
            $this->status = 2;

            $userModel = new User();
            $staffMembers = $userModel->getAllLibraryStaffMember();
            $staff_members_list = array();
            foreach ($staffMembers as $staffMember) {
                array_push($staff_members_list, $staffMember->reg_no);
            }


            $notificationModel = new Notification();
            $notificationModel->loadData(['msg' => "New pending user group available"]);
            if (!$notificationModel->validate()) return false;
            $notificationReceiverModel = new NotificationReceiver();

            try {
                Application::$app->db->pdo->beginTransaction();
                $this->update();
                $notificationModel->save();
                $notificationReceiverModel->setMultipleReceviers(Application::$app->db->pdo->lastInsertId(), $staff_members_list);
                Application::$app->db->pdo->commit();
                return true;
            } catch (Exception $e) {
                Application::$app->db->pdo->rollBack();
                return false;
            }
        }
    }

    public function getAllRequests($search_params, $start, $limit)
    {
        $usergroupTable = self::tableName();
        $userTable = User::tableName();
        $sql = "SELECT DATE(g.created_date) as created_date,  g.id, g.name, g.description, u.first_name, u.last_name FROM 
                $usergroupTable g 
                JOIN $userTable u ON g.creator = u.reg_no 
                WHERE status = 2
                AND (g.name LIKE '%$search_params%' 
                OR u.first_name LIKE '%$search_params%' 
                OR u.last_name LIKE '%$search_params%')";

        return $this->paginate($sql, $start, $limit);
    }

    public function approve($group_id)
    {
        $group = $this->findOne(['id' => $group_id]);
        if (!$group) return false;

        $this->loadData($group);
        $this->status = 1;

        $currentUser = Application::$app->user->reg_no;
        $usergroupApprovedModel = new UsergroupApproved();
        $usergroupApprovedModel->loadData(['group_id' => $group->id, 'performer' => $currentUser]);
        if (!$usergroupApprovedModel->validate()) return false;


        $notificationModel = new Notification();
        $notificationModel->loadData(['msg' => "Your usergroup $group->name is approved by library staff."]);
        if (!$notificationModel->validate()) return false;
        $notificationReceiverModel = new NotificationReceiver();

        // var_dump($notificationModel);

        try {
            Application::$app->db->pdo->beginTransaction();
            $this->update();
            $usergroupApprovedModel->save();
            $notificationModel->save();

            $notificationReceiverModel->loadData(['notification_id' => Application::$app->db->pdo->lastInsertId(), 'receiver' => $group->creator, 'view_status' => false]);
            if (!$notificationReceiverModel->validate()) return false;
            var_dump($notificationReceiverModel);

            $notificationReceiverModel->save();

            Application::$app->db->pdo->commit();
            return true;
        } catch (Exception $e) {
            Application::$app->db->pdo->rollBack();
            return false;
        }
    }

    public function reject($group_id, $msg)
    {
        $request = $this->findOne(['id' => $group_id]);

        if (!$request) return false;

        $this->loadData($request);
        $this->status = 4;

        $usergroupRejectModel = new UsergroupReject();

        $currentUser = Application::$app->user->reg_no;

        $usergroupRejectModel->loadData(['group_id' => $group_id, 'msg' => $msg, 'performer' => $currentUser]);
        if (!$usergroupRejectModel->validate()) return false;


        // Notification
        $notificationModel = new Notification();
        $notificationModel->loadData(['msg' => "Your usergroup $request->name is rejected by library staff because of $msg "]);
        if (!$notificationModel->validate()) return false;
        $notificationReceiverModel = new NotificationReceiver();


        try {
            Application::$app->db->pdo->beginTransaction();
            $this->update();

            $usergroupRejectModel->save();

            $notificationModel->save();

            $notificationReceiverModel->loadData(['notification_id' => Application::$app->db->pdo->lastInsertId(), 'receiver' => $request->creator, 'view_status' => FALSE]);
            if (!$notificationReceiverModel->validate()) return false;
            var_dump($notificationReceiverModel);

            $notificationReceiverModel->save();

            Application::$app->db->pdo->commit();
            return true;
        } catch (Exception $e) {
            Application::$app->db->pdo->rollBack();
            exit;
            return false;
        }
    }

    public function getUsergroupInfo($id)
    {
        $user_table = User::tableName();
        $usergroup_table = self::tableName();

        $sql = "SELECT g.*, u.first_name, u.last_name
                FROM $usergroup_table g
                JOIN $user_table u ON g.creator = u.reg_no
                WHERE g.id=$id";

        $statement = self::prepare($sql);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_OBJ);
    }


    public function browseUsergroup($search_params, $start, $limit)
    {
        $currentUser = Application::$app->user->reg_no;
        $currentUserRole = Application::getUserRole();

        if ($currentUserRole <= 2) {
            $sql = "SELECT a.*, b.first_name, b.last_name FROM usergroup a
                    JOIN user b ON a.creator = b.reg_no
                    WHERE status = 1
                    AND (name LIKE '%$search_params%' OR description LIKE '%$search_params%' OR first_name LIKE '%$search_params%' OR last_name LIKE '%$search_params%')";
        } else if ($currentUserRole == 3) {
            $sql = "SELECT a.*, b.first_name, b.last_name FROM usergroup a 
                    JOIN user b ON a.creator = b.reg_no
                    WHERE creator = $currentUser AND status = 1
                    AND (name LIKE '%$search_params%' OR description LIKE '%$search_params%' OR first_name LIKE '%$search_params%' OR last_name LIKE '%$search_params%')";
        }
        return $this->paginate($sql, $start, $limit);
    }
}

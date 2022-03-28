<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use PDO;
use stdClass;

class CollectionPermission extends DbModel
{
    public int $collection_id;
    public int $group_id;
    public $permission = '';

    public static function tableName(): string
    {
        return 'collection_permission';
    }

    public static function primaryKey(): string
    {
        return '';
    }

    public function attributes(): array
    {
        return ['collection_id', 'group_id', 'permission'];
    }

    public function rules(): array
    {
        return [
            'collection_id' => [self::RULE_REQUIRED],
            'group_id' => [self::RULE_REQUIRED],
            'permission' => [self::RULE_REQUIRED]
        ];
    }

    public function updatePermission()
    {
        $collection_permission_table = self::tableName();
        $collection_id = $this->collection_id;
        $group_id = $this->group_id;
        $permission = $this->permission;

        $sql = "UPDATE $collection_permission_table
                SET 
                collection_id = $collection_id, 
                group_id = $group_id,
                permission = $permission
                WHERE collection_id=$collection_id AND group_id=$group_id";

        $statement = self::prepare($sql);
        return $statement->execute();
    }

    public function getAccessPermissionOnCollections($start, $limit)
    {
        $collection_permission_table = self::tableName();
        $currentUser = Application::$app->user->reg_no;

        if (Application::getUserRole() <= 2) {
            $sql = "SELECT 
                        a.*, 
                        b.name as ug_name, 
                        c.first_name as ug_owner_fn, c.last_name as ug_owner_ln 
                    FROM $collection_permission_table a
                    JOIN usergroup b
                    ON a.group_id=b.id
                    JOIN user c
                    ON b.creator=c.reg_no";
        } else if (Application::getUserRole() == 3) {
            $sql = "SELECT 
                        a.*, 
                        b.name as ug_name, 
                        c.first_name as ug_owner_fn, c.last_name as ug_owner_ln 
                    FROM $collection_permission_table a
                    JOIN usergroup b
                    ON a.group_id=b.id
                    JOIN user c
                    ON b.creator=c.reg_no
                    WHERE b.creator=$currentUser";
        }


        $data = $this->paginate($sql, $start, $limit);

        $arr = [];
        foreach ($data->payload as $item) {
            $collection_id = $item->collection_id;

            $collectionModel = new Collection();
            $collection = $collectionModel->findOne(['collection_id' => $collection_id]);

            $communityModel = new Community();
            $temp_path = [];
            $res = $communityModel->communityBreadcrumGenerate($collection->community_id);
            foreach ($res as $r) {
                array_push($temp_path, $r['name']);
            }
            array_push($temp_path, $collection->name);
            $collection_path_str = implode(' > ', $temp_path);

            $dataObj = new stdClass;
            $dataObj->collection_id = $collection_id;
            $dataObj->group_id = $item->group_id;
            $dataObj->collection = $collection_path_str;
            $dataObj->group = $item->ug_name;
            $dataObj->ug_owner_fn = $item->ug_owner_fn;
            $dataObj->ug_owner_ln = $item->ug_owner_ln;
            $dataObj->permission = $item->permission;

            array_push($arr, $dataObj);
        }

        $retObj = new stdClass;
        $retObj->pageCount = $data->pageCount;
        $retObj->payload = $arr;

        return $retObj;
    }



    // public function viewCollectionPermissions($Search_params, $start, $limit)
    // {
    //     $sql = "SELECT * FROM collection_permission";
    //     $statement = self::prepare($sql);
    //     $statement->execute();
    //     $data = $statement->fetchAll(PDO::FETCH_OBJ);
    // }

    public function removeCollectionPermission($collection_id, $group_id)
    {
        $collection_permission_table = self::tableName();

        $currentUser = Application::$app->user->reg_no;

        if (Application::getUserRole() == 3) {
            $sql_temp = "SELECT * FROM usergroup WHERE id=$group_id AND creator=$currentUser";
            $statement = self::prepare($sql_temp);
            $statement->execute();
            $res = $statement->fetch(PDO::FETCH_OBJ);
            if (!$res) return false;
        }

        $sql = "DELETE FROM $collection_permission_table WHERE collection_id=$collection_id AND group_id=$group_id";

        $statement = self::prepare($sql);
        return $statement->execute();
    }


    public function checkAccessPermission($content)
    {
        $collection_permission_table = self::tableName();
        $usergroup_user_table = UsergroupUser::tableName();

        if (Application::$app->user) {
            $currentUser = Application::$app->user->reg_no;
            $sql = "SELECT permission
                    FROM $collection_permission_table 
                    WHERE collection_id=$content->collection_id
                    AND group_id IN(SELECT group_id FROM $usergroup_user_table WHERE user_reg_no = $currentUser UNION SELECT 1)";
        } else {
            $sql = "SELECT permission
                    FROM $collection_permission_table 
                    WHERE collection_id=$content->collection_id
                    AND group_id IN(1)";

            // SYSTEMP_PUBLIC usergroup has id 1

        }


        $statement = self::prepare($sql);
        $statement->execute();
        $permission = $statement->fetchAll(PDO::FETCH_OBJ);

        $permissionObj = new stdClass;


        if ($permission) {
            // echo 'you have access';
            $permission_arr = [];
            foreach ($permission as $p) {
                array_push($permission_arr, (int)$p->permission);
            }

            $permissionObj->permission = true;

            if (in_array(2, $permission_arr)) {
                $permissionObj->grant_type = "READ_DOWNLOAD";
            } else if (in_array(1, $permission_arr)) {
                $permissionObj->grant_type = "READ";
            }
        } else {
            // echo 'No Access permission';
            $permissionObj->permission = false;
            $permissionObj->grant_type = "NULL";
        }

        return $permissionObj;
    }
}

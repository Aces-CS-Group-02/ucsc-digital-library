<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use PDO;

class ContentCollectionPermission extends DbModel
{

    public int $content_collection_id;
    public int $group_id;
    public $permission;

    public static function tableName(): string
    {
        return 'content_collection_permission';
    }

    public static function primaryKey(): string
    {
        return '';
    }

    public function attributes(): array
    {
        return ['content_collection_id', 'group_id', 'permission'];
    }

    public function rules(): array
    {
        return ['content_collection_id' => [self::RULE_REQUIRED], 'group_id' => [self::RULE_REQUIRED], 'permission' => [self::RULE_REQUIRED]];
    }

    public function updatePermission()
    {
        $tableName = self::tableName();
        $sql = "UPDATE $tableName SET permission = $this->permission WHERE content_collection_id = $this->content_collection_id AND group_id = $this->group_id";
        $statement = self::prepare($sql);
        return $statement->execute();
    }

    public function viewContentCollectionPermissions($search_params, $start, $limit)
    {
        $content_collection_permission_table = self::tableName();
        $content_collection_table = ContentCollection::tableName();
        $sql = "SELECT a.*, b.name as collection_name, d.name as ug_name, c.first_name as collection_owner_fn, c.last_name as collection_owner_ln, e.first_name as ug_owner_fn, e.last_name as ug_owner_ln FROM $content_collection_permission_table a
                JOIN $content_collection_table b
                ON a.content_collection_id=b.id
                JOIN user c
                ON c.reg_no=b.creator
                JOIN usergroup d
                ON d.id=a.group_id
                JOIN user e
                ON e.reg_no = d.creator
                WHERE 
                b.name LIKE '%$search_params%'
                OR
                d.name LIKE '%$search_params%'
                OR
                c.first_name LIKE '%$search_params%'
                OR
                c.last_name LIKE '%$search_params%'
                OR 
                e.first_name LIKE '%$search_params%'
                OR
                e.last_name LIKE '%$search_params%'";


        return $this->paginate($sql, $start, $limit);
    }


    public function viewOnlyMyContentCollectionPermissions($search_params, $start, $limit)
    {
        $content_collection_permission_table = self::tableName();
        $content_collection_table = ContentCollection::tableName();
        $currentUser = Application::$app->user->reg_no;

        $sql = "SELECT a.*, b.name as collection_name, d.name as ug_name, c.first_name as collection_owner_fn, c.last_name as collection_owner_ln, e.first_name as ug_owner_fn, e.last_name as ug_owner_ln FROM $content_collection_permission_table a
                JOIN $content_collection_table b
                ON a.content_collection_id=b.id
                JOIN user c
                ON c.reg_no=b.creator
                JOIN usergroup d
                ON d.id=a.group_id
                JOIN user e
                ON e.reg_no = d.creator
                WHERE 
                b.creator = $currentUser
                AND
                d.creator = $currentUser
                AND
                (b.name LIKE '%$search_params%'
                OR
                d.name LIKE '%$search_params%'
                OR
                c.first_name LIKE '%$search_params%'
                OR
                c.last_name LIKE '%$search_params%'
                OR 
                e.first_name LIKE '%$search_params%'
                OR
                e.last_name LIKE '%$search_params%')";


        return $this->paginate($sql, $start, $limit);
    }

    public function removePermission($collection, $group)
    {
        $content_collection_permission_table = self::tableName();
        $content_collection_table = ContentCollection::tableName();
        $usergroup_table = userGroup::tableName();


        $permission = $this->findOne(['content_collection_id' => $collection, 'group_id' => $group]);

        if (Application::getUserRole() === 3) {

            // Check wheather the user own content collection and user group. Then he should be the one who creates this permission. 
            $sql = "SELECT b.creator as collection_creator, c.creator as ug_creator FROM content_collection_permission a
                    JOIN content_collection b
                    ON a.content_collection_id=b.id
                    JOIN usergroup c
                    ON a.group_id=c.id
                    WHERE 
                    a.content_collection_id = $collection
                    AND
                    a.group_id = $group";
            $statement = self::prepare($sql);
            $statement->execute();
            $res = $statement->fetch(PDO::FETCH_OBJ);

            if ($res) {
                if (Application::$app->user->reg_no != $res->collection_creator || Application::$app->user->reg_no != $res->ug_creator) return false;
            } else {
                return false;
            }
        }

        if ($permission) {
            $sql = "DELETE FROM $content_collection_permission_table WHERE content_collection_id=$collection AND group_id=$group";
            $statement = self::prepare($sql);
            return $statement->execute();
        } else {
            return false;
        }
    }
}

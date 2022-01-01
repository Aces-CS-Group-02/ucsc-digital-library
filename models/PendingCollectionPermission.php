<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use Exception;

class PendingCollectionPermission extends DbModel
{
    public int $collection_id;
    public int $group_id;
    public $permission;

    public static function tableName(): string
    {
        return 'collection_permission_pending';
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
        return ['collection_id' => [self::RULE_REQUIRED], 'group_id' => [self::RULE_REQUIRED], 'permission' => [self::RULE_REQUIRED]];
    }

    public function updatePermission()
    {
        $tableName = self::tableName();
        $sql = "UPDATE $tableName SET permission = $this->permission WHERE collection_id = $this->collection_id AND group_id = $this->group_id";
        $statement = self::prepare($sql);
        return $statement->execute();
    }

    public function getAllRequests($start, $limit)
    {
        $pending_collection_permission_table = self::tableName();
        $collection_table = Collection::tableName();
        $usergroup_table = UserGroup::tableName();
        $user_table = User::tableName();

        $sql = "SELECT a.*, b.name as collection_name, b.description as collection_description, b.community_id,c.name as ug_name, c.description as ug_description, d.first_name as ug_owner_fn, d.last_name as ug_owner_ln
                FROM $pending_collection_permission_table a
                JOIN $collection_table b
                ON a.collection_id=b.collection_id
                JOIN $usergroup_table c
                ON a.group_id=c.id
                JOIN $user_table d
                ON c.creator=d.reg_no
             ";
        return $this->paginate($sql, $start, $limit);
    }


    public function removeRequest($content_collection_id, $group_id)
    {
        $tableName = self::tableName();
        $sql = "DELETE FROM $tableName WHERE collection_id = $content_collection_id AND group_id = $group_id";
        $statement = self::prepare($sql);
        $statement->execute();
    }

    public function approve($collection_id, $group_id)
    {
        $req = $this->findOne(['collection_id' => $collection_id, 'group_id' => $group_id]);
        if (!$req) return false;

        $collectionPermissionModel = new CollectionPermission();
        $collectionPermissionModel->loadData($req);
        if (!$collectionPermissionModel->validate()) return false;

        $permission = $collectionPermissionModel->findOne(['collection_id' => $collection_id, 'group_id' => $group_id]);


        try {
            Application::$app->db->pdo->beginTransaction();
            if ($permission) {
                $collectionPermissionModel->updatePermission();
                $this->removeRequest($collection_id, $group_id);
            } else {
                $collectionPermissionModel->save();
                $this->removeRequest($collection_id, $group_id);
            }
            Application::$app->db->pdo->commit();
            return true;
        } catch (Exception $e) {
            Application::$app->db->pdo->rollBack();
            return false;
        }
    }


    public function reject($collection_id, $group_id)
    {
        $req = $this->findOne(['collection_id' => $collection_id, 'group_id' => $group_id]);
        if (!$req) return false;

        try {
            Application::$app->db->pdo->beginTransaction();
            $this->removeRequest($collection_id, $group_id);
            Application::$app->db->pdo->commit();
            return true;
        } catch (Exception $e) {
            Application::$app->db->pdo->rollBack();
            return false;
        }
    }
}

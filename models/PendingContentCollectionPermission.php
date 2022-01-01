<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use Exception;

class PendingContentCollectionPermission extends DbModel
{
    public int $content_collection_id;
    public int $group_id;
    public $permission;

    public static function tableName(): string
    {
        return 'content_collection_permission_pending';
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

    public function getAllRequests($start, $limit)
    {
        $pending_content_collection_permission_table = self::tableName();
        $content_collection_table = ContentCollection::tableName();
        $usergroup_table = UserGroup::tableName();
        $user_table = User::tableName();

        $sql = "SELECT 
                    a.*, 
                    b.name as collection_name, 
                    c.first_name as collection_owner_fn, c.last_name as collection_owner_ln,
                    d.name as ug_name,
                    e.first_name as ug_owner_fn, e.last_name as ug_owner_ln
                FROM $pending_content_collection_permission_table a
                JOIN content_collection b
                ON b.id = a.content_collection_id
                JOIN $user_table c
                ON b.creator = c.reg_no
                JOIN $usergroup_table d
                ON d.id = a.group_id
                JOIN $user_table e
                ON d.creator = e.reg_no";
        return $this->paginate($sql, $start, $limit);
    }


    public function removeRequest($content_collection_id, $group_id)
    {
        $tableName = self::tableName();
        $sql = "DELETE FROM $tableName WHERE content_collection_id = $content_collection_id AND group_id = $group_id";
        $statement = self::prepare($sql);
        $statement->execute();
    }

    public function approve($content_collection_id, $group_id)
    {

        $req = $this->findOne(['content_collection_id' => $content_collection_id, 'group_id' => $group_id]);
        if (!$req) return false;

        $contentCollectionPermissionModel = new ContentCollectionPermission();
        $contentCollectionPermissionModel->loadData($req);
        if (!$contentCollectionPermissionModel->validate()) return false;

        $permission = $contentCollectionPermissionModel->findOne(['content_collection_id' => $content_collection_id, 'group_id' => $group_id]);


        try {
            Application::$app->db->pdo->beginTransaction();
            if ($permission) {
                $contentCollectionPermissionModel->updatePermission();
                $this->removeRequest($content_collection_id, $group_id);
            } else {
                $contentCollectionPermissionModel->save();
                $this->removeRequest($content_collection_id, $group_id);
            }
            Application::$app->db->pdo->commit();
            return true;
        } catch (Exception $e) {
            Application::$app->db->pdo->rollBack();
            return false;
        }
    }


    public function reject($content_collection_id, $group_id)
    {
        $req = $this->findOne(['content_collection_id' => $content_collection_id, 'group_id' => $group_id]);
        if (!$req) return false;

        try {
            Application::$app->db->pdo->beginTransaction();
            $this->removeRequest($content_collection_id, $group_id);
            Application::$app->db->pdo->commit();
            return true;
        } catch (Exception $e) {
            Application::$app->db->pdo->rollBack();
            return false;
        }
    }
}

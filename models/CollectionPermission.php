<?php

namespace app\models;

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

    public function getAccessPermissionOnCollections()
    {
        $collection_permission_table = self::tableName();
        $sql = "SELECT * FROM $collection_permission_table";

        $statement = self::prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_OBJ);

        $arr = [];
        foreach ($data as $item) {
            $collection_id = $item->collection_id;
            $group_id = $item->group_id;
            $permission = $item->permission;

            $usergroupModel = new userGroup();
            $usergroup = $usergroupModel->findOne(['id' => $group_id]);

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
            $dataObj->group_id = $group_id;
            $dataObj->collection = $collection_path_str;
            $dataObj->group = $usergroup->name;

            switch ($permission) {
                case 1:
                    $permission_name = 'Read Only';
                    break;
                case 2:
                    $permission_name = 'Read/Download';
                    break;
                case 3:
                    $permission_name = 'Block';
                    break;
            }

            $dataObj->permission = $permission_name;


            array_push($arr, $dataObj);
        }

        return $arr;
    }

    public function removeCollectionPermission($collection_id, $group_id)
    {
        $collection_permission_table = self::tableName();
        $sql = "DELETE FROM $collection_permission_table WHERE collection_id=$collection_id AND group_id=$group_id";
        $statement = self::prepare($sql);
        return $statement->execute();
    }
}

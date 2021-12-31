<?php

namespace app\models;

use app\core\DbModel;



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
}

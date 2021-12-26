<?php


namespace app\models;

use app\core\DbModel;

class UsergroupApproved extends DbModel
{

    public int $group_id;
    public int $performer;

    public static function tableName(): string
    {
        return 'usergroup_approved';
    }

    public static function primaryKey(): string
    {
        return 'group_id';
    }

    public function attributes(): array
    {
        return ['group_id', 'performer'];
    }

    public function rules(): array
    {
        return ['group_id' => [self::RULE_REQUIRED], 'performer' => [self::RULE_REQUIRED]];
    }
}

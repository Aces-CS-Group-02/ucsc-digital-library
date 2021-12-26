<?php


namespace app\models;

use app\core\DbModel;

class UsergroupReject extends DbModel
{

    public int $group_id;
    public string $msg;
    public int $performer;

    public static function tableName(): string
    {
        return 'usergroup_reject';
    }

    public static function primaryKey(): string
    {
        return 'group_id';
    }

    public function attributes(): array
    {
        return ['group_id', 'msg', 'performer'];
    }

    public function rules(): array
    {
        return ['msg' => [self::RULE_REQUIRED]];
    }
}

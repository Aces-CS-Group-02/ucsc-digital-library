<?php

namespace app\models;

use app\core\DbModel;
use PDO;

class UserCollection extends DbModel
{
    public int $reg_no;
    public int $user_collection_id;
    public string $name;

    public static function tableName(): string
    {
        return "user_collection";
    }

    public function attributes(): array
    {
        return ['name', 'reg_no'];
    }

    public static function primaryKey(): string
    {
        return 'user_collection_id';
    }

    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]]
        ];
    }
}

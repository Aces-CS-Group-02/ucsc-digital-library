<?php

namespace app\models;

use app\core\DbModel;

class Role extends DbModel
{
    public int $role_id = 0;
    public string $name = "";
    public string $description = "";

    public static function tableName(): string
    {
        return "role";
    }

    public function attributes(): array
    {
        return ["role_id", "name", "description"];
    }

    public static function primaryKey(): string
    {
        return "role_id";
    }

    public function rules(): array
    {
        return [
            "name" => [self::RULE_REQUIRED, [self::RULE_UNIQUE,'class'=>self::class]],
            "description" => [self::RULE_REQUIRED]
        ];
    }
}
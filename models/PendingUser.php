<?php

namespace app\models;

use app\core\DbModel;

class PendingUser extends DbModel
{
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $token = '';

    public static function tableName(): string
    {
        return "pending_user";   
    }

    public function attributes(): array
    {
        return ["first_name","last_name","email","token"];
    }

    public static function primaryKey(): string
    {
        return "pending_user_id";
    }

    public function rules(): array
    {
        return [
            'first_name' => [self::RULE_REQUIRED],
            'last_name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL]
        ];
    }

    public function save()
    {
        return parent::save();
    }

}
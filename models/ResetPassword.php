<?php

namespace app\models;

use app\core\DbModel;
use app\core\Model;

class ResetPassword extends DbModel
{
    public int $reset_id = 0;
    public string $email = "";
    public string $token = "";
    public string $password = "";
    public string $confirm_password = "";

    public static function tablename(): string
    {
        return "reset_password";
    }

    public function attributes(): array
    {
        return ["reset_id","email","token"];
    }

    public static function primaryKey(): string
    {
        return "reset_id";
    }

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_EMAIL_EXIST, 'class' => User::class]],
            'password' => [self::RULE_REQUIRED, [self::RULE_PASS_MIN, 'min' => 8], [self::RULE_PASS_MAX, 'max' => 16]],
            'confirm_password' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
        ];
    }


}

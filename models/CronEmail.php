<?php

namespace app\models;

use app\core\DbModel;

class CronEmail extends DbModel
{
    public ?string $email = null;
    public ?string $token = null;

    public static function tableName(): string
    {
        return 'cron_emails';
    }

    public function attributes(): array
    {
        return ['email','token'];
    }

    public static function primaryKey(): string
    {
        return 'email';
    }

    public function rules(): array
    {
        return [];
    }


}
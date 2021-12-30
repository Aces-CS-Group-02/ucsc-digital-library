<?php

namespace app\models;

use app\core\DbModel;

class UserApproval extends DbModel{
    public int $user_approval_id = 0;
    public string $email = '';
    public bool $is_approved = false;
    public string $reason = '';
    public string $time = '';
    public string $approved_by ='';

    public static function tableName(): string
    {
        return "user_approval_status";
    }

    public function attributes(): array
    {
        return ['email', 'is_approved', 'reason', 'approved_by'];
    }

    public static function primaryKey(): string
    {
        return 'user_approval_id';
    }

    public function rules(): array
    {
        return [];
    }

    public function save()
    {
        return parent::save();
    }

}
<?php

namespace app\models;

use app\core\DbModel;
use PDO;

class UserApproval extends DbModel{
    public int $user_approval_id = 0;
    public string $email = '';
    public bool $is_approved = false;
    public string $reason = '';
    public string $time = '';
    public int $approved_by = 0;

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

    public function getApprovedUsers($start, $limit)
    {
        $tableName = self::tableName();
        $sql = "SELECT * FROM $tableName WHERE is_approved = 1";
        return $this->paginate($sql, $start, $limit);
    }

    public function getRejectedUsers($start, $limit)
    {
        $tableName = self::tableName();
        $sql = "SELECT * FROM $tableName WHERE is_approved = 0";
        return $this->paginate($sql, $start, $limit);
    }

    public function getApprovedCount()
    {
        $tableName = self::tableName();
        $sql = "SELECT COUNT(*) FROM $tableName WHERE is_approved = 1";
        $statement = self::prepare($sql);
        $statement->execute();
        return $statement->fetch();
    }

    public function getRejectedCount()
    {
        $tableName = self::tableName();
        $sql = "SELECT COUNT(*) FROM $tableName WHERE is_approved = 0";
        $statement = self::prepare($sql);
        $statement->execute();
        return $statement->fetch();
    }
}
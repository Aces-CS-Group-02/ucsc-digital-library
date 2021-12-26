<?php

namespace app\models;

use app\core\DbModel;

class ContentCollection extends DbModel
{
    public int $id;
    public string $name;
    public string $description;
    public int $creator;
    public int $status;
    public $created_date;

    public static function tableName(): string
    {
        return 'content_collection';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return ['name', 'description', 'creator', 'status', 'created_date'];
    }

    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED],
            'creator' => [self::RULE_REQUIRED],
            'status' => [self::RULE_REQUIRED]
        ];
    }
}

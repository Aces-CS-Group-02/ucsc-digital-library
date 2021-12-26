<?php

namespace app\models;

use app\core\DbModel;

class ContentType extends DbModel
{
    public static function tableName(): string
    {
        return 'content_type';
    }

    public function attributes(): array
    {
        return ['name'];
    }

    public static function primaryKey(): string
    {
        return 'content_type_id';
    }

    public function rules(): array
    {
        return [];
    }
}
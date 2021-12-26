<?php

namespace app\models;

use app\core\DbModel;

class ContentLanguage extends DbModel
{
    public static function tableName(): string
    {
        return 'content_language';
    }

    public function attributes(): array
    {
        return ['language'];
    }

    public static function primaryKey(): string
    {
        return 'language_id';
    }

    public function rules(): array
    {
        return [];
    }
}
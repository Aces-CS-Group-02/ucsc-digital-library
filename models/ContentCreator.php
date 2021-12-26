<?php

namespace app\models;

use app\core\DbModel;

class ContentCreator extends DbModel
{

    public int $content_id = 0;
    public string $creator = '';

    public static function tableName(): string
    {
        return 'content_creator';
    }

    public function attributes(): array
    {
        return ['content_id','creator'];
    }

    public static function primaryKey(): string
    {
        return 'content_id'; //this is not the correct primary key
    }

    public function rules(): array
    {
        return [];
    }
}
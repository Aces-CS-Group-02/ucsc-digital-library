<?php 

namespace app\models;

use app\core\DbModel;

class ContentKeyword extends DbModel
{
    public static function tableName(): string
    {
        return 'content_keyword';
    }

    public static function primaryKey(): string
    {
        return 'content_id'; //this is not the correct primary key
    }

    public function attributes(): array
    {
        return ['content_id','keyword'];
    }

    public function rules(): array
    {
        return [];
    }
}
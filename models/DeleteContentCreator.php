<?php 

namespace app\models;

use app\core\DbModel;

class DeleteContentCreator extends DbModel
{
    public static function tableName(): string
    {
        return 'delete_content_creator';
    }

    public function attributes(): array
    {
        return ['name'];
    }

    public static function primaryKey(): string
    {
        return 'creator_id';
    }

    public function rules(): array
    {
        return [];
    }
}
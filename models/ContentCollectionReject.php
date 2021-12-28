<?php


namespace app\models;

use app\core\DbModel;

class ContentCollectionReject extends DbModel
{
    public int $content_collection_id;
    public string $msg;
    public int $performer;

    public static function tableName(): string
    {
        return 'content_collection_reject';
    }

    public static function primaryKey(): string
    {
        return 'content_collection_id';
    }

    public function attributes(): array
    {
        return ['content_collection_id', 'msg', 'performer'];
    }

    public function rules(): array
    {
        return ['msg' => [self::RULE_REQUIRED]];
    }
}

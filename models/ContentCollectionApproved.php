<?php

namespace app\models;

use app\core\DbModel;

class ContentCollectionApproved extends DbModel
{

    public int $collection_id;
    public int $performer;

    public static function tableName(): string
    {
        return 'content_collection_approved';
    }

    public static function primaryKey(): string
    {
        return 'collection_id';
    }

    public function attributes(): array
    {
        return ['collection_id', 'performer'];
    }

    public function rules(): array
    {
        return ['collection_id' => [self::RULE_REQUIRED], 'performer' => [self::RULE_REQUIRED]];
    }
}

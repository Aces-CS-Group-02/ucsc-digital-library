<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use LengthException;
use PDO;

class DeleteContent extends DbModel
{

    public ?string $title = null;
    public ?string $subject =  null;
    public $date = null;
    public ?int $language = null;
    public ?int $type = null;
    public ?int $publish_state = null;
    public ?string $url = null;
    public ?int $collection_id = null;
    public int $upload_steps = 0;
    public ?string $isbn = null;
    public ?string $abstract = null;
    public ?string $publisher = null;

    public static function tableName(): string
    {
        return "delete_content";
    }

    public function attributes(): array
    {
        return ['title', 'subject', 'date', 'language', 'type', 'publish_state', 'url', 'collection_id', 'upload_steps', 'isbn', 'abstract', 'publisher'];
    }

    public static function primaryKey(): string
    {
        return "delete_content_id";
    }

    public function rules(): array
    {
        return [];
    }
}



<?php

namespace app\models;

use app\core\Model;

class Metadata extends Model 
{
    public ?string $creator = null;
    public ?string $title = null;
    public ?string $subject = null;
    public $date = null;
    public ?int $language = null;
    public ?int $type = null;
    public ?string $publisher = null;
    public ?string $isbn = null;

    public function rules(): array
    {
        return [
            'creator' => [self::RULE_REQUIRED],
            'title' => [self::RULE_REQUIRED],
            'subject' => [self::RULE_REQUIRED]
        ];
    }
}
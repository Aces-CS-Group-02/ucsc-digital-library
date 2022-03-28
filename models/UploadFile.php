<?php

namespace app\models;

use app\core\Model;

class UploadFile extends Model
{
    public string $file;
    
    public function rules(): array
    {
        return [
            'file' => [self::RULE_REQUIRED]
        ];
    }
}
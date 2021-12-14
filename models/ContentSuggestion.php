<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;

class ContentSuggestion extends DbModel{
    public int $reg_no = 0;
    public int $content_request_id = 0;
    public string $title = '';
    public string $creator = '';
    public string $isbn = '';
    public string $information = '';

    public static function tableName(): string
    {
        return "content_request";
    }

    public function attributes(): array
    {
        return ['reg_no', 'title', 'creator', 'isbn', 'information'];
    }

    public static function primaryKey(): string
    {
        return 'content_request_id';
    }

    public function rules(): array
    {
        return [
            'title' => [self::RULE_REQUIRED],
            'creator' => [self::RULE_REQUIRED]
        ];
    }

    public function createContentSuggestion($data)
    {
        $this->loadData($data);
        $this->reg_no = Application::$app->user->reg_no;

        if ($this->validate() && $this->save()) {
            return true;
        }
        return false;
    }
}
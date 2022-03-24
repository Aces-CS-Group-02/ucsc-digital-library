<?php

namespace app\models;

use app\core\DbModel;

class ContentSubmissionStatus extends DbModel{
    public int $id = 0;
    public int $content_id = 0;
    public bool $is_approved = false;
    public string $reason = '';
    public string $time = '';
    public int $approved_by = 0;

    public static function tableName(): string
    {
        return "content_submission_status";
    }

    public function attributes(): array
    {
        return ['content_id', 'is_approved', 'reason', 'approved_by'];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        return [];
    }

    public function save()
    {
        return parent::save();
    }
}
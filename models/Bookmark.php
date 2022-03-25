<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;

class Bookmark extends DbModel
{
    public int $bookmark_id = 0;
    public int $page_no = 0;
    public int $content_id = 0;
    public int $reg_no = 0;

    public static function tableName(): string
    {
        return "bookmark";
    }

    public function attributes(): array
    {
        return ['page_no', 'content_id', 'reg_no'];
    }

    public static function primaryKey(): string
    {
        return 'bookmark_id';
    }

    public function rules(): array
    {
        return [];
    }

    public function saveBookmark($data)
    {
        $this->loadData($data);
        $this->reg_no = Application::$app->user->reg_no;
        if ($this->save()) {
            return true;
        }
        return false;
    }

    public function removeUserBookmark($pageNo, $contentId, $reg_no)
    {
        $tableName = self::tableName();
        $statement = self::prepare("DELETE FROM $tableName WHERE page_no=$pageNo AND content_id=$contentId AND reg_no=$reg_no");
        return $statement->execute();
    }
}

<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;

class Note extends DbModel
{
    public int $note_id = 0;
    public string $note = '';
    public int $content_id = 0;
    public int $reg_no = 0;

    public static function tableName(): string
    {
        return "note";
    }

    public function attributes(): array
    {
        return ['note', 'content_id', 'reg_no'];
    }

    public static function primaryKey(): string
    {
        return 'note_id';
    }

    public function rules(): array
    {
        return [];
    }

    public function saveNote($data)
    {
        $this->loadData($data);
        $this->reg_no = Application::$app->user->reg_no;
        if ($this->save()) {
            return true;
        }
        return false;
    }

    public function UpdateNote($note,$noteId)
    {
        $tableName = self::tableName();
        $sql = "UPDATE $tableName set note = '$note' WHERE note_id = $noteId";
        $statement = self::prepare($sql);
        // echo $sql;
        return $statement->execute();
    }
}

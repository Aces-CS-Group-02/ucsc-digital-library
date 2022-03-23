<?php
namespace app\models;

use app\core\DbModel;

class DeleteContentBy extends DbModel{

    public $delete_content_id = 0;
    public string $deleted_by = '';


    public static function tableName(): string
    {
        return 'delete_content_by';
    }
    public function attributes(): array
    {
        return['deleted_by'];
    }
    public static function primaryKey(): string
    {
        return 'delete_content_id';
    } 
    public function rules(): array
    {
        return [];
    }
    public function save(){
        return parent::save();
    }

}


<?php
namespace app\models;

use app\core\DbModel;

class DeleteUsers extends DbModel{

    public $delete_user_id = 0;
    public string $email = '';
    public string $reason = '';
    public string $deleted_by = '';


    public static function tableName(): string
    {
        return 'delete_user';
    }
    public function attributes(): array
    {
        return['email','reason', 'deleted_by'];
    }
    public static function primaryKey(): string
    {
        return 'delete_user_id';
    } 
    public function rules(): array
    {
        return [];
    }
    public function save(){
        return parent::save();
    }

}

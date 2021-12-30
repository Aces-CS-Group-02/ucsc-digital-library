<?php 

namespace app\models;

use app\core\DbModel;

class ContentPublishStateChange extends DbModel
{
    public  $state_change_id = 0;
    public string $reason = '';
    public string $changed_by = '';
    

    public static function tableName(): string
    {
        return 'content_publish_state_change';
    }

    public function attributes(): array
    {
        return ['content_id', 'changed_by', '$reason'];
    }

    public static function primaryKey(): string
    {
        return '$state_change_id'; 
    }

    public function rules(): array
    {
        return [];
    }
    public function save(){
        return parent::save();
    }


}
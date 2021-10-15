<?php 

namespace app\models;

use app\core\Model;

class ResetPassword extends Model
{
    public string $email = "";

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL]
        ];
    }

    
}
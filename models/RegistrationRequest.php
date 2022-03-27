<?php

namespace app\models;

use app\core\DbModel;

class RegistrationRequest extends DbModel
{
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $message = '';
    public $verification = '';

    public static function tableName(): string
    {
        return "registration_request";
    }

    public function attributes(): array
    {
        return ["first_name", "last_name", "email", "verification", "message"];
    }

    public static function primaryKey(): string
    {
        return "request_id";
    }

    public function rules(): array
    {
        return [
            'first_name' => [self::RULE_REQUIRED],
            'last_name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            'verification' => [self::RULE_REQUIRED]
        ];
    }

    public function save()
    {
        // $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }
    public function getUserDetails($request_id)
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName WHERE request_id = $request_id");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getAllNewUsers($search_params, $start, $limit)
    {
        // var_dump($search_params);
        $tableName = self::tableName();
        $sql = "SELECT * FROM registration_request             
                WHERE CONCAT(first_name,' ',last_name)  LIKE '%$search_params%'";
        return $this->paginate($sql, $start, $limit);
    }

}
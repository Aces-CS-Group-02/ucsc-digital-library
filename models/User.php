<?php

namespace app\models;

use app\core\DbModel;

class User extends DbModel
{
    public int $reg_no = 0;
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $password = '';
    public int $attempt_count = 0;
    public string $confirm_password = '';
    public int $role_id = 0;

    public static function tableName(): string
    {
        return "user";
    }

    public function attributes(): array
    {
        return ["first_name", "last_name", "email", "password", "role_id", "attempt_count"];
    }

    public static function primaryKey(): string
    {
        return "reg_no";
    }

    public function rules(): array
    {

        return [
            'first_name' => [self::RULE_REQUIRED],
            'last_name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            'password' => [self::RULE_REQUIRED, [self::RULE_PASS_MIN, 'min' => 8], [self::RULE_PASS_MAX, 'max' => 16]],
            'confirm_password' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
        ];
    }

    public function upgradeToLIA()
    {
        // Set role_id to Library Information Assistant Role ID here
        $this->role_id = 3;
        if ($this->role_id == 3) {
            return true;
        } else {
            return false;
        }
    }


    public function removeLIA()
    {
        // Set role_id to Library Information Assistant Role ID here
        $this->role_id = 0;
        if ($this->role_id == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update($updateRequiredFileds)
    {
        $tableName = static::tableName();

        $temp = [];
        foreach ($updateRequiredFileds as $field) {
            array_push($temp, $field . '="' . $this->{$field} . '"');
        }
        $temp = implode(", ", $temp);

        $statement = self::prepare("UPDATE $tableName SET $temp WHERE reg_no = $this->reg_no");

        return $statement->execute();
    }


    public function save()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }
}

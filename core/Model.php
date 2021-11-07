<?php

namespace app\core;

abstract class Model
{

    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_PASS_MIN = 'min';
    public const RULE_PASS_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';
    public const RULE_UNIQUE_FROM_PENDING = 'uniquefrompending';
    public const RULE_EMAIL_EXIST = 'exist';

    public array $errors = [];

    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;

    private function addErrorForRule($attribute, $rule, $params = [])
    {
        $errorMessage = $this->errorMessages()[$rule] ?? "";
        foreach ($params as $key => $value) {
            $errorMessage = str_replace("{" . $key .  "}", $value, $errorMessage);
        }
        $this->errors[$attribute][] = $errorMessage;
    }

    public function addError(string $attribute, string $errorMessage)
    {
        $this->errors[$attribute][] = $errorMessage;
    }

    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED => "This field is required",
            self::RULE_EMAIL => "This must be a valid email",
            self::RULE_PASS_MIN => "Password must contain at least {min} characters",
            self::RULE_PASS_MAX => "Password cannot contain more than {max} characters",
            self::RULE_MATCH => "This field must match with {match}",
            self::RULE_UNIQUE => "Record with this {filed} already exists",
            self::RULE_UNIQUE_FROM_PENDING => "This {filed} already exists in pending list",
            self::RULE_EMAIL_EXIST => "User with the given {field} does not exist"
        ];
    }

    public function hasErrors($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function validate($statement_spec = "")
    {

        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};

            foreach ($rules as $rule) {

                $ruleName = $rule;

                if (!is_string($ruleName)) {
                    $ruleName = $ruleName[0];
                }

                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }

                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }

                if ($ruleName === self::RULE_PASS_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorForRule($attribute, self::RULE_PASS_MIN, $rule);
                }

                if ($ruleName === self::RULE_PASS_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorForRule($attribute, self::RULE_PASS_MAX, $rule);
                }

                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $Statement =  Application::$app->db->pdo->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr $statement_spec");
                    $Statement->bindValue(":attr", $value);
                    $Statement->execute();
                    $record = $Statement->fetchObject();
                    if ($record) {
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['filed' => $attribute]);
                    }
                }
                if ($ruleName === self::RULE_EMAIL_EXIST && filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $Statement =  Application::$app->db->pdo->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr $statement_spec");
                    $Statement->bindValue(":attr", $value);
                    $Statement->execute();
                    $record = $Statement->fetchObject();
                    if (!$record) {
                        $this->addErrorForRule($attribute, self::RULE_EMAIL_EXIST, ['field' => $attribute]);
                    }
                }
                if ($ruleName === self::RULE_UNIQUE_FROM_PENDING) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $Statement =  Application::$app->db->pdo->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr $statement_spec");
                    $Statement->bindValue(":attr", $value);
                    $Statement->execute();
                    $record = $Statement->fetchObject();
                    if ($record) {
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE_FROM_PENDING, ['filed' => $attribute]);
                    }
                }
            }
        }

        return empty($this->errors);


        // echo "Validate Errors" . "</br>";
        // echo '<pre>';
        // var_dump($this->errors);
        // echo '</pre>';
    }
}

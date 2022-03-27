<?php

namespace app\models;

use app\core\DbModel;
use PDO;

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
    public string $log_in_time = '';

    public static function tableName(): string
    {
        return "user";
    }

    public function attributes(): array
    {
        return ["first_name", "last_name", "email", "password", "role_id", "attempt_count", "log_in_time"];
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
        $lia_role_id = 2;

        $this->role_id = $lia_role_id;
        if ($this->role_id == $lia_role_id) {
            return true;
        } else {
            return false;
        }
    }


    public function removeLIA()
    {
        // Set back role_id to Academic-non academic staff member's role_id
        $acc_non_acc_role_id = 3;

        $this->role_id = $acc_non_acc_role_id;
        if ($this->role_id == $acc_non_acc_role_id) {
            return true;
        } else {
            return false;
        }
    }

    public function updateLIA($updateRequiredFileds)
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

    public function getAllStudents()
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName WHERE role_id IN(4, 5)");
        $statement->execute();
        return $statement->fetchAll();
    }
    public function getAllUsers($search_params, $start, $limit)
    {
        $tableName = self::tableName();
        $sql = "SELECT * FROM user              
                         WHERE CONCAT(first_name,' ',last_name) LIKE '%$search_params%'";
        return $this->paginate($sql, $start, $limit);
    }


    public function update()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::update();
    }

    public function setRoleId()
    {
        $email = $this->email;
        $roleName = "External User";
        $studentEmailPattern = "/(.*)@(stu.ucsc.cmb.ac.lk|stu.ucsc.lk)/";
        $staffEmailPattern = "/(.*)@(ucsc.cmb.ac.lk)/";

        if (preg_match($studentEmailPattern, $email)) {
            $roleName = "UCSC Student";
        } else if (preg_match($staffEmailPattern, $email)) {
            $roleName = "UCSC Staff";
        }

        $role = new Role();

        $where = [
            'name' => $roleName
        ];

        $role = $role->findOne($where);

        return $role->role_id;
    }

    public function getAllLibraryStaffMember()
    {
        $tableName = self::tableName();
        $sql = "SELECT reg_no FROM $tableName WHERE role_id IN(1,2)";
        $statement = self::prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateLogInTime($value)
    {
        // echo $value;
        $tableName = self::tableName();
        $sql = "UPDATE $tableName set log_in_time = now() WHERE email = '$value'";
        $statement = self::prepare($sql);
        // echo $sql;
        return $statement->execute();
    }

    public function getLogInDate($value)
    {
        // echo $value;
        $tableName = self::tableName();
        $sql = "SELECT DATE(log_in_time) FROM $tableName WHERE email = '$value'";
        $statement = self::prepare($sql);
        // echo $sql;
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUsersOrderedByLoginTime($search_params = '', $start, $limit)
    {
        $tableName = self::tableName();
        $sql = "SELECT * FROM $tableName ORDER BY log_in_time DESC";

        if ($search_params != '') $sql = "SELECT * FROM $tableName WHERE (first_name LIKE '%$search_params%' OR last_name LIKE '%$search_params%') ORDER BY log_in_time DESC";
        // $statement = self::prepare($sql);
        // $statement->execute();
        // return $statement->fetchAll(PDO::FETCH_OBJ);

        return $this->paginate($sql, $start, $limit);
    }
}

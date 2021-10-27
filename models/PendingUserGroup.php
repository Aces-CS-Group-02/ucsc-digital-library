<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;

class PendingUserGroup extends DbModel
{
    public int $group_id;
    public string $name;
    public int $creator_reg_no;
    public bool $completed_status = false;

    public static function tableName(): string
    {
        return 'pending_usergroup';
    }

    public function attributes(): array
    {
        return ['name', 'creator_reg_no', 'completed_status'];
    }

    public static function primaryKey(): string
    {
        return 'group_id';
    }

    public function rules(): array
    {

        return [
            'name' => [self::RULE_REQUIRED, [self::RULE_UNIQUE_FROM_PENDING, 'class' => self::class]],
        ];
    }

    public function createPendingUserGroup($data)
    {
        $tempUserGroupModel = new UserGroup();
        $tempUserGroupModel->loadData($data);
        $this->loadData($data);

        $statement_spec = 'AND creator_type = 0';
        $this->creator_reg_no = Application::$app->user->reg_no;

        if ($tempUserGroupModel->validate($statement_spec) && $this->validate()) {
            if (Application::getUserRole() === 3) {
                if ($this->save()) return true;
            }
        }
        return false;
    }
}

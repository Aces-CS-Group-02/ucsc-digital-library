<?php

namespace app\models;

use app\core\DbModel;

class NotificationReceiver extends DbModel
{

    public int $notification_id;
    public int $receiver;
    public bool $view_status;

    public static function tableName(): string
    {
        return 'notification_receiver';
    }

    public static function primaryKey(): string
    {
        return "";
    }

    public function attributes(): array
    {
        return ['notification_id', 'receiver', 'view_status'];
    }

    public function rules(): array
    {
        return ['notification_id' => [self::RULE_REQUIRED], 'receiver' => [self::RULE_REQUIRED]];
    }

    public function setMultipleReceviers($notification_id, $receivers)
    {
        $notification_receiver_table = self::tableName();

        $temp = array();
        foreach ($receivers as $receiver) {
            array_push($temp, "($notification_id, $receiver, FALSE)");
        }

        $temp = implode(",", $temp);

        $sql = "INSERT INTO $notification_receiver_table (`notification_id`, `receiver`, `view_status`) VALUES ";

        $sql = $sql . $temp;

        $statement = self::prepare($sql);
        return $statement->execute();
    }
}

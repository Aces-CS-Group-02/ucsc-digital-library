<?php


namespace app\models;

use app\core\Application;
use app\core\DbModel;
use PDO;
use stdClass;

class Notification extends DbModel
{
    public int $id;
    public string $msg;
    public $timestamp;

    public static function tableName(): string
    {
        return 'notification';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return ['msg'];
    }

    public function rules(): array
    {
        return ['msg' => [self::RULE_REQUIRED]];
    }

    public function getNotifications()
    {

        $defaultDisplayNotificationsCount = 10;

        $notification_table = self::tableName();
        $notification_receiver_table = NotificationReceiver::tableName();

        $currentUser = Application::$app->user->reg_no;

        // New notifications
        $sql = "SELECT msg, DATE(timestamp) as date, TIME(timestamp) as time 
                FROM $notification_table n
                JOIN $notification_receiver_table r ON n.id=r.notification_id
                WHERE receiver=$currentUser
                AND view_status = FALSE
                ORDER BY timestamp DESC";

        $statement = self::prepare($sql);
        $statement->execute();
        $newNotifications = $statement->fetchAll(PDO::FETCH_OBJ);

        $notifications = new stdClass;
        $notifications->newNotificationsCount = count($newNotifications);
        $notifications->newNotifications = $newNotifications;


        if ($notifications->newNotificationsCount < $defaultDisplayNotificationsCount) {
            $count = $defaultDisplayNotificationsCount - $notifications->newNotificationsCount;

            // old notifications to fill default display notification count
            $sql = "SELECT msg, DATE(timestamp) as date, TIME(timestamp) as time 
                FROM $notification_table n
                JOIN $notification_receiver_table r ON n.id=r.notification_id
                WHERE receiver=$currentUser
                AND view_status = TRUE
                ORDER BY timestamp DESC
                LIMIT $count";
            $statement = self::prepare($sql);
            $statement->execute();
            $oldNotifications = $statement->fetchAll(PDO::FETCH_OBJ);

            $notifications->oldNotificationsCount = count($oldNotifications);
            $notifications->oldNotifications = $oldNotifications;
        } else {
            $notifications->oldNotificationsCount = 0;
            $notifications->oldNotifications = [];
        }

        return $notifications;
    }

    public function openNotification()
    {
        $currentUser = Application::$app->user->reg_no;
        $notification_table = self::tableName();
        $notification_receiver_table = NotificationReceiver::tableName();



        $sql = "SELECT receiver FROM $notification_table n
                JOIN $notification_receiver_table r ON r.notification_id=n.id
                WHERE receiver=$currentUser AND view_status=FALSE";
        $statement = self::prepare($sql);
        $statement->execute();
        $notifications = $statement->fetchAll(PDO::FETCH_OBJ);

        if (empty($notifications)) return false;

        $str = '';

        foreach ($notifications as $notification) {
            $str = $str . "," . $notification->receiver;
        }

        $str = ltrim($str, ',');
        $str = "IN(" . $str . ")";

        $sql = "UPDATE $notification_receiver_table SET view_status=TRUE WHERE receiver $str";
        $statement = self::prepare($sql);
        $res = $statement->execute();

        return $res;
    }
}

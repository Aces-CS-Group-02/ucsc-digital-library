<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use Exception;

class ContentSubmissionStatus extends DbModel
{
    public int $id = 0;
    public int $content_id = 0;
    public bool $is_approved = false;
    public string $reason = '';
    public string $time = '';
    public int $approved_by = 0;

    public static function tableName(): string
    {
        return "content_submission_status";
    }

    public function attributes(): array
    {
        return ['content_id', 'is_approved', 'reason', 'approved_by'];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        return [];
    }

    public function save()
    {
        return parent::save();
    }

    // public function approve($contentId, $reason)
    // {
    //     $notificationModel = new Notification();
    //     $notificationModel->loadData(['msg' => "Your submission is aprroved by library staff"]);
    //     if (!$notificationModel->validate()) return false;
    //     $notificationReceiverModel = new NotificationReceiver();


    //     $where = [
    //         "content_id" => $contentId
    //     ];
    //     $contents = new Content;
    //     $content = $contents->findOne($where);

    //     if ($content) {
    //         $contentSubmissionStatus = new ContentSubmissionStatus();
    //         $contentSubmissionStatus->content_id = $content->content_id;
    //         $contentSubmissionStatus->is_approved = true;
    //         $contentSubmissionStatus->reason = $reason;
    //         $contentSubmissionStatus->approved_by = Application::$app->user->reg_no;

    //         try {
    //             Application::$app->db->pdo->beginTransaction();
    //             $this->save();
    //             $contents->UpdateApprovedState($content->content_id);
    //             $notificationReceiverModel->setMultipleReceviers(Application::$app->db->pdo->lastInsertId(), $staff_members_list);
    //             Application::$app->db->pdo->commit();
    //             return true;
    //         } catch (Exception $e) {
    //             Application::$app->db->pdo->rollBack();
    //             return false;
    //         }
    //     }
    // }
}

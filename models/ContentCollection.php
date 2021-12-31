<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use Exception;
use PDO;

class ContentCollection extends DbModel
{
    public int $id;
    public string $name;
    public string $description;
    public int $creator;
    public int $status;
    public $created_date;

    public static function tableName(): string
    {
        return 'content_collection';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return ['name', 'description', 'creator', 'status', 'created_date'];
    }

    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED],
            'creator' => [self::RULE_REQUIRED],
            'status' => [self::RULE_REQUIRED]
        ];
    }


    public function createUserGroup($data)
    {
        $this->loadData($data);
        $this->creator = Application::$app->user->reg_no;

        if (Application::getUserRole() <= 2) {
            $this->status = 1;
        } else {
            $this->status = 3;
        }

        if ($this->validate()) {
            if ($this->save()) return Application::$app->db->pdo->lastInsertId();
            return true;
        }
        return false;
    }


    public function getAllContentsNotInThisGroup($collection_id, $search_params, $start, $limit)
    {
        $content_table = Content::tableName();
        $content_collection_content_tale = ContentCollectionContent::tableName();

        $sql = "SELECT * FROM content t1
                WHERE 
                t1.content_id NOT IN(SELECT content_id FROM content_collection_content WHERE collection_id = $collection_id) 
                AND publish_state = 1
                AND (t1.title LIKE '%$search_params%')";

        return $this->paginate($sql, $start, $limit);
    }



    public function pushContentsToContentCollection($collection_id, $content_list)
    {
        // If group not exist return false
        if (!$this->findOne(['id' => $collection_id])) return false;
        $contentModel = new Content();
        $contentCollectionContentModel = new ContentCollectionContent();

        $content_list_validated = array();

        foreach ($content_list as $content) {
            if ($contentModel->findOne(['content_id' => $content]) && !$contentCollectionContentModel->findOne(['collection_id' => $collection_id, 'content_id' => $content])) array_push($content_list_validated, $content);
        }

        // var_dump($users_list_validated);

        if ($contentCollectionContentModel->addContents($collection_id, $content_list_validated)) return true;
        return false;
    }



    public function pushContentToContentCollection($collection_id, $content_id)
    {
        $contentModel = new Content();
        // If group not exist return false
        if (!$this->findOne(['id' => $collection_id])) return false;

        //  If user id not exist return false
        if (!$contentModel->findOne(['content_id' => $content_id])) return false;

        $contentCollectionContentModel = new ContentCollectionContent();

        if ($contentCollectionContentModel->addContent($collection_id, $content_id)) return true;
        return false;
    }

    public function getAllContentsInContentCollection($collection_id, $search_params, $start, $limit)
    {
        $content_table = Content::tableName();
        $content_collection_content_tale = ContentCollectionContent::tableName();

        $sql = "SELECT * FROM content t1
                WHERE 
                t1.content_id IN(SELECT content_id FROM content_collection_content WHERE collection_id = $collection_id) 
                AND (t1.title LIKE '%$search_params%')";

        return $this->paginate($sql, $start, $limit);
    }




    public function requestApproval($content_collection_id)
    {

        $content_collection = $this->findOne(['id' => $content_collection_id]);
        $currentUser = Application::$app->user->reg_no;

        if (!$content_collection) return false;

        // var_dump($group);

        if ($content_collection->status == 3 && $content_collection->creator == $currentUser) {
            $this->loadData($content_collection);
            $this->status = 2;

            $userModel = new User();
            $staffMembers = $userModel->getAllLibraryStaffMember();
            $staff_members_list = array();
            foreach ($staffMembers as $staffMember) {
                array_push($staff_members_list, $staffMember->reg_no);
            }


            $notificationModel = new Notification();
            $notificationModel->loadData(['msg' => "New pending content collection is available"]);
            if (!$notificationModel->validate()) return false;
            $notificationReceiverModel = new NotificationReceiver();

            try {
                Application::$app->db->pdo->beginTransaction();
                $this->update();
                $notificationModel->save();
                $notificationReceiverModel->setMultipleReceviers(Application::$app->db->pdo->lastInsertId(), $staff_members_list);
                Application::$app->db->pdo->commit();
            } catch (Exception $e) {
                Application::$app->db->pdo->rollBack();
            }
        }
    }


    public function getAllContentCollections($search_params = '', $start, $limit)
    {

        $creator = Application::$app->user->reg_no;
        $tableName = self::tableName();



        if (Application::getUserRole() <= 2) {
            $sql = "SELECT g.*, u.first_name, u.last_name FROM $tableName g
                    JOIN user u on u.reg_no = g.creator
                    WHERE status=1";

            if ($search_params != '') $sql = $sql . " AND (name LIKE '%$search_params%' OR first_name LIKE '%$search_params%' OR last_name LIKE '%$search_params%')";
        } else if (Application::getUserRole() === 3) {
            $sql = "SELECT g.*, u.first_name, u.last_name FROM $tableName g
                    JOIN user u on u.reg_no = g.creator
                    WHERE creator=$creator AND g.status != 4";

            if ($search_params != '') $sql = $sql . " AND name LIKE '%$search_params%'";
        } else {
            return false;
        }



        return $this->paginate($sql, $start, $limit);
    }


    public function removeContentCollection($content_collection_id)
    {
        $content_collection_table = self::tableName();
        $primaryKey = self::primaryKey();

        $user = Application::$app->user->reg_no;

        $content_collection = $this->findOne(['id' => $content_collection_id]);

        if (!$content_collection) return false;
        if (Application::getUserRole() === 3 && $user != $content_collection->creator) return false;

        $statement = self::prepare("DELETE FROM $content_collection_table WHERE $primaryKey = $content_collection_id");
        return $statement->execute();
    }



    public function getAllRequests($search_params, $start, $limit)
    {
        $content_collection_table = self::tableName();
        $userTable = User::tableName();
        $sql = "SELECT DATE(g.created_date) as created_date,  g.id, g.name, g.description, u.first_name, u.last_name FROM 
                $content_collection_table g 
                JOIN $userTable u ON g.creator = u.reg_no 
                WHERE status = 2
                AND (g.name LIKE '%$search_params%' 
                OR u.first_name LIKE '%$search_params%' 
                OR u.last_name LIKE '%$search_params%')";

        return $this->paginate($sql, $start, $limit);
    }


    public function approve($content_collection_id)
    {
        $content_collection = $this->findOne(['id' => $content_collection_id]);
        if (!$content_collection) return false;

        $this->loadData($content_collection);
        $this->status = 1;

        $currentUser = Application::$app->user->reg_no;
        $contentCollectionApprovedModel = new ContentCollectionApproved();
        $contentCollectionApprovedModel->loadData(['collection_id' => $content_collection->id, 'performer' => $currentUser]);
        if (!$contentCollectionApprovedModel->validate()) return false;


        var_dump($contentCollectionApprovedModel);

        $notificationModel = new Notification();
        $notificationModel->loadData(['msg' => "Your usergroup $content_collection->name is approved by library staff."]);
        if (!$notificationModel->validate()) return false;
        $notificationReceiverModel = new NotificationReceiver();

        var_dump($notificationModel);

        try {
            Application::$app->db->pdo->beginTransaction();
            $this->update();
            $contentCollectionApprovedModel->save();
            $notificationModel->save();

            $notificationReceiverModel->loadData(['notification_id' => Application::$app->db->pdo->lastInsertId(), 'receiver' => $content_collection->creator, 'view_status' => false]);
            if (!$notificationReceiverModel->validate()) return false;

            $notificationReceiverModel->save();

            Application::$app->db->pdo->commit();
            return true;
        } catch (Exception $e) {
            Application::$app->db->pdo->rollBack();
            return false;
        }
    }


    public function reject($collection_id, $msg)
    {
        $request = $this->findOne(['id' => $collection_id]);


        if (!$request) return false;

        $this->loadData($request);
        $this->status = 4;

        $contentCollectionRejectModel = new ContentCollectionReject();
        $currentUser = Application::$app->user->reg_no;
        $contentCollectionRejectModel->loadData(['content_collection_id' => $collection_id, 'msg' => $msg, 'performer' => $currentUser]);
        if (!$contentCollectionRejectModel->validate()) return false;


        // Notification
        $notificationModel = new Notification();
        $notificationModel->loadData(['msg' => "Your content collection $request->name is rejected by library staff because of $msg "]);
        if (!$notificationModel->validate()) return false;
        $notificationReceiverModel = new NotificationReceiver();


        try {
            Application::$app->db->pdo->beginTransaction();
            $this->update();

            $contentCollectionRejectModel->save();

            $notificationModel->save();

            $notificationReceiverModel->loadData(['notification_id' => Application::$app->db->pdo->lastInsertId(), 'receiver' => $request->creator, 'view_status' => false]);
            if (!$notificationReceiverModel->validate()) return false;
            var_dump($notificationReceiverModel);

            $notificationReceiverModel->save();

            Application::$app->db->pdo->commit();
            return true;
        } catch (Exception $e) {
            Application::$app->db->pdo->rollBack();
            return false;
        }
    }


    public function browserContentCollections($search_params, $start, $limit)
    {
        $currentUserRole = Application::getUserRole();
        $currentUser = Application::$app->user->reg_no;

        if ($currentUserRole <= 2) {
            $sql = "SELECT a.*, b.first_name, b.last_name FROM content_collection a
                    JOIN user b ON a.creator = b.reg_no
                    WHERE status = 1 AND name LIKE '%$search_params%'";
        } else if ($currentUserRole == 3) {
            $sql = "SELECT a.*, b.first_name, b.last_name FROM content_collection a
                    JOIN user b ON a.creator = b.reg_no
                    WHERE status = 1 AND creator = '$currentUser' AND name LIKE '%$search_params%'";
        }
        return $this->paginate($sql, $start, $limit);
    }

    public function loadContentCollection($id)
    {
        $sql = "SELECT a.*, b.first_name, b.last_name FROM 
                content_collection a
                JOIN user b ON a.creator = b.reg_no
                WHERE a.id = $id";
        $statement = self::prepare($sql);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_OBJ);
    }
}

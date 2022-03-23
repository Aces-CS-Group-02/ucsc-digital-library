<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use LengthException;
use PDO;

class Content extends DbModel
{

    public ?string $title = null;
    public ?string $subject =  null;
    public $date = null;
    public ?int $language = null;
    public ?int $type = null;
    public ?int $publish_state = null;
    public ?string $url = null;
    public ?string $thumbnail = null;
    public ?int $collection_id = null;
    public int $upload_steps = 0;
    public ?string $isbn = null;
    public ?string $abstract = null;
    public ?string $publisher = null;
    public ?int $uploaded_by = null;
    public int $approved = 0;


    public static function tableName(): string
    {
        return "content";
    }

    public function attributes(): array
    {
        return ['title', 'subject', 'date', 'language', 'type', 'publish_state', 'url', 'thumbnail', 'collection_id', 'upload_steps', 'isbn', 'abstract', 'publisher', 'uploaded_by', 'approved'];
    }

    public static function primaryKey(): string
    {
        return "content_id";
    }

    public function rules(): array
    {
        return [];
    }
    public function getAllUnpublishContent($search_params, $start, $limit)
    {
        $tableName = static::tableName();

        $sql = "SELECT content_id, title, date 
                                    FROM content              
                                    WHERE publish_state = 0 
                                    AND title LIKE '%$search_params%'";

        return $this->paginate($sql, $start, $limit);
    }
    public function getAllPublishContent($search_params, $start, $limit)
    {
        $tableName = self::tableName();
        $sql = "SELECT content_id, title, date 
                                    FROM content               
                                    WHERE publish_state = 1
                                    AND title LIKE '%$search_params%'";


        return $this->paginate($sql, $start, $limit);
    }
    public function getInfoUnpublishedContent($content_id)
    {
        $tableName = self::tableName();

        $statement = self::prepare("SELECT content.content_id, content.title, content.date, content.subject,  content.isbn, content.abstract, content.publisher,
                                    content_language.language, content_type.name as type_name
                                    FROM content 
                                    LEFT JOIN content_language ON content.language = content_language.language_id
                                    LEFT JOIN content_type ON content.type = content_type.content_type_id               
                                    WHERE publish_state = 0 AND content.content_id = $content_id");
        $statement->execute();
        return $statement->fetch(PDO::FETCH_OBJ);
    }
    public function getInfoPublishedContent($content_id)
    {
        $tableName = self::tableName();

        $statement = self::prepare("SELECT content.content_id, content.title, content.date, content.subject,  content.isbn, content.abstract, content.publisher,
                                    content_language.language, content_type.name as type_name
                                    FROM content 
                                    LEFT JOIN content_language ON content.language = content_language.language_id
                                    LEFT JOIN content_type ON content.type = content_type.content_type_id               
                                    WHERE publish_state = 1 AND content.content_id = $content_id");
        $statement->execute();
        return $statement->fetch(PDO::FETCH_OBJ);
    }
    public function doPublishContent($content_id)
    {
        $tableName = self::tableName();
        $statement = self::prepare("UPDATE content 
                                    SET publish_state = 1
                                    WHERE content_id = $content_id");

        return $statement->execute();
    }
    public function doUnpublishContent($content_id)
    {
        $tableName = self::tableName();
        $statement = self::prepare("UPDATE content 
                                    SET publish_state = 0
                                    WHERE content_id = $content_id");

        return $statement->execute();
    }
    public function doDraftContent($content_id)
    {
        $tableName = self::tableName();
        $statement = self::prepare("SELECT content_id, upload_steps
                                    FROM content 
                                    WHERE content_id = $content_id
                                    AND upload_steps<=4");

        return $statement->execute();


    }
    public function deleteContent($content_id)
    {
        $tableName = self::tableName();
        $statement = self::prepare("DELETE FROM content
                                    WHERE content_id = $content_id");

        return $statement->execute();
    }
    public function getAllContent($search_params, $start, $limit)
    {
        $tableName = self::tableName();
        $sql = "SELECT content.content_id, content.title, content.date,content.publish_state, content_type.name as type_name
                                    FROM content  
                                    LEFT JOIN content_type ON content.type = content_type.content_type_id             
                                    WHERE title LIKE '%$search_params%'";
        return $this->paginate($sql, $start, $limit);
    }

    public function getAllUnapprovedContent($search_params, $start, $limit)
    {
        $tableName = static::tableName();
        $sql = "SELECT *
                FROM content              
                WHERE title LIKE '%$search_params%' AND approved=0";
        return $this->paginate($sql, $start, $limit);
    }

    public function getInfoContent($content_id)
    {
        $tableName = self::tableName();

        $statement = self::prepare("SELECT content.content_id, content.title, content.date, content.subject,  content.isbn, content.abstract, content.publisher,
                                content_language.language, content_type.name as type_name
                                FROM content 
                                LEFT JOIN content_language ON content.language = content_language.language_id
                                LEFT JOIN content_type ON content.type = content_type.content_type_id               
                                WHERE content.content_id = $content_id");
        $statement->execute();
        return $statement->fetch(PDO::FETCH_OBJ);
    }
    public function browseByDateIssued($start, $limit, $year, $month, $order, $rpp, $collections)
    {
        $bindData = [];

        $year_filter = '';
        if ($year && (int)$year >= 0 && (int)$year <= (int)date('Y')) {
            $year_filter = "AND YEAR(a.date) = ?";
            array_push($bindData, ['value' => $year, 'type' => PDO::PARAM_INT]);
        }

        $month_filter = '';
        if ($month && $month >= 1 && $month <= 12) {
            $month_filter = "AND MONTH(a.date) = ?";
            array_push($bindData, ['value' => $month, 'type' => PDO::PARAM_INT]);
        }

        if (strtoupper($order) == 'ASC' || strtoupper($order) == 'DESC') {
            $order = strtoupper($order);
        } else {
            $order = 'DESC';
        }

        if (!empty($collections)) {
            $collections = implode(',', $collections);
            $collections_property = "AND collection_id IN($collections)";
        } else {
            $collections_property = "";
        }

        $sql = "SELECT a.*, GROUP_CONCAT(creator) as creators
                FROM content a
                JOIN content_creator b
                ON a.content_id = b.content_id
                WHERE
                a.publish_state = 1
                $collections_property
                $year_filter
                $month_filter
                GROUP BY a.content_id
                ORDER BY a.date $order";


        return $this->paginate2($sql, $bindData, $start, $limit);
    }

    public function browseByTitle($start, $limit, $starts_with, $order, $rpp, $collections)
    {
        $bindData = [];

        if ($starts_with && $starts_with == 100) {
            $str = "AND a.title LIKE CONCAT(? , '%')";
            array_push($bindData, ['value' => '[0-9]', 'type' => PDO::PARAM_STR]);
        } else if ($starts_with && $starts_with >= 65 && $starts_with <= 91) {
            $str = "AND a.title LIKE CONCAT(? , '%')";
            array_push($bindData, ['value' => chr($starts_with), 'type' => PDO::PARAM_STR_CHAR]);
        } else {
            $str = '';
        }

        if (strtoupper($order) == 'ASC' || strtoupper($order) == 'DESC') {
            $order = strtoupper($order);
        } else {
            $order = 'ASC';
        }

        if (!empty($collections)) {
            $collections = implode(',', $collections);
            $collections_property = "AND collection_id IN($collections)";
        } else {
            $collections_property = "";
        }

        $sql = "SELECT a.*, GROUP_CONCAT(creator) as creators
                FROM content a
                JOIN content_creator b
                ON a.content_id = b.content_id
                WHERE
                a.publish_state = 1
                $collections_property
                $str
                GROUP BY a.content_id
                ORDER BY a.title $order";

        return $this->paginate2($sql, $bindData, $start, $limit);
    }

    public function getAllContents($collections, $start, $limit)
    {
        $temp = implode(',', $collections);


        if ($temp != "") {
            $sql = "SELECT * FROM content WHERE collection_id IN ($temp)";
            return $this->paginate($sql, $start, $limit);
        }


        // $bindData = ['value' => $collections, 'type' => PDO::PARAM_STR];

        // return $this->paginate2($sql, $bindData, 0, 1000);

    }

    public function browseCommunity($type, $collections, $browseParams, $start, $limit)
    {
        $temp = implode(',', $collections);

        switch ($type) {
            case "dateissued":

                $bindData = [];

                $year = $browseParams->year;
                $month = $browseParams->month;
                $order = $browseParams->order;

                $year_filter = '';
                if ($year && (int)$year >= 0 && (int)$year <= (int)date('Y')) {
                    $year_filter = "AND YEAR(a.date) = ?";
                    array_push($bindData, ['value' => $year, 'type' => PDO::PARAM_INT]);
                }


                $month_filter = '';
                if ($month && $month >= 1 && $month <= 12) {
                    $month_filter = "AND MONTH(a.date) = ?";
                    array_push($bindData, ['value' => $month, 'type' => PDO::PARAM_INT]);
                }

                if (strtoupper($order) == 'ASC' || strtoupper($order) == 'DESC') {
                    $order = strtoupper($order);
                } else {
                    $order = 'DESC';
                }

                if ($temp != "") {
                    $sql = "SELECT a.*, GROUP_CONCAT(creator) as creators
                            FROM content a
                            JOIN content_creator b
                            ON a.content_id = b.content_id
                            WHERE 
                            collection_id IN ($temp)
                            AND
                            a.publish_state = 1
                            $year_filter
                            $month_filter
                            GROUP BY a.content_id
                            ORDER BY a.date $order";

                    return $this->paginate2($sql, $bindData, $start, $limit);
                } else {
                    return false;
                }
                break;
        }
    }

    public function UpdateApprovedState($content_id)
    {
        $tableName = self::tableName();
        $sql = "UPDATE $tableName set approved = 1 WHERE content_id = $content_id";
        $statement = self::prepare($sql);
        // echo $sql;
        return $statement->execute();
    }

    public function getLatestContents()
    {
        $tableName = self::tableName();
        $statement = self::prepare("SELECT content_id, title FROM content ORDER BY time_stamp LIMIT 8");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function getContentNotesInProfile($content_id)
    {
        $user_id = Application::$app->user->reg_no;
        $tableName = self::tableName();
        $statement = self::prepare("SELECT note.content_id, content.title, 
                                    FROM note 
                                    INNER JOIN content
                                    ON note.content_id = content.content_id
                                    WHERE reg_no = user_id AND LIMIT 5 ");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
    public function getAllContentNotes($content_id)
    {
        $user_id = Application::$app->user->reg_no;
        $tableName = self::tableName();
        $statement = self::prepare("SELECT note.content_id, content.title, 
                                    FROM note 
                                    INNER JOIN content
                                    ON note.content_id = content.content_id
                                    WHERE reg_no = user_id");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
    // public function getMySubmissions($search_params, $start, $limit)
    // {
    //     $tableName = self::tableName();
    //     $sql = "SELECT content_id, ";
    // }
 }

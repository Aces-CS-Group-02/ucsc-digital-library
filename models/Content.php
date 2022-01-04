<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
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
    public ?int $collection_id = null;
    public int $upload_steps = 0;
    public ?string $isbn = null;
    public ?string $abstract = null;
    public ?string $publisher = null;

    public static function tableName(): string
    {
        return "content";
    }

    public function attributes(): array
    {
        return ['title', 'subject', 'date', 'language', 'type', 'publish_state', 'url', 'collection_id', 'upload_steps', 'isbn', 'abstract', 'publisher'];
    }

    public static function primaryKey(): string
    {
        return "content_id";
    }

    public function rules(): array
    {
        return [];
    }

    public function browseByDateIssued($start, $limit, $year, $month, $order, $rpp)
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

        $sql = "SELECT a.*, GROUP_CONCAT(creator) as creators
                FROM content a
                JOIN content_creator b
                ON a.content_id = b.content_id
                WHERE
                a.publish_state = 1
                $year_filter
                $month_filter
                GROUP BY a.content_id
                ORDER BY a.date $order";

        return $this->paginate2($sql, $bindData, $start, $limit);
    }

    public function browseByTitle($start, $limit, $starts_with, $order, $rpp)
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

        $sql = "SELECT a.*, GROUP_CONCAT(creator) as creators
                FROM content a
                JOIN content_creator b
                ON a.content_id = b.content_id
                WHERE
                a.publish_state = 1
                $str
                GROUP BY a.content_id
                ORDER BY a.title $order";

        return $this->paginate2($sql, $bindData, $start, $limit);
    }
}

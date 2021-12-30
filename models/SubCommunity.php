<?php

namespace app\models;

use app\core\DbModel;
use PDO;

class SubCommunity extends DbModel
{

    public $parent_community_id = '';
    public $child_community_id = '';


    public static function tableName(): string
    {
        return "sub_community";
    }

    public function attributes(): array
    {
        return ['parent_community_id', 'child_community_id'];
    }

    public static function primaryKey(): string
    {
        return "community_id, Subcommunity_id";
    }

    public function rules(): array
    {
        return [];
    }


    // public function getAllSubCommunities($where)
    // {

    //     $tableName = static::tableName();
    //     $attributes = array_keys($where);
    //     $sql = implode(" AND ", array_map(fn ($attr) => "$attr = :$attr", $attributes));


    //     $statement = self::prepare("SELECT child_community_id FROM $tableName WHERE $sql");


    //     foreach ($where as $key => $item) {
    //         $statement->bindValue(":$key", $item);
    //     }


    //     $statement->execute();
    //     return $statement->fetchAll(PDO::FETCH_OBJ);
    // }


    public function getAllSubCommunities($community_id, $start, $limit)
    {

        $subcommunity_table = self::tableName();
        $community_table = Community::tableName();

        $sql = "SELECT * FROM 
                $community_table c
                JOIN (SELECT child_community_id FROM 
                      $community_table c
                      JOIN $subcommunity_table s ON s.parent_community_id = c.community_id
                      WHERE s.parent_community_id=$community_id) t ON t.child_community_id=c.community_id";
        return $this->paginate($sql, $start, $limit);
    }



    public static function getSubcommunitiesCount($community_id)
    {
        $tableName = self::tableName();
        $statement = self::prepare("SELECT COUNT(child_community_id) AS count
                                    FROM $tableName
                                    WHERE parent_community_id = $community_id");
        $statement->execute();
        return $statement->fetch(PDO::FETCH_OBJ);
    }
}

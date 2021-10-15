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


    public function getAllSubCommunities($where)
    {

        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn ($attr) => "$attr = :$attr", $attributes));


        $statement = self::prepare("SELECT child_community_id FROM $tableName WHERE $sql");


        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }


        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
}

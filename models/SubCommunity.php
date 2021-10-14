<?php

namespace app\models;

use app\core\DbModel;
use PDO;

class SubCommunity extends DbModel
{

    public $parent_id = '';
    public $child_id = '';


    public static function tableName(): string
    {
        return "communityhassubcommunity";
    }

    public function attributes(): array
    {
        return ['ParentID', 'ChildID'];
    }

    public static function primaryKey(): string
    {
        return "CommunityID, SubCommunityID";
    }

    public function rules(): array
    {
        return [];
    }


    public function getAllSubCommunities($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(fn ($attr) => "$attr = :$attr", $attributes));

        $statement = self::prepare("SELECT child_id FROM $tableName WHERE $sql");

        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }


        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
}

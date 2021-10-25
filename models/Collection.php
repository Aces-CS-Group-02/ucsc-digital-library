<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use app\core\exception\NotFoundException;
use app\core\Request;
use Exception;
use PDO;

class Collection extends DbModel
{
    public int $collection_id;
    public string $name;
    public string $description;
    public int $community_id;

    public static function tableName(): string
    {
        return "collection";
    }

    public function attributes(): array
    {
        return ['name', 'description', 'community_id'];
    }

    public static function primaryKey(): string
    {
        return 'collection_id';
    }

    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]]
        ];
    }

    public function getAllCollections($community_id)
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT collection_id, name, description 
                                    FROM $tableName 
                                    WHERE community_id = $community_id");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function createNewCollection($data)
    {
        $communityModel = new Community();
        if (!$communityModel->findCommunity($data['community-id'])) return false; //If community doesn't exist return false

        $this->loadData($data);
        $this->community_id = $data['community-id']; // Set community id

        $statement_spec = "AND community_id=" . $data['community-id'];

        if (!$this->validate($statement_spec)) return [false, $this]; // If validation error occurs return false, and also model

        return $this->save();
    }

    public function deleteCollection($collection_id)
    {
        $tableName = static::tableName();
        if ($this->findOne(['collection_id' => $collection_id])) {
            $statement = self::prepare("DELETE FROM $tableName WHERE " . self::primaryKey() . " = $collection_id");
            if ($statement->execute()) {
                echo 'success';
            } else {
                echo 'failed-1';
            }
        } else {
            echo 'failed-2';
        }
    }
}

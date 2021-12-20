<?php

namespace app\models;

use app\core\DbModel;
use PDO;
use app\core\Application;
use ErrorException;
use Exception;

class Community extends DbModel
{
    public $community_id = '';
    public string $name = "";
    public string $description = '';
    public $parent_community_id = null;

    public static function tableName(): string
    {
        return "community";
    }

    public function attributes(): array
    {
        return ['name', 'description', 'parent_community_id'];
    }

    public static function primaryKey(): string
    {
        return "community_id";
    }

    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]]
        ];
    }


    public function getAllTopLevelCommunities($start, $limit)
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName WHERE parent_community_id IS NULL LIMIT $start, $limit");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function createNewTopLevelCommunity($data)
    {
        // var_dump($data);


        if ($this->validate() && $this->save()) {
            echo "Done!!!";
            return true;
        }
        return false;
    }


    public function deleteCommunity($community_id)
    {
        $tableName = static::tableName();

        /* Statement_check cheks wheather the given community ID exsists in DB
           Then statement execute delete if Statement_check operation was success
        */

        $statement_check = self::prepare("SELECT * FROM $tableName WHERE community_id = $community_id");
        $statement_check->execute();
        if ($statement_check->fetchObject()) {
            $statement = self::prepare("DELETE FROM $tableName WHERE community_id = $community_id");
            return $statement->execute();
        } else {
            return false;
        };
    }

    public function loadCommunity($data)
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT community_id, name, description, parent_community_id FROM $tableName WHERE community_id = $data");
        $statement->execute();
        $result = $statement->fetchObject();


        if ($result) {
            $this->community_id = $result->community_id;
            $this->name = $result->name;
            $this->description = $result->description;
            $this->parent_community_id = $result->parent_community_id;
            return true;
        } else {
            return false;
        }
    }


    public function findCommunity($data)
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT community_id, name, description, parent_community_id FROM $tableName WHERE community_id = $data");
        $statement->execute();
        $result = $statement->fetchObject();
        return $result;
    }


    public function wantsToUpdate($data, $db_data)
    {

        // echo "Wants to update :";
        // echo '<pre>';
        // var_dump($data);
        // echo '</pre>';

        // echo "Wants to update : DB";
        // echo '<pre>';
        // var_dump($db_data);
        // echo '</pre>';

        // echo "wants to update" . $data;

        // $tableName = static::tableName();
        // $statement = self::prepare("SELECT name, description FROM $tablename WHERE community_id = $this->community_id");
        // $statement->execute();
        // $result = $statement->fetchObject();

        $updateRequiredFileds = [];

        // $this->community_id = $this->community_id;

        if ($data['name'] !== $db_data->name) {
            array_push($updateRequiredFileds, "name");
        }

        if ($data['description'] !== $db_data->description) {
            array_push($updateRequiredFileds, "description");
        }


        // if ($result->name !== $this->name) {
        //     array_push($updateRequiredFileds, "name");
        // }

        // if ($result->description !== $this->description) {
        //     array_push($updateRequiredFileds, "description");
        // }

        return $updateRequiredFileds;
    }


    public function updateCommunity($updateRequiredFileds)
    {
        $tableName = static::tableName();

        $temp = [];
        foreach ($updateRequiredFileds as $field) {
            array_push($temp, $field . '="' . $this->{$field} . '"');
        }
        $temp = implode(", ", $temp);

        $statement = self::prepare("UPDATE $tableName SET $temp WHERE community_id = $this->community_id ");

        return $statement->execute();
    }

    public function getCommunitiesByID($id_list)
    {
        $tableName = static::tableName();

        $idlist = implode(',', $id_list);

        $statement = self::prepare("SELECT * FROM $tableName WHERE community_id IN ($idlist)");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTopLevelCommunity($data)
    {
        $this->loadData($data);
        $statement_spec = "AND parent_community_id IS NULL";
        if ($this->validate($statement_spec) && $this->save()) {
            return true;
        }
        return false;
    }


    public function createSubCommunity(SubCommunity $subCommunityModel)
    {
        $subCommunityModel->parent_community_id = $this->parent_community_id;

        $tableName_1 = $this->tableName();
        $tableName_2 = "sub_community";

        $attributes_1 = $this->attributes();
        $params_1 = array_map(fn ($attr) => ":$attr", $attributes_1);

        // Transaction
        try {
            Application::$app->db->pdo->beginTransaction();
            $statement = self::prepare("INSERT INTO " . $tableName_1 . "(" . implode(',', $attributes_1) . ") VALUES(" . implode(',', $params_1) . ")");
            foreach ($attributes_1 as $attribute) {
                $statement->bindValue(":$attribute", $this->{$attribute});
            }
            $statement->execute();
            $last_inserted_id = Application::$app->db->pdo->lastInsertId();
            $statement2 = self::prepare("INSERT INTO $tableName_2 VALUES($this->parent_community_id, $last_inserted_id)");
            $statement2->execute();
            Application::$app->db->pdo->commit();
        } catch (Exception $e) {
            Application::$app->db->pdo->rollBack();
            return false;
        }

        return true;
    }

    public function communityBreadcrumGenerate($community_id)
    {
        $tableName = self::tableName();
        $statement = self::prepare("SELECT T2.community_id, T2.name
                                    FROM (
                                            SELECT
                                            @r AS _id,
                                            (SELECT @r := parent_community_id FROM $tableName WHERE community_id = _id) AS parent_community_id,
                                            @l := @l + 1 AS lvl
                                    FROM
                                            (SELECT @r := $community_id, @l := 0) vars,
                                            $tableName m
                                    WHERE @r <> 0) T1
                                    JOIN community T2
                                    ON T1._id = T2.community_id
                                    ORDER BY T1.lvl DESC");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPageCount($limit)
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName WHERE parent_community_id IS NULL");
        $statement->execute();
        return ceil($statement->rowCount() / $limit);
    }
}

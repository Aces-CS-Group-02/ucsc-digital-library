<?php

namespace app\models;

use app\core\DbModel;
use PDO;
use app\core\Application;
use ErrorException;
use Exception;

class Community extends DbModel
{
    public $CommunityID = '';
    public string $Name = "";
    public string $Description = '';
    public $ParentCommunityID = null;

    public static function tableName(): string
    {
        return "communities";
    }

    public function attributes(): array
    {
        return ['Name', 'Description', 'ParentCommunityID'];
    }

    public static function primaryKey(): string
    {
        return "CommunityID";
    }

    public function rules(): array
    {
        return [
            'Name' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]]
        ];
    }


    public function getAllTopLevelCommunities()
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName WHERE ParentCommunityID IS NULL");
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


    public function deleteCommunity($CommunityID)
    {
        $tableName = static::tableName();

        /* Statement_check cheks wheather the given community ID exsists in DB
           Then statement execute delete if Statement_check operation was success
        */

        $statement_check = self::prepare("SELECT * FROM $tableName WHERE CommunityID = $CommunityID");
        $statement_check->execute();
        if ($statement_check->fetchObject()) {
            $statement = self::prepare("DELETE FROM $tableName WHERE CommunityID = $CommunityID");
            return $statement->execute();
        } else {
            return false;
        };
    }

    public function loadCommunity($data)
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT CommunityID, Name, Description FROM $tableName WHERE CommunityID = $data");
        $statement->execute();
        $result = $statement->fetchObject();


        if ($result) {
            $this->CommunityID = $result->CommunityID;
            $this->Name = $result->Name;
            $this->Description = $result->Description;
            return true;
        } else {
            return false;
        }
    }


    public function findCommunity($data)
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT CommunityID, Name, Description, ParentCommunityID FROM $tableName WHERE CommunityID = $data");
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
        // $statement = self::prepare("SELECT Name, Description FROM $tableName WHERE CommunityID = $this->CommunityID");
        // $statement->execute();
        // $result = $statement->fetchObject();

        $updateRequiredFileds = [];

        // $this->CommunityID = $this->CommunityID;

        if ($data['Name'] !== $db_data->Name) {
            array_push($updateRequiredFileds, "Name");
        }

        if ($data['Description'] !== $db_data->Description) {
            array_push($updateRequiredFileds, "Description");
        }


        // if ($result->Name !== $this->Name) {
        //     array_push($updateRequiredFileds, "Name");
        // }

        // if ($result->Description !== $this->Description) {
        //     array_push($updateRequiredFileds, "Description");
        // }

        return $updateRequiredFileds;
    }


    public function update($updateRequiredFileds)
    {
        $tableName = static::tableName();

        $temp = [];
        foreach ($updateRequiredFileds as $field) {
            array_push($temp, $field . '="' . $this->{$field} . '"');
        }
        $temp = implode(", ", $temp);

        $statement = self::prepare("UPDATE $tableName SET $temp WHERE CommunityID = $this->CommunityID ");

        return $statement->execute();
    }

    public function getCommunitiesByID($id_list)
    {
        $tableName = static::tableName();

        $idlist = implode(',', $id_list);

        $statement = self::prepare("SELECT * FROM $tableName WHERE CommunityID IN ($idlist)");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    public function createSubCommunity(SubCommunity $subCommunityModel)
    {
        $subCommunityModel->parent_id = $this->ParentCommunityID;

        $tableName_1 = $this->tableName();
        $tableName_2 = "communityhassubcommunity";

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
            $statement2 = self::prepare("INSERT INTO $tableName_2 VALUES($this->ParentCommunityID, $last_inserted_id)");
            $statement2->execute();
            Application::$app->db->pdo->commit();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}

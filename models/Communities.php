<?php

namespace app\models;

use app\core\DbModel;
use PDO;

class Communities extends DbModel
{
    public string $CommunityID = '';
    public string $Name = '';
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
            'Name' => [self::RULE_REQUIRED]
        ];
    }

    public function getAllTopLevelCommunities()
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName WHERE ParentCommunityID IS NULL");
        $statement->execute();
        return $result = $statement->fetchAll();

        // echo '<pre>';
        // var_dump($result);
        // echo '</pre>';
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


    public function deleteCommunity($data)
    {
        $tableName = static::tableName();

        $statement_1 = self::prepare("SELECT * FROM $tableName WHERE CommunityID = $data");
        $statement_1->execute();
        if ($statement_1->fetchObject()) {
            $statement = self::prepare("DELETE FROM $tableName WHERE CommunityID = $data");
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

    public function wantsToUpdate($data)
    {
        // echo "wants to update" . $data;
        $tableName = static::tableName();
        $statement = self::prepare("SELECT Name, Description FROM $tableName WHERE CommunityID = $data");
        $statement->execute();
        $result = $statement->fetchObject();


        $updateRequiredFileds = [];

        $this->CommunityID = $data;


        if ($result->Name !== $this->Name) {
            array_push($updateRequiredFileds, "Name");
        }

        if ($result->Description !== $this->Description) {
            array_push($updateRequiredFileds, "Description");
        }

        return $updateRequiredFileds;
    }


    public function update($data, $updateRequiredFileds)
    {
        $tableName = static::tableName();

        $temp = [];
        foreach ($updateRequiredFileds as $field) {
            array_push($temp, $field . '="' . $this->{$field} . '"');
        }
        $temp = implode(", ", $temp);

        $statement = self::prepare("UPDATE $tableName SET $temp WHERE CommunityID = $this->CommunityID ");

        $statement->execute();
    }
}

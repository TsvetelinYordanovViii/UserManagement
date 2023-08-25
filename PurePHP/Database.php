<?php
include "User.php";

class Database {
    private $conn;

    public function connect ($servername, $database, $username, $password){
        try{
            $this->conn = new PDO("mysql:host=$servername; dbname=$database", $username, $password);
    
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //echo "Connection successful.";
        } catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function createRecord($tableColumns, $newValues){
        $columns = filter_var($tableColumns, FILTER_SANITIZE_STRING);
        $values = filter_var($newValues, FILTER_SANITIZE_STRING);

        //The column names will be predefined, so there is no security concern here.
        $createQuery = "
            INSERT INTO users (
                ($columns) VALUES (:values)
            )
        ";

        $createStm = $this->conn->prepare($createQuery);
        $createStm->bindParam(':values', $values);
        $createStm->execute();
    }

    public function readRecord($tableColumn, $whereColumn, $whereValue){
        //If no column is set, provide the * character.
        if (strlen($tableColumn) > 0){
            $columns = filter_var($tableColumn, FILTER_SANITIZE_STRING);
        }
        else{
            $columns = "*";
        }

        //If a where clause is defined, create a query with a where clause
        //else create a simple select query.
        if (strlen($whereColumn) > 0 && strlen($whereValue) > 0){
            $checkedColumn = filter_var($whereColumn, FILTER_SANITIZE_STRING);
            $checkedValue = filter_var($whereValue, FILTER_SANITIZE_STRING);

            $selectQuery = "
            SELECT $columns FROM users
            WHERE $checkedColumn = :checkedValue
            ";
            $selectStm = $this->conn->prepare($selectQuery);
            $selectStm->bindParam(':checkedValue', $checkedValue);
        }
        else{
            $selectQuery = "
            SELECT $columns FROM users
            ";
            $selectStm = $this->conn->prepare($selectQuery);
        }

        $selectStm->execute();
        
        return $selectStm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateRecord($tableColumn, $tableValue, $rowId){
        $column = filter_var($tableColumn, FILTER_SANITIZE_STRING);
        $value = filter_var($tableValue, FILTER_SANITIZE_STRING);
        $id = filter_var($rowId, FILTER_SANITIZE_STRING);
        
        //The column names will be predefined, so there is no security concern here.
        $selectQuery = "
            UPDATE users
            SET $column = :tableValue
            WHERE id = :id
        ";

        $selectStm = $this->conn->prepare($selectQuery);
        $selectStm->bindParam(':tableValue', $value);
        $selectStm->bindParam(':id', $id);
        $selectStm->execute();
    }

    public function deleteRecord($rowId){
        $id = filter_var($rowId, FILTER_SANITIZE_STRING);

        $deleteQuery = "
            DELETE FROM users
            WHERE id = :id
        ";

        $deleteStm = $this->conn->prepare($deleteQuery);
        $deleteStm->bindParam(':id', $id);
        $deleteStm->execute();
    }
}

?>
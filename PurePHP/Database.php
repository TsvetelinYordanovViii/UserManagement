<?php

class Database {
    private $conn;

    public Database ($servername, $username, $password){
        //Temporary. Maybe.
        $servername = "localhost";
        $username = "root";
        $password = "";

        $conn = new PDO("mysql:host=$servername; dbname=usermanagement", $username, $password);
    }

    public CreateTable($tableName, $tableRows, $database, $conn){
        $name = filter_var($tableName, FILTER_SANITIZE_STRING);
        $rows = filter_var($tableRows, FILTER_SANITIZE_STRING);
        $database = filter_var($database, FILTER_SANITIZE_STRING);

        $createQuery = "
            CREATE TABLE :database.:tableName (
                :tableRows
            )
        ";

        $create = $conn->prepare($createQuery);
        $create->bindParam(':database', $database);
        $create->bindParam(':tableName', $name);
        $create->bindParam(':tableRows', $rows);
        $create->execute();
    }

    public ReadTable($tableName, $tableRows, $conn){
        $name = filter_var($tableName, FILTER_SANITIZE_STRING);
        if (strlen($tableRows) > 0){
            $rows = filter_var($tableRows, FILTER_SANITIZE_STRING);
        }
        else{
            $rows = "*";
        }

        $selectQuery = "
            SELECT :tableRows FROM :tableName
        ";

        $select = $conn->prepare($selectQuery);
        $select->bindParam(':tableName', $name);
        $select->bindParam(':tableRows', $rows);
        $select->execute();
        
        return $select->fetchAll(PDO::FETCH_ASSOC);
    }

    public UpdateTable($tableName, $tableRow, $tableValue, $rowId){
        $name = filter_var($tableName, FILTER_SANITIZE_STRING);
        $row = filter_var($tableRow, FILTER_SANITIZE_STRING);
        $value = filter_var($tableValue, FILTER_SANITIZE_STRING);
        $id = filter_var($rowId, FILTER_SANITIZE_STRING);

        $selectQuery = "
            UPDATE :tableName
            SET :tableRow = :tableValue
            WHERE id = :id
        ";

        $select = $conn->prepare($selectQuery);
        $select->bindParam(':tableName', $name);
        $select->bindParam(':tableRow', $row);
        $select->bindParam(':tableValue', $value);
        $select->bindParam(':id', $id);
        $select->execute();
        
        return $select->fetchAll(PDO::FETCH_ASSOC);
    }

    public DeleteTable($tableRow, $rowId){
        $row = filter_var($tableRow, FILTER_SANITIZE_STRING);
        $id = filter_var($rowId, FILTER_SANITIZE_STRING);

        $deleteQuery = "
            DELETE :tableRow
            WHERE id = :id
        ";

        $delete = $conn->prepare($deleteQuery);
        $delete->bindParam(':tableRow', $row);
        $delete->bindParam(':id', $id);
        $delete->execute();
    }
}

?>
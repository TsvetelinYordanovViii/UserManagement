<?php

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

    public function createRecord($newValues){
        $values = filter_var($newValues, FILTER_SANITIZE_STRING);

        $createQuery = "
            INSERT INTO users (
                (username, email, role) VALUES (:values)
            )
        ";

        $createStm = $this->conn->prepare($createQuery);
        $createStm->bindParam(':values', $values);
        $createStm->execute();
    }

    public function readRecord($id){

        //If a where clause is defined, create a query with a where clause
        //else create a simple select query.
        if (strlen($id) > 0){
            $searchedId = filter_var($id, FILTER_SANITIZE_STRING);

            $selectQuery = "
            SELECT * FROM users
            WHERE id = :searchedId
            ";
            $selectStm = $this->conn->prepare($selectQuery);
            $selectStm->bindParam(':searchedId', $searchedId);
        }
        else{
            $selectQuery = "
            SELECT * FROM users
            ";
            $selectStm = $this->conn->prepare($selectQuery);
        }

        $selectStm->execute();
        
        return $selectStm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateRecord($username, $email, $role, $rowId){
        $newUsername = filter_var($username, FILTER_SANITIZE_STRING);
        $newEmail = filter_var($email, FILTER_SANITIZE_STRING);
        $newRole = filter_var($role, FILTER_SANITIZE_STRING);
        $id = filter_var($rowId, FILTER_SANITIZE_STRING);
        
        $selectQuery = "
            UPDATE users
            SET username = :newUsername, email = :newEmail, role = :newRole
            WHERE id = :id
        ";

        $selectStm = $this->conn->prepare($selectQuery);
        $selectStm->bindParam(':newUsername', $newUsername);
        $selectStm->bindParam(':newEmail', $newEmail);
        $selectStm->bindParam(':newRole', $newRole);
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
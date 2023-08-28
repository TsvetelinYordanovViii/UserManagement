<?php
include "User.php";
include "Database.php";

class UserManagement {

    public static function connect ($servername, $database, $username, $password){
        $db = new Database();
        $db->connect($servername, $database, $username, $password);
        return $db;
    }

    public static function addUser ($usernameField, $emailField, $roleField, $database){
        $username = filter_var($usernameField, FILTER_SANITIZE_STRING);
        $email = filter_var($emailField, FILTER_SANITIZE_STRING);
        $role = filter_var($roleField, FILTER_SANITIZE_STRING);

        $role = strtolower($role);

        if (empty($username) || empty($email) || empty($role)){
            return "At least one field is empty.";
        }
        else if ($role!="user" && $role!="admin"){
            return "Invalid user role.";
        }
        else if ((strpos($email, "@")!=strrpos($email, "@") && (strpos($email, ".")!=strrpos($email, "."))) || strpos($email, "@")==-1 || strpos($email, ".")==-1){
            return "Invalid email.";
        }
        else{
            $database->createRecord("$username, $email, $role");
            return "User added successfully.";
        }
    }

    public static function updateUser ($usernameField, $emailField, $roleField, $idField, $database){
        $username = filter_var($usernameField, FILTER_SANITIZE_STRING);
        $email = filter_var($emailField, FILTER_SANITIZE_STRING);
        $role = filter_var($roleField, FILTER_SANITIZE_STRING);
        $id = filter_var($idField, FILTER_SANITIZE_STRING);

        $foundUser = $database->readRecord($id);
        $role = strtolower($role);

        if (empty($username) || empty($email) || empty($role)){
            return "At least one field is empty.";
        }
        else if ($role!="user" && $role!="admin"){
            return "Invalid user role.";
        }
        else if ((strpos($email, "@")!=strrpos($email, "@") && (strpos($email, ".")!=strrpos($email, "."))) || strpos($email, "@")==-1 || strpos($email, ".")==-1){
            return "Invalid email.";
        }
        else if ($id > 0){
            return "Invalid ID.";
        }
        else if (sizeof($foundUser)>0){
            return "User doesn't exist.";
        }
        else{
            $database->updateRecord($username, $email, $role,  $id);
            return "User data updated successfully.";
        }
    }

    public static function findUser ($idField, $database){
        $id = filter_var($idField, FILTER_SANITIZE_STRING);

        if ($id > 1){
            $userData = $database->readRecord($id);

            if (sizeof($userData)>0){
                $output = array("User found. Data displayed on the Update User form.", $userData);
            }
            else{
                $output = array("User not found.", null);
            }
        }
        else{
            $output = array("Invalid ID.", null);
        }
        return $output;
    }

    public static function deleteUser ($idField, $database){
        $id = filter_var($idField, FILTER_SANITIZE_STRING);

        if ($id > 1){
            $foundUser = $database->readRecord($id);
            if (sizeof($foundUser)>0){
                $database->deleteRecord($id);
                return "User deleted.";
            }
            else{
                return "User doesn't exist.";
            }
        }
        else{
            return "Invalid ID.";
        }
    }

}

?>
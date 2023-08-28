<?php
include "User.php";
include "Database.php";

class UserManagement {

    public static function connect ($servername, $database, $username, $password){
        $db = new Database();
        $db->connect($servername, $database, $username, $password);
        return $db;
    }

    public static function addUser ($usernameField, $emailField, $roleField){
        $username = filter_var($usernameField, FILTER_SANITIZE_STRING);
        $email = filter_var($emailField, FILTER_SANITIZE_STRING);
        $role = filter_var($roleField, FILTER_SANITIZE_STRING);

        $role = strtolower($role);

        if (empty($username) || empty($email) || empty($role)){
            echo "At least one field is empty.";
        }
        else if ($role!="user" && $role!="admin"){
            echo "Invalid user role.";
        }
        else if ((strpos($email, "@")!=strrpos($email, "@") && (strpos($email, ".")!=strrpos($email, "."))) || strpos($email, "@")==-1 || strpos($email, ".")==-1){
            echo "Invalid email.";
        }
    }

    public static function updateUser ($usernameField, $emailField, $roleField, $idField){
        $username = filter_var($usernameField, FILTER_SANITIZE_STRING);
        $email = filter_var($emailField, FILTER_SANITIZE_STRING);
        $role = filter_var($roleField, FILTER_SANITIZE_STRING);

        $role = strtolower($role);

        if (empty($username) || empty($email) || empty($role)){
            echo "At least one field is empty.";
        }
        else if ($role!="user" && $role!="admin"){
            echo "Invalid user role.";
        }
        else if ((strpos($email, "@")!=strrpos($email, "@") && (strpos($email, ".")!=strrpos($email, "."))) || strpos($email, "@")==-1 || strpos($email, ".")==-1){
            echo "Invalid email.";
        }
    }

    public static function findUser ($idField){
        $id = filter_var($idField, FILTER_SANITIZE_STRING);

        if ($id > 1){
        }
        else{
            echo "Invalid ID.";
        }
    }

    public static function deleteUser ($idField){
        $id = filter_var($idField, FILTER_SANITIZE_STRING);

        if ($id > 1){
        }
        else{
            echo "Invalid ID.";
        }
    }

}

?>
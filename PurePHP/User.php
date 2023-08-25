<?php

class User {
    private $id;
    private $username;
    private $email;
    private $role;

    public User ($id, $username, $email, $role){
        this->$id = $id;
        this->$username = $username;
        this->$email = $email;
        this->$role = $role;
    }

    public setId($id){
        this->$id = $id;
    }

    public getId(){
        return $id;
    }

    public setUsername($username){
        this->$username = $username;
    }

    public getUsername(){
        return $username;
    }

    public getEmail($email){
        this->$email = $email;
    }

    public getEmail(){
        return $email;
    }

    public getRole($role){
        this->$role = $role;
    }

    public getRole(){
        return $role;
    }
}

?>
<?php

class User extends Database
{
    private $username;
    private $email;
    private $password;

    //=========================
    /* Register a new User*/
    //=========================
    public function registerUser($username, $email, $password)
    {
        //hash password

        $pw = password_hash($password, PASSWORD_DEFAULT);

        //prepare sql statement
        $this->stmt = $this->pdo->prepare("INSERT INTO users (username, email, password) VALUES(:username, :email , :password) ");

        //execute sql statement:
        if ($this->stmt->execute([
            ":username" => $username,
            ":email" => $email,
            ":password" => $pw
        ])) {
            return true;
        } else {
            return false;
        }
    }

    //===========================
    /*Find User by Mail*/
    //===========================
    public function findUserByEmail($email)
    {
        //prepare sql-statement
        $this->stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");

        //execute statement
        $this->stmt->execute([
            ":email" => $email
        ]);

        return $this->stmt->fetch();
    }

    public function login()
    { }
}
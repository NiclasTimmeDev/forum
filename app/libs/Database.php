<?php

class Database
{
    protected $pdo;
    protected $stmt;
    //connect to DB
    //the constants are defined in config/config.php, which is loaded in the bootstrap.php file
    public function __construct()
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_PERSISTENT => true
        );


        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
        } catch (PDOException $e) {
            die("Database connection failed");
            echo $e->getMessage();
        }
    }
}


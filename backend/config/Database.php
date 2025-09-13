<?php

class Database {
    private $username;
    private $password;
    private $host;
    private $database;


    // TODO try to impelment Database class as singleton
    public function __construct()
    {
        // TODO nalezy dane umiescic w pliku .env i wczytac jako zmienne srodowiskowe
        $this->username = "docker";
        $this->password = "docker";
        $this->host = "db";
        $this->database = "db";
    }

    public function connect()
    {
        try {
            $conn = new PDO(
                "pgsql:host=$this->host;port=5432;dbname=$this->database",
                $this->username,
                $this->password,
                ["sslmode"  => "prefer"]
            );

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e) {
            // TODO nalezy zwrocic tutaj strone z bledem 404
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function disconnet() 
    {
        // TODO
    }
}
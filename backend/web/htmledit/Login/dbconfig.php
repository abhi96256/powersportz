<?php
class Database
{

    // private $host = "localhost";
    // private $db_name = "test";
    // private $username = "root";
    // private $password = "root";

    private $host = "10.10.10.28";
    private $db_name = "powersport";
    private $username = "powersport";
    private $password = "Dgt569khd";



    public $conn;

    public function dbConnection()
    {

        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

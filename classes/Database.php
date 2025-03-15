<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct() {
        // Load environment variables
        $this->loadEnv();

        // Set properties
        $this->host = getenv('DB_HOST');
        $this->db_name = getenv('DB_NAME');
        $this->username = getenv('DB_USER');
        $this->password = getenv('DB_PASS');
    }

    // Load .env variables
    private function loadEnv() {
        if (file_exists(__DIR__ . '/../.env')) {
            $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                putenv(trim($line));
            }
        }
    }

    //Establish a PDO connection
    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
        return $this->conn;
    }

   
    // ++++ A simple way to connect ++++
    // public function connect() {
    //     try {
    //         return new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
    //     } catch (PDOException $e) {
    //         die("Database Connection Failed: " . $e->getMessage());
    //     }
    // }
}

<?php
require_once __DIR__ . '/../classes/Database.php';

class Admin {
    private $conn;
    private $table = "admins";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Fetch all users
    public function getAdmins() {
        $query = "SELECT id, name, email FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

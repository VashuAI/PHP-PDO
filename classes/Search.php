<?php
require_once __DIR__ . '/Database.php';

class Search {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function globalSearch($keyword, $userType = null) {
        $results = [];
    
        $tables = [
            'users' => ['name', 'email'],
            'admins' => ['name', 'email']
        ];
    
        // If user type is provided, filter only that table
        if ($userType === 'user') {
            $tables = ['users' => ['name', 'email']];
        } elseif ($userType === 'admin') {
            $tables = ['admins' => ['name', 'email']];
        }
    
        foreach ($tables as $table => $columns) {
            $searchConditions = [];
    
            foreach ($columns as $column) {
                $searchConditions[] = "$column LIKE :keyword";
            }
    
            $sql = "SELECT * FROM $table WHERE " . implode(' OR ', $searchConditions);
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':keyword' => '%' . $keyword . '%']);
            $results[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    
        return $results;
    }
    
    
}

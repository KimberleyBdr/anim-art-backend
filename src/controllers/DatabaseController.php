<?php
require_once __DIR__ . '/../../config/database.php';

class DatabaseController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function testConnection() {
        if ($this->db) {
            return json_encode(["status" => "success", "message" => "Database connection is working fine."]);
        } else {
            return json_encode(["status" => "error", "message" => "Failed to connect to the database."]);
        }
    }
}
?>

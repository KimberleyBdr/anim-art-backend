<?php
require_once '../config/database.php';

class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $email;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fonction pour créer un utilisateur
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (username, email, password) VALUES (:username, :email, :password_hash)";

        $stmt = $this->conn->prepare($query);

        // Sécurisation des données
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // Liaison des valeurs
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password_hash', $this->password);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Fonction pour obtenir tous les utilisateurs
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
?>

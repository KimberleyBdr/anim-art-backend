<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/database.php';


class UserController {
    private $db;
    private $user;

    public function __construct() {
        $this->user = new User($this->db);
    }

    // Fonction pour créer un utilisateur
    public function createUser($username, $email, $password) {
        $this->user->username = $username;
        $this->user->email = $email;
        $this->user->password = password_hash($password, PASSWORD_BCRYPT);

        if ($this->user->create()) {
            return json_encode(["message" => "User created successfully."]);
        } else {
            return json_encode(["message" => "User could not be created."]);
        }
    }

    // Fonction pour obtenir tous les utilisateurs
    public function getAllUsers() {
        $stmt = $this->user->readAll();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($users);
    }
}
?>

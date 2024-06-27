
<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/User.php';

class UserController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

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

    public function getAllUsers() {
        $stmt = $this->user->readAll();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($users);
    }

    public function login($email, $password) {
        $user = $this->user->findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return json_encode(["status" => "success", "message" => "Login successful!"]);
        } else {
            return json_encode(["status" => "error", "message" => "Invalid email or password."]);
        }
    }
}
?>

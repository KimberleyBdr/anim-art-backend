<?php
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../config/database.php';

class UserController {
    private $user;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->user = new User($db);
    }

    public function login($email, $password) {
        $user = $this->user->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user_id'] = $user['id'];
            echo json_encode(['authenticated' => true]);
        } else {
            echo json_encode(['authenticated' => false]);
        }
    }

    public function checkSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user_id'])) {
            echo json_encode(['authenticated' => true]);
        } else {
            echo json_encode(['authenticated' => false]);
        }
    }

    public function register($email, $password) {
        $userExists = $this->user->findByEmail($email);

        if ($userExists) {
            echo json_encode(['success' => false, 'message' => 'E-mail déjà utilisé.']);
            return;
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $registrationSuccessful = $this->user->registerUser($email, $passwordHash);

        if ($registrationSuccessful) {
            echo json_encode(['success' => true, 'message' => 'Inscription réussie.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Une erreur est survenue lors de l\'inscription.']);
        }
    }
        
}
?>


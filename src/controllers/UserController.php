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

        if ($user) {
            if (password_verify($password, $user['password'])) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user'] = $user; // Stocke toutes les informations utilisateur
                return json_encode(['authenticated' => true, 'user' => $_SESSION['user']]);
            } else {
                return json_encode(['authenticated' => false, 'message' => 'Invalid credentials.']);
            }
        } else {
            return json_encode(['authenticated' => false, 'message' => 'User not found.']);
        }
    }

    public function checkSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user_id'])) {
            // L'utilisateur est authentifié, renvoyez les informations de l'utilisateur
            return json_encode([
                'authenticated' => true,
                'user' => $_SESSION['user_id'] // Assurez-vous que $_SESSION['user'] contient les informations nécessaires, y compris l'ID
            ]);
        } else {
            // L'utilisateur n'est pas authentifié
            return json_encode(['authenticated' => false]);
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
    

    public function profil($id) {
        // Utilisez la méthode findByID du modèle User
        $user = $this->user->findByID($id);
        if (!$user) {
            return json_encode(['error' => 'User not found']);
        }

        return json_encode($user);
    }
    
}
?>


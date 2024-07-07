<?php
require_once __DIR__ . '/../../models/User.php';

class UserController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function checkSession() {
        session_start();

        if(isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $userData = [
                'username' => $user['username'],
                'email' => $user['email']
            ];

            echo json_encode(['authenticated' => true, 'user' => $userData]);
        } else {
            echo json_encode(['authenticated' => false]);
        }
    }

    public function login($email, $password) {
        $user = new User($this->db);
        return $user->login($email, $password);
    }
}

// Exemple de connexion PDO
$db = new PDO('mysql:host=localhost;dbname=anim_art', 'root', '');
$controller = new UserController($db);

// Vérifiez le type de requête
if($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = isset($_GET['action']) ? $_GET['action'] : die(json_encode(["message" => "No action specified."]));

    switch ($action) {
        case 'checkSession':
            $controller->checkSession();
            break;
        default:
            echo json_encode(["message" => "Invalid action."]);
            break;
    }
} elseif($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pour les actions POST comme login, assurez-vous de gérer cela correctement dans votre application frontend
    $data = json_decode(file_get_contents("php://input"));
    echo $controller->login($data->email, $data->password);
}
?>

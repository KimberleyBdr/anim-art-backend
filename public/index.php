<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../src/controllers/DatabaseController.php';
require_once __DIR__ . '/../src/controllers/UserController.php';

header('Access-Control-Allow-Origin: http://localhost:3000'); // Spécifiez l'origine de votre application frontale
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Access-Control-Allow-Credentials: true'); // Ajoutez cette ligne

session_start(); // Assurez-vous que la session est démarrée

$action = $_GET['action'];

switch ($action) {
    case 'login':
        $controller = new UserController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->login($data->email, $data->password);
        }
        break;

        case 'register':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                $email = $data['email'] ?? '';
                $password = $data['password'] ?? '';
                $confirmPassword = $data['confirmPassword'] ?? '';
            
                if ($password !== $confirmPassword) {
                    echo json_encode(['success' => false, 'message' => 'Les mots de passe ne correspondent pas.']);
                    exit;
                }
            
                $controller = new UserController();
                echo $controller->register($email, $password);
            }
            break;

    case 'checkSession':
        $controller = new UserController();
        echo $controller->checkSession();
        break;

    // Ajoutez d'autres cas d'actions ici

    default:
        http_response_code(404);
        echo json_encode(["message" => "Action not found"]);
        break;
}
?>

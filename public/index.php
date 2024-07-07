<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../src/controllers/DatabaseController.php';
require_once __DIR__ . '/../src/controllers/UserController.php';

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$action = isset($_GET['action']) ? $_GET['action'] : die(json_encode(["message" => "No action specified."]));

switch ($action) {
    case 'testConnection':
        $dbController = new DatabaseController();
        echo $dbController->testConnection();
        break;

    case 'createUser':
        $controller = new UserController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'));
            echo $controller->createUser($data->username, $data->email, $data->password);
        }
        break;

    case 'getAllUsers':
        $controller = new UserController();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            echo $controller->getAllUsers();
        }
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller = new UserController();
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->login($data->email, $data->password);
        } else {
            // Gérer le cas où la méthode HTTP n'est pas POST (optionnel)
            echo json_encode(["message" => "Invalid request method"]);
        }
        break;
        case 'logout':
            $controller = new UserController();
            echo $controller->logout();
            break;
    
        case 'checkSession':
            $controller = new UserController();
            echo $controller->checkSession();
            break;

    default:
        echo json_encode(["message" => "Invalid action."]);
        break;
}
?>

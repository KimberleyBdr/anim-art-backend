<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../src/controllers/DatabaseController.php';
require_once __DIR__ . '/../src/controllers/UserController.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');

$action = isset($_GET['action']) ? $_GET['action'] : die(json_encode(["message" => "No action specified."]));

switch ($action) {
    case 'testConnection':
        $dbController = new DatabaseController();
        echo $dbController->testConnection();
        break;

    case 'createUser':
        $controller = new UserController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->createUser($data->username, $data->email, $data->password);
        }
        break;

    case 'getAllUsers':
        $controller = new UserController();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            echo $controller->getAllUsers();
        }
        break;

    default:
        echo json_encode(["message" => "Invalid action."]);
        break;
}
?>

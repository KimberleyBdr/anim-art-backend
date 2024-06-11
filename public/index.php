<?php
// header("Access-Control-Allow-Origin: http://localhost:3000");
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type, Authorization");

// header("Content-Type: application/json");

require_once '../src/controllers/UserController.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$controller = new UserController();

$action = isset($_GET['action']) ? $_GET['action'] : die(json_encode(["message" => "No action specified."]));

switch ($action) {
    case 'createUser':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->createUser($data->username, $data->email, $data->password);
        }
        break;

    case 'getAllUsers':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            echo $controller->getAllUsers();
        }
        break;

    default:
        echo json_encode(["message" => "Invalid action."]);
        break;
}
?>

<?php

include_once 'controller.php';

$host = 'localhost';
$port = '5432';
$database = 'api_crud';
$username = 'postgres';
$password = '1166';

$userController = new UserController($host, $port, $database, $username, $password);

// API endpoints
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'add':
            $name = $_POST['name'];
            $email = $_POST['email'];
            $user = $userController->addUser($name, $email);
            if ($user) {
                echo json_encode(['success' => true, 'message' => 'User added successfully', 'user' => $user->Display()]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add user']);
            }
            break;
        case 'update':
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $user = $userController->updateUser($id, $name, $email);
            if ($user) {
                echo json_encode(['success' => true, 'message' => 'User updated successfully', 'user' => $user->Display()]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update user']);
            }
            break;
        case 'delete':
            $id = $_POST['id'];
            $user = $userController->deleteUser($id);
            if ($user) {
                echo json_encode(['success' => true, 'message' => 'User deleted successfully', 'user' => $user->Display()]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete user']);
            }
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $users = $userController->getAllUsers();
    $response = ['success' => true, 'users' => $users];
    echo json_encode($response);
}
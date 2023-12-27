<?php
require __DIR__ . '/../model/Login.php';
require __DIR__ . '/../../config.php';

class LoginController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new Login($db);
    }

    public function loginUser($username, $password)
    {
        if ($this->model->validateUser($username, $password)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit();
    }
}

    $db = new Database();
    $loginController = new LoginController($db);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $loginController->loginUser($username, $password);
    }
?>

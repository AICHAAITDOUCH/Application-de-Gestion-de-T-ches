<?php
require_once __DIR__ . '/../config.php'; 
require_once __DIR__ . '/TaskController.php'; 
require_once __DIR__ . '/../models/User.php'; 

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User(); 
    }

    public function register() {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($this->userModel->create($username, $email, $password)) {
            header('Location: /tache/index.php?action=login');
            exit();
        } else {
            echo "Registration failed!";
        }
    }

    public function login() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $this->userModel->find($username);

        if ($user && $password === $user['password']) {
            if ($username === 'admin') {
                header('Location: /tache/views/pageadmin.php');
            } else {
                header('Location: /tache/views/task.php');
            }
            exit();
        } else {
            echo "<div class='error-message'>Login failed! Invalid username or password.</div>";
        }
    }

    public function showRegisterPage() {
        include __DIR__ . '/../views/register.php';
    }

    public function showLoginPage() {
        include __DIR__ . '/../views/login.php';
    }

    public function getUsers() {
        return $this->userModel->getAllUsers();
    }
}
?>

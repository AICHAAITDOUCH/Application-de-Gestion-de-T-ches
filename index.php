<?php


require_once __DIR__ . '/config.php';
require_once __DIR__ . '/controllers/TaskController.php';
require_once __DIR__ . '/controllers/UserController.php';

$controller = new UserController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        $controller->register();
    } elseif (isset($_POST['login'])) {
        $controller->login();
    }
} else {
    if (isset($_GET['action']) && $_GET['action'] === 'register') {
        $controller->showRegisterPage();
    } elseif (isset($_GET['action']) && $_GET['action'] === 'login') {
        $controller->showLoginPage();
    } else {
        $controller->showLoginPage();
    }
}


?>

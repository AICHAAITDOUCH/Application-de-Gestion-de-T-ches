<?php


session_start();
require_once __DIR__ . '/../controllers/TaskController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /tache/views/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $task_id = isset($_POST['task_id']) ? $_POST['task_id'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    if ($task_id && $status !== '') {
        $taskController = new TaskController();
        $tasks = $taskController->getUserTasks($user_id);
        $task = array_filter($tasks, fn($t) => $t['id'] == $task_id);

        if ($task) {
            $stmt = $taskController->pdo->prepare("UPDATE tasks SET status = :status WHERE id = :id AND user_id = :user_id");
            $stmt->execute(['status' => $status, 'id' => $task_id, 'user_id' => $user_id]);
            echo "Status updated successfully";
        } else {
            echo "Unauthorized action";
        }
    } else {
        echo "Invalid input";
    }
}
?>


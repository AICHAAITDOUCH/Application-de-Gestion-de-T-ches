<?php
require_once dirname(__DIR__) . '/controllers/TaskController.php';

if(isset($_GET['id'])) {
    $taskId = $_GET['id'];

    $taskController = new TaskController();

    $result = $taskController->deleteTask($taskId);

    if ($result) {
        header('Location: pageadmin.php');
    } else {
        echo "Une erreur s'est produite lors de la suppression de la tâche.";
    }
} else {
    echo "ID de la tâche non spécifié.";
}
?>

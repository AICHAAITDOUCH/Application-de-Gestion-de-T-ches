<?php
require_once 'TaskController.php';

if(isset($_GET['id'])) {
    $taskId = $_GET['id'];

    $taskController = new TaskController();

    $result = $taskController->deleteTask($taskId);

    if ($result) {
        echo "La tâche a été supprimée avec succès !";
    } else {
        echo "Une erreur s'est produite lors de la suppression de la tâche.";
    }
} else {
    echo "ID de la tâche non spécifié.";
}
?>

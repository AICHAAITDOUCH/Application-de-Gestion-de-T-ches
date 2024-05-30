<?php
require_once 'C:/xampp/htdocs/tache/config.php';
require_once 'C:/xampp/htdocs/tache/models/Task.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskId = $_POST['task_id'];
    $status = $_POST['status'];

    $taskModel = new Task();
    if ($taskModel->updateStatus($taskId, $status)) {
        echo 'Status updated successfully';
    } else {
        echo 'Failed to update status';
    }
}
?>

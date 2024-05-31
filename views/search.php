<?php


session_start();
require_once __DIR__ . '/../controllers/TaskController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /tache/views/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$search_term = isset($_POST['search_term']) ? $_POST['search_term'] : '';
$priority = isset($_POST['priority']) ? $_POST['priority'] : '';

$taskController = new TaskController();
$tasks = $taskController->searchTasks($user_id, $search_term, $priority);

foreach ($tasks as $task) {
    echo '<tr>
        <td>' . htmlspecialchars($task['id']) . '</td>
        <td>' . htmlspecialchars($task['username']) . '</td>
        <td>' . htmlspecialchars($task['email']) . '</td>
        <td>' . htmlspecialchars($task['title']) . '</td>
        <td>' . htmlspecialchars($task['description']) . '</td>
        <td>' . htmlspecialchars($task['category']) . '</td>
        <td>' . htmlspecialchars($task['priority']) . '</td>
        <td>' . htmlspecialchars($task['start_date']) . '</td>
        <td>' . htmlspecialchars($task['end_date']) . '</td>
        <td>
            <label class="switch">
                <input type="checkbox" class="status-toggle" data-id="' . htmlspecialchars($task['id']) . '" ' . (isset($task['status']) && $task['status'] ? 'checked' : '') . '>
                <span class="slider round"></span>
            </label>
        </td>
    </tr>';
}





?>

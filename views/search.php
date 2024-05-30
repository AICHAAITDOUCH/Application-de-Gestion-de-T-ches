<?php
require_once 'C:/xampp/htdocs/tache/config.php';
require_once 'C:/xampp/htdocs/tache/models/Task.php';

$searchTerm = isset($_POST['search_term']) ? $_POST['search_term'] : '';
$priority = isset($_POST['priority']) ? $_POST['priority'] : '';

$taskModel = new Task();
$tasks = $taskModel->searchTasks($searchTerm, $priority);

foreach ($tasks as $task) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($task['id']) . '</td>';
    echo '<td>' . htmlspecialchars($task['username']) . '</td>';
    echo '<td>' . htmlspecialchars($task['email']) . '</td>';
    echo '<td>' . htmlspecialchars($task['title']) . '</td>';
    echo '<td>' . htmlspecialchars($task['description']) . '</td>';
    echo '<td>' . htmlspecialchars($task['category']) . '</td>';
    echo '<td>' . htmlspecialchars($task['priority']) . '</td>';
    echo '<td>' . htmlspecialchars($task['start_date']) . '</td>';
    echo '<td>' . htmlspecialchars($task['end_date']) . '</td>';
    echo '<td>';
    echo '<label class="switch">';
    echo '<input type="checkbox" class="status-toggle" data-id="' . htmlspecialchars($task['id']) . '" ' . (isset($task['status']) && $task['status'] ? 'checked' : '') . '>';
    echo '<span class="slider round"></span>';
    echo '</label>';
    echo '</td>';
    echo '</tr>';
}
?>

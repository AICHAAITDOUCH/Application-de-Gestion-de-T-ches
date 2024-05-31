<?php
require_once 'C:/xampp/htdocs/tache/models/Database.php';

if (isset($_POST['submit'])) {
    $userId = $_POST['user_id'];
    $title = $_POST['task_title'];
    $description = $_POST['task_desc'];
    $category = $_POST['task_category'];
    $priority = $_POST['task_priority'];
    $startDate = $_POST['task_start_date'];
    $endDate = $_POST['task_end_date'];

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, category, priority, start_date, end_date) VALUES (:user_id, :title, :description, :category, :priority, :start_date, :end_date)");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    $stmt->bindParam(':priority', $priority, PDO::PARAM_STR);
    $stmt->bindParam(':start_date', $startDate, PDO::PARAM_STR);
    $stmt->bindParam(':end_date', $endDate, PDO::PARAM_STR);
    
    if ($stmt->execute()) {
        echo "Task added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

$stmt->closeCursor();
$conn = null; 


    header("Location: ../views/pageadmin.php");
    exit();
}
?>

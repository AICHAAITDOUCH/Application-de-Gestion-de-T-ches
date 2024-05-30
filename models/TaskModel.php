<?php
require_once 'Database.php';

class TaskModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getAllTasks() {
        $query = "SELECT * FROM tasks";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchTasks($title, $category = null, $priority = null) {
        $query = "SELECT * FROM tasks WHERE title LIKE :title";
        $params = [':title' => "%$title%"];

        if ($category) {
            $query .= " AND category = :category";
            $params[':category'] = $category;
        }

        if ($priority) {
            $query .= " AND priority = :priority";
            $params[':priority'] = $priority;
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

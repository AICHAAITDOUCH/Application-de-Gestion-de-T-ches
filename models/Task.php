<?php
require_once 'C:/xampp/htdocs/tache/config.php';

class Task {
    private $pdo;

    public function __construct() {
        $this->pdo = getPDO();
    }

    public function create($userId, $title, $desc, $category, $priority, $startDate, $endDate) {
        $stmt = $this->pdo->prepare("INSERT INTO tasks (user_id, title, description, category, priority, start_date, end_date) VALUES (:user_id, :title, :description, :category, :priority, :start_date, :end_date)");
        return $stmt->execute([
            'user_id' => $userId,
            'title' => $title,
            'description' => $desc,
            'category' => $category,
            'priority' => $priority,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }

    public function getAllTasks() {
        $query = "SELECT tasks.*, users.username, users.email 
                  FROM tasks 
                  JOIN users ON tasks.user_id = users.id";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($taskId, $status) {
        $stmt = $this->pdo->prepare("UPDATE tasks SET status = :status WHERE id = :task_id");
        return $stmt->execute([
            'status' => $status,
            'task_id' => $taskId
        ]);
    }

    public function searchTasks($searchTerm, $priority = null) {
        $query = "SELECT tasks.*, users.username, users.email 
                  FROM tasks 
                  JOIN users ON tasks.user_id = users.id 
                  WHERE tasks.title LIKE :searchTerm";
        $params = [':searchTerm' => '%' . $searchTerm . '%'];

        if ($priority) {
            $query .= " AND tasks.priority = :priority";
            $params[':priority'] = $priority;
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

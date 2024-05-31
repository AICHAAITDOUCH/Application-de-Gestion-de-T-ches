<?php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/TaskModel.php';

class TaskController {
    private $taskModel;
    private $pdo;

    public function __construct() {
        $this->taskModel = new TaskModel();
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function getTasks() {
        $sql = "SELECT tasks.id, users.username, users.email, tasks.title, tasks.description, tasks.category, tasks.priority, tasks.start_date, tasks.end_date FROM tasks JOIN users ON tasks.user_id = users.id";
        $stmt = $this->pdo->query($sql);

        $tasks = [];
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $tasks[] = $row;
            }
        }

        return $tasks;
    }

    public function getTaskById($taskId) {
        $stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE id = :task_id");
        $stmt->bindParam(':task_id', $taskId);
        $stmt->execute();
        
        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        return $task;
    }

    public function updateTask($taskId, $taskTitre, $taskDesc, $taskCategory, $taskPriority, $taskStartDate, $taskEndDate) {
        $sql = "UPDATE tasks SET title = :task_titre, description = :task_desc, category = :task_category, priority = :task_priority, start_date = :task_start_date, end_date = :task_end_date WHERE id = :task_id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':task_id', $taskId);
        $stmt->bindValue(':task_titre', $taskTitre);
        $stmt->bindValue(':task_desc', $taskDesc);
        $stmt->bindValue(':task_category', $taskCategory);
        $stmt->bindValue(':task_priority', $taskPriority);
        $stmt->bindValue(':task_start_date', $taskStartDate);
        $stmt->bindValue(':task_end_date', $taskEndDate);
    
        return $stmt->execute();
    }

    public function deleteTask($taskId) {
        $sql = "DELETE FROM tasks WHERE id = :task_id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':task_id', $taskId);
        
        return $stmt->execute();
    }

    public function updateTaskStatus($taskId, $status) {
        $sql = "UPDATE tasks SET status = :status WHERE id = :task_id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':task_id', $taskId);
        $stmt->bindValue(':status', $status);
        
        return $stmt->execute();
    }

    public function searchTasks($user_id, $search_term, $priority) {
        $query = "SELECT tasks.*, users.username, users.email 
                  FROM tasks 
                  JOIN users ON tasks.user_id = users.id 
                  WHERE tasks.user_id = :user_id";
        $params = ['user_id' => $user_id];
    
        if (!empty($search_term)) {
            $query .= " AND tasks.title LIKE :search_term";
            $params['search_term'] = '%' . $search_term . '%';
        }
    
        if (!empty($priority)) {
            $query .= " AND tasks.priority = :priority";
            $params['priority'] = $priority;
        }
    
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getUserTasks($userId) {
        $sql = "SELECT tasks.id, users.username, users.email, tasks.title, tasks.description, tasks.category, tasks.priority, tasks.start_date, tasks.end_date 
                FROM tasks 
                JOIN users ON tasks.user_id = users.id 
                WHERE tasks.user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
    
        $tasks = [];
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $tasks[] = $row;
            }
        }
    
        return $tasks;
    }
}
?>

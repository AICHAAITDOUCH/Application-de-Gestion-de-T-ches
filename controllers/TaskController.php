<?php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/TaskModel.php';


class TaskController {
    private $taskModel;

    public function __construct() {
        $this->taskModel = new TaskModel();
    }

    public function getTasks() {
        $db = new Database();
        $conn = $db->getConnection();

        $sql = "SELECT tasks.id, users.username, users.email, tasks.title, tasks.description, tasks.category, tasks.priority, tasks.start_date, tasks.end_date FROM tasks JOIN users ON tasks.user_id = users.id";
        $stmt = $conn->query($sql);

        $tasks = [];
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $tasks[] = $row;
            }
        }

        $conn = null; 
        return $tasks;
    }

    public function getTaskById($taskId) {
        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = :task_id");
        $stmt->bindParam(':task_id', $taskId);
        $stmt->execute();
        
        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        $conn = null;

        return $task;
    }
 


    public function updateTask($taskId, $taskTitre, $taskDesc, $taskCategory, $taskPriority, $taskStartDate, $taskEndDate) {
        $db = new Database();
        $conn = $db->getConnection();
        
        $sql = "UPDATE tasks SET title = :task_titre, description = :task_desc, category = :task_category, priority = :task_priority, start_date = :task_start_date, end_date = :task_end_date WHERE id = :task_id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':task_id', $taskId);
        $stmt->bindValue(':task_titre', $taskTitre);
        $stmt->bindValue(':task_desc', $taskDesc);
        $stmt->bindValue(':task_category', $taskCategory);
        $stmt->bindValue(':task_priority', $taskPriority);
        $stmt->bindValue(':task_start_date', $taskStartDate);
        $stmt->bindValue(':task_end_date', $taskEndDate);
    
        $result = $stmt->execute();
        
    
        return $result;
    }

    public function deleteTask($taskId) {
        $db = new Database();
        $conn = $db->getConnection();
        
        $sql = "DELETE FROM tasks WHERE id = :task_id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':task_id', $taskId);
        
        $result = $stmt->execute();
        
        return $result;
    }

    public function updateTaskStatus($taskId, $status) {
        $db = new Database();
        $conn = $db->getConnection();
        
        $sql = "UPDATE tasks SET status = :status WHERE id = :task_id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':task_id', $taskId);
        $stmt->bindValue(':status', $status);
        
        return $stmt->execute();
    }

    public function searchTasksByTitle($searchTerm) {
        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT tasks.id, users.username, users.email, tasks.title, tasks.description, tasks.category, tasks.priority, tasks.start_date, tasks.end_date FROM tasks JOIN users ON tasks.user_id = users.id WHERE tasks.title LIKE :search_term");
        $stmt->bindValue(':search_term', '%' . $searchTerm . '%');
        $stmt->execute();
        
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $conn = null;

        return $tasks;
    }
}
?>

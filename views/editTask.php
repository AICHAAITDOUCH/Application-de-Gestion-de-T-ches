<?php
require_once dirname(__DIR__) . '/controllers/TaskController.php';

if(isset($_GET['id'])) {
    $taskId = $_GET['id'];
} else {
    echo "ID de la tâche non spécifié.";
    exit;
}

$taskController = new TaskController();

if (isset($_POST['submit'])) {
    $taskTitre = $_POST['task_titre'];
    $taskDesc = $_POST['task_desc'];
    $taskCategory = $_POST['task_category'];
    $taskPriority = $_POST['task_priority'];
    $taskStartDate = $_POST['task_start_date'];
    $taskEndDate = $_POST['task_end_date'];

    $result = $taskController->updateTask($taskId, $taskTitre, $taskDesc, $taskCategory, $taskPriority, $taskStartDate, $taskEndDate);

    if ($result) {
        header('Location: pageadmin.php');
        exit();
    } else {
        echo "Une erreur s'est produite lors de la mise à jour de la tâche.";
    }
}

$taskDetails = $taskController->getTaskById($taskId);

if(!$taskDetails) {
    echo "La tâche spécifiée n'existe pas.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Tâche</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>Modifier une Tâche</header>
        <form method="POST" action="editTask.php?id=<?php echo $taskId; ?>" class="task-form">
            <div class="field">
                <label for="task-titre">Titre</label>
                <div class="input-area">
                    <i class="fas fa-list"></i>
                    <input type="text" id="task-titre" name="task_titre" value="<?php echo htmlspecialchars($taskDetails['title']); ?>" placeholder="Entrez le titre" required>
                </div>
            </div>
            <div class="field">
                <label for="task-desc">Description</label>
                <div class="input-area">
                    <i class="fas fa-align-left"></i>
                    <textarea id="task-desc" name="task_desc" placeholder="Entrez la description de la tâche" required><?php echo htmlspecialchars($taskDetails['description']); ?></textarea>
                </div>
            </div>
            <div class="field">
                <label for="task-category">Catégorie</label>
                <div class="input-area">
                    <i class="fas fa-list"></i>
                    <input type="text" id="task-category" name="task_category" value="<?php echo htmlspecialchars($taskDetails['category']); ?>" placeholder="Entrez la catégorie de la tâche" required>
                </div>
            </div>
            <div class="field">
                <label for="task-priority">Priorité</label>
                <div class="input-area">
                    <i class="fas fa-exclamation-circle"></i>
                    <select id="task-priority" name="task_priority" required>
                        <option value="Normal" <?php echo ($taskDetails['priority'] == 'Normal') ? 'selected' : ''; ?>>Normal</option>
                        <option value="Urgent" <?php echo ($taskDetails['priority'] == 'Urgent') ? 'selected' : ''; ?>>Urgent</option>
                        <option value="Très Urgent" <?php echo ($taskDetails['priority'] == 'Très Urgent') ? 'selected' : ''; ?>>Très Urgent</option>
                    </select>
                </div>
            </div>
            <div class="field">
                <label for="task-start-date">Date de Début</label>
                <div class="input-area">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="date" id="task-start-date" name="task_start_date" value="<?php echo $taskDetails['start_date']; ?>" required>
                </div>
            </div>
            <div class="field">
                <label for="task-end-date">Date de Fin</label>
                <div class="input-area">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="date" id="task-end-date" name="task_end_date" value="<?php echo $taskDetails['end_date']; ?>" required>
                </div>
            </div>
            <input type="submit" value="Enregistrer" name="submit">
        </form>
    </div>
</body>
</html>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Arial', sans-serif;
        background: #DBB5B5;
    }

    .container {
        width: 100%;
        max-width: 600px;
        margin: 80px auto;
        padding: 40px;
        background: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        text-align: center;
    }

    header {
        font-size: 2em;
        margin-bottom: 20px;
        color: #333;
    }

    .field {
        margin-bottom: 20px;
        text-align: left;
    }

    .field label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .input-area {
        display: flex;
        align-items: center;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        background: #f9f9f9;
    }

    .input-area i {
        margin-right: 10px;
        color: #aaa;
    }

    .input-area input, .input-area textarea, .input-area select {
        border: none;
        outline: none;
        background: none;
        width: 100%;
        font-size: 1em;
    }

    .input-area input::placeholder, .input-area textarea::placeholder {
        color: #aaa;
    }

    textarea {
        resize: none;
        height: 100px;
    }

    input[type="submit"] {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 5px;
        background: #333;
        color: #fff;
        font-size: 1em;
        cursor: pointer;
        transition: background 0.3s;
    }

    input[type="submit"]:hover {
        background: #555;
    }
</style>

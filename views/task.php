<?php
require_once 'C:/xampp/htdocs/tache/controllers/TaskController.php';

$taskController = new TaskController();
$tasks = $taskController->getTasks();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table des Tâches</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="../A.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="task.php">Home</a></li>
                <li><a href="#">Logout</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h1>Table des Tâches</h1>
        <div class="search-container">
            <div class="search-item">
                <input type="text" id="search-input" placeholder="Rechercher par titre...">
                <button id="search-title-button">Rechercher</button>
            </div>
            <div class="search-item">
                <select id="priority-filter">
                    <option value="">Toutes les priorités</option>
                    <option value="Normal">Normal</option>
                    <option value="Urgent">Urgent</option>
                    <option value="Très Urgent">Très Urgent</option>
                </select>
                <button id="search-priority-button">Filtrer</button>
            </div>
        </div>
        <br><br>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Catégorie</th>
                    <th>Priorité</th>
                    <th>Date de Début</th>
                    <th>Date de Fin</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?php echo htmlspecialchars($task['id']); ?></td>
                    <td><?php echo htmlspecialchars($task['username']); ?></td>
                    <td><?php echo htmlspecialchars($task['email']); ?></td>
                    <td><?php echo htmlspecialchars($task['title']); ?></td>
                    <td><?php echo htmlspecialchars($task['description']); ?></td>
                    <td><?php echo htmlspecialchars($task['category']); ?></td>
                    <td><?php echo htmlspecialchars($task['priority']); ?></td>
                    <td><?php echo htmlspecialchars($task['start_date']); ?></td>
                    <td><?php echo htmlspecialchars($task['end_date']); ?></td>
                    <td>
                        <label class="switch">
                            <input type="checkbox" class="status-toggle" data-id="<?php echo htmlspecialchars($task['id']); ?>" <?php echo isset($task['status']) && $task['status'] ? 'checked' : ''; ?>>
                            <span class="slider round"></span>
                        </label>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function(){
        $('#search-title-button').click(function(){
            var searchTerm = $('#search-input').val().trim();

            $.ajax({
                url: 'search.php',
                type: 'POST',
                data: {
                    search_term: searchTerm,
                    priority: ''
                },
                success: function(response){
                    $('tbody').html(response);
                },
                error: function(){
                    console.log('Failed to perform search');
                }
            });
        });

        $('#search-priority-button').click(function(){
            var priority = $('#priority-filter').val();

            $.ajax({
                url: 'search.php',
                type: 'POST',
                data: {
                    search_term: '',
                    priority: priority
                },
                success: function(response){
                    $('tbody').html(response);
                },
                error: function(){
                    console.log('Failed to perform search');
                }
            });
        });

        $('.status-toggle').each(function(){
            var taskId = $(this).data('id');
            var status = getStatusFromLocalStorage(taskId);
            if (status === '1') {
                $(this).prop('checked', true);
            }
        });

        $('.status-toggle').change(function(){
            var taskId = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;

            updateLocalStorage(taskId, status);

            $.ajax({
                url: 'update_status.php',
                type: 'POST',
                data: {
                    task_id: taskId,
                    status: status
                },
                success: function(response){
                    console.log(response);
                },
                error: function(){
                    console.log('Failed to update status');
                }
            });
        });

        function updateLocalStorage(taskId, status) {
            localStorage.setItem('task_' + taskId, status);
        }

        function getStatusFromLocalStorage(taskId) {
            return localStorage.getItem('task_' + taskId);
        }
    });
    </script>
</body>
</html>


<style>
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #F1E5D1;
}

header {
    background-color: #686D76;
    color: #fff;
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo img {
    width: 50px;
    height: 50px;
}

nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

nav ul li {
    display: inline;
    margin-left: 20px;
}

nav ul li a {
    text-decoration: none;
    color: #fff;
}

.container {
    margin: 20px auto;
    max-width: 800px;
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

.btn {
    padding: 10px 15px;
    margin: 10px 5px;
    border: none;
    border-radius: 5px;
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn:hover {
    background-color: #0056b3;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

table th {
    background-color: #f2f2f2;
}

table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
}

input:checked + .slider {
    background-color: #2196F3;
}

input:checked + .slider:before {
    transform: translateX(26px);
}

.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}

.search-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.search-item {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 10px;
}

input[type="text"],
select {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    padding: 8px 12px;
    border: none;
    background-color: #007bff;
    color: #fff;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}
</style>

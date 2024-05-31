<?php
require_once 'C:/xampp/htdocs/tache/controllers/UserController.php';
require_once 'C:/xampp/htdocs/tache/models/User.php';
require_once dirname(__DIR__) . '/controllers/TaskController.php';

$userController = new UserController();
$taskController = new TaskController();

$users = $userController->getUsers();
$tasks = $taskController->getTasks();
if (isset($_GET['logout'])) {
    $_SESSION = array();

    session_destroy();

    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                <li><a href="pageadmin.php">Home</a></li>
                <li><a href="?logout=true">Logout</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h1>Table des Utilisateurs</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <button class="btn ajouter-btn" id="addTaskBtn" onclick="window.location.href='add.php?id=<?php echo $user['id']; ?>'">  <i class="fa fa-plus-circle"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="container">
        <h1>Table des Tâches</h1>
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
                    <th>Actions</th>
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
                        <button class="btn edit-btn" onclick="window.location.href='editTask.php?id=<?php echo $task['id']; ?>'"><i class="fa fa-edit" style="font-size:20px;color:#fff"></i></button>
                        <button class="btn delete-btn" onclick="window.location.href='deleteTask.php?id=<?php echo $task['id']; ?>'" ><i class="material-icons" style="font-size:20px;color:#fff">delete</i>
                        </button>
                        
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
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
            overflow-x: auto; 
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
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .edit-btn {
            background-color: #9ADE7B;
        }

        .ajouter-btn {
            background-color: blue;
        }

        .delete-btn {
            background-color: red;
        }

        .ajouter-btn:hover {
            background-color: blue;
        }

        .edit-btn:hover {
            background-color: #9ADE7B;
        }

        .delete-btn:hover {
            background-color: red;
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

        /* Media queries pour la responsivité */
        @media screen and (max-width: 800px) {
            .container {
                max-width: 100%;
            }
        }

        @media screen and (max-width: 600px) {
            nav ul li {
                display: block; 
                margin: 10px 0; 
            }

            .btn {
                display: block;
                width: 100%; 
            }

            table {
                font-size: 12px; 
            }
        }
    </style>
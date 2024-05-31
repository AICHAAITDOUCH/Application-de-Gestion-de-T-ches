
<?php
session_start();
require_once 'C:/xampp/htdocs/tache/controllers/UserController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $userController = new UserController();
    $user = $userController->login($username, $password);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: /tache/views/task.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="wrapper">
        <header>Login</header>
        <form method="POST" action="/tache/index.php">
            <div class="field">
                <div class="input-area">
                    <i class="fas fa-user-circle"></i>
                    <input type="text" id="username" placeholder="Enter Username" name="username" required>
                </div>
            </div>
            <div class="field">
                <div class="input-area">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" placeholder="Password" name="password" required>
                </div>
            </div>
            <?php if (isset($error)): ?>
                <p style="color:red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <input type="submit" value="Login" name="login">
        </form>
    </div>
</body>
</html>



<style>
    body {
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    background: #DBAFA0;
}

.wrapper {
    width: 100%;
    max-width: 400px;
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
    position: relative;
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

.input-area input {
    border: none;
    outline: none;
    background: none;
    width: 100%;
    font-size: 1em;
}

.input-area input::placeholder {
    color: #aaa;
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

.error-message {
    color: red;
    font-size: 0.9em;
    margin-top: 20px;
}

</style>
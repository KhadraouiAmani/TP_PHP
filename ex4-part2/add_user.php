<?php
require_once 'config.php';
require_once 'includes/UserClassRepo.php';
session_start();


if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: dashboard.php");
    exit;
}

$userClass = new UserClassRepo($conn);

// Initialisation des varables
$username = "";
$email = "";
$role = "";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Ajouter le user
    $userClass->create($username, $email, $role);

    
    header("Location: usersUsingRepo.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un user</title>
</head>
<body>
    <h2>Ajouter un nouveau user</h2>
    <form method="POST">
        <label for="username">username :</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($username) ?>" required><br><br>

        <label for="email">email :</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required><br><br>

        <label>Role :</label>
        <select name="role" required>
            
            <option value="admin">admin</option>
            <option value="user">user</option>
            
        </select><br>

        <button type="submit">Ajouter</button>
    </form>

    <a href="usersUsingRepo.php">Retour à la liste des users</a>
</body>
</html>
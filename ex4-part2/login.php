<?php
session_start();
require_once 'config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données de l'utilisateur
    $username = $_POST['username'];    
    $email = $_POST['email'];

    // Préparer la requête pour récupérer l'utilisateur par son 'username' et 'email'
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND email = ?");
    $stmt->execute([$username, $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si l'utilisateur existe
    if ($user) {
        $_SESSION['user'] = $user;

        // Rediriger l'utilisateur selon son rôle
        if ($user['role'] == 'admin') {
            header("Location: dashboard.php"); // Dashboard pour l'administrateur
        } else {
            header("Location: dashboard.php"); // Dashboard pour l'utilisateur normal
        }
        exit;
    } else {
        // Si l'utilisateur n'existe pas
        $message = "Nom d'utilisateur ou email incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <form method="post">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <button type="submit">Se connecter</button>
    </form>

    <?php if ($message): ?>
        <p style="color: red;"><?= $message ?></p>
    <?php endif; ?>
</body>
</html>

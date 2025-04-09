<?php
session_start();
require_once 'config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];    
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND email = ?");
    $stmt->execute([$username, $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si l'utilisateur existe
    if ($user) {
        $_SESSION['user'] = $user;

        if ($user['role'] == 'admin') {
            header("Location: dashboard.php"); 
        } else {
            header("Location: dashboard.php"); 
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
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color:rgb(198, 198, 235);
}

h1 {
    text-align: center;
    color: #333;
}

form {
    background-color: #fff;
    margin: 20px auto;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
}

label {
    
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #555;
}

input[type="text"],
input[type="email"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    
}

button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

p {
    text-align: center;
    margin-top: 10px;
    font-size: 14px;
}

p[style="color: red;"] {
    color: red;
    font-weight: bold;
}
    </style>
</head>
<body>
    <header>
        <h1>Connexion</h1>
    </header>
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

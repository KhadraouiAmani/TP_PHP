<?php
require_once 'includes/auth.php'; 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    color: #333;
}

h2 {
    font-size: 24px;
    color: #007bff;
    margin-bottom: 10px;
}

p {
    font-size: 16px;
    margin: 5px 0;
}

a {
    display: inline-block;
    margin: 10px 0;
    padding: 10px 15px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

a:hover {
    background-color: #0056b3;
}

a:last-child {
    margin-top: 20px;
    background-color: #dc3545;
}

a:last-child:hover {
    background-color: #a71d2a;
}
    </style>
</head>

<body>
    <h2>Bienvenue, <?= htmlspecialchars($_SESSION['user']['username']) ?> !</h2>
    <p>Email : <?= htmlspecialchars($_SESSION['user']['email']) ?></p>
    <p>Rôle : <?= htmlspecialchars($_SESSION['user']['role']) ?></p>

    <?php if ($_SESSION['user']['role'] == 'admin'): ?>
        <a href="students.php">Gérer les étudiants</a><br>
        <a href="sections.php">Gérer les sections</a><br>
        <a href="usersUsingRepo.php">Gérer les users</a><br>

    <?php elseif ($_SESSION['user']['role'] == 'user'): ?>
        <p>Vous avez un accès en lecture seule.</p>
        <a href="students.php">Voir les étudiants</a><br>
        <a href="sections.php">Voir les sections</a><br>
    <?php endif; ?>

    <a href="logout.php">Se déconnecter</a>
</body>
</html>

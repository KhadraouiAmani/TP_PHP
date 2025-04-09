<?php
require_once 'includes/auth.php'; 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Bienvenue, <?= htmlspecialchars($_SESSION['user']['username']) ?> !</h2>
    <p>Email : <?= htmlspecialchars($_SESSION['user']['email']) ?></p>
    <p>Rôle : <?= htmlspecialchars($_SESSION['user']['role']) ?></p>

    <?php if ($_SESSION['user']['role'] == 'admin'): ?>
        <a href="students.php">Gérer les étudiants</a><br>
        <a href="sections.php">Gérer les sections</a><br>
    <?php elseif ($_SESSION['user']['role'] == 'user'): ?>
        <p>Vous avez un accès en lecture seule.</p>
        <a href="students.php">Voir les étudiants</a><br>
        <a href="sections.php">Voir les sections</a><br>
    <?php endif; ?>

    <a href="logout.php">Se déconnecter</a>
</body>
</html>

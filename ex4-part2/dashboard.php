<?php
require_once 'includes/auth.php'; // Assure-toi que l'utilisateur est authentifié et vérifie son rôle
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
        <!-- Lien pour l'admin vers la gestion des étudiants et des sections -->
        <a href="students.php">Gérer les étudiants</a><br>
        <a href="sections.php">Gérer les sections</a><br>
    <?php elseif ($_SESSION['user']['role'] == 'user'): ?>
        <!-- Si l'utilisateur est un utilisateur normal -->
        <p>Vous avez un accès en lecture seule.</p>
        <!-- Lien pour l'utilisateur vers la page d'affichage des étudiants -->
        <a href="students.php">Voir les étudiants</a><br>
        <a href="sections.php">Voir les sections</a><br>
    <?php endif; ?>

    <a href="logout.php">Se déconnecter</a>
</body>
</html>

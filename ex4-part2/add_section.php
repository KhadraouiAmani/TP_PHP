<?php
require_once 'config.php';
require_once 'includes/Section.php';
session_start();

// Vérifier si l'utilisateur est authentifié et a un rôle admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: dashboard.php");
    exit;
}

$sectionClass = new Section($conn);

// Initialiser les variables pour le formulaire
$designation = "";
$description = "";

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $designation = $_POST['designation'];
    $description = $_POST['description'];

    // Ajouter la section
    $sectionClass->create($designation, $description);

    // Rediriger vers la page des sections après l'ajout
    header("Location: sections.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une section</title>
</head>
<body>
    <h2>Ajouter une nouvelle section</h2>
    <form method="POST">
        <label for="designation">Désignation :</label>
        <input type="text" id="designation" name="designation" value="<?= htmlspecialchars($designation) ?>" required><br><br>

        <label for="description">Description :</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($description) ?></textarea><br><br>

        <button type="submit">Ajouter</button>
    </form>

    <a href="sections.php">Retour à la liste des sections</a>
</body>
</html>

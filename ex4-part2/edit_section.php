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

// Vérifier si l'ID de la section est passé dans l'URL
if (!isset($_GET['id'])) {
    header("Location: sections.php");
    exit;
}

$id = $_GET['id'];

// Récupérer la section par son ID
$section = $sectionClass->getById($id);
if (!$section) {
    header("Location: sections.php");
    exit;
}

// Initialiser les variables pour le formulaire
$designation = $section['designation'];
$description = $section['description'];

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $designation = $_POST['designation'];
    $description = $_POST['description'];

    // Mettre à jour la section
    $sectionClass->update($id, $designation, $description);

    // Rediriger vers la page des sections après la modification
    header("Location: sections.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une section</title>
</head>
<body>
    <h2>Modifier la section</h2>
    <form method="POST" action="edit_section.php?id=<?= $section['id'] ?>">
        <label for="designation">Désignation :</label>
        <input type="text" id="designation" name="designation" value="<?= htmlspecialchars($designation) ?>" required><br><br>

        <label for="description">Description :</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($description) ?></textarea><br><br>

        <button type="submit">Mettre à jour</button>
    </form>

    <a href="sections.php">Retour à la liste des sections</a>
</body>
</html>

<?php
require_once 'config.php';
require_once 'includes/Section.php';

session_start();

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Vérifier le rôle de l'utilisateur
$isAdmin = $_SESSION['user']['role'] === 'admin';



$sectionClass = new Section($conn);

// Récupérer toutes les sections
$sections = $sectionClass->getAll();

// Vérifier si une section a été sélectionnée
$sectionId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$students = [];

if ($sectionId) {
    // Récupérer les étudiants de la section sélectionnée
    $students = $sectionClass->getStudentsBySection($sectionId);
    
    // Récupérer le nom de la section
    $sectionDetails = $sectionClass->getById($sectionId);
    $sectionName = $sectionDetails['designation'];  // Désignation de la section
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les sections</title>
</head>
<body>
    <h2>Liste des sections</h2>
    <?php if ($isAdmin): ?>
        <a href="add_section.php">Ajouter une section</a><br>
    <?php endif; ?>
    <a href="dashboard.php">Retour au tableau de bord</a>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Désignation</th>
                <th>Description</th>
                <?php if ($isAdmin): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sections as $section): ?>
                <tr>
                    <td><?= $section['id'] ?></td>
                    <td><?= htmlspecialchars($section['designation']) ?></td>
                    <td><?= !empty($section['description']) ? htmlspecialchars($section['description']) : '(vide)' ?></td>
                    <?php if ($isAdmin): ?>
                        <td>
                            <a href="edit_section.php?id=<?= $section['id'] ?>">Modifier</a> |
                            <a href="delete_section.php?id=<?= $section['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette section ?');">Supprimer</a>
                        </td>
                    <?php endif; ?>
                    <!-- Lien pour voir les étudiants de la section -->
                    <td><a href="sections.php?id=<?= $section['id'] ?>">Voir les étudiants</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($sectionId): ?>
        <h3>Liste des étudiants dans la section <?= htmlspecialchars($sectionName) ?></h3>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Date de naissance</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($students) > 0): ?>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= $student['id'] ?></td>
                            <td><?= htmlspecialchars($student['name']) ?></td>
                            <td><?= htmlspecialchars($student['birthday']) ?></td>
                            <td><img src="<?= htmlspecialchars($student['image']) ?>" alt="Image de <?= $student['name'] ?>" width="50" height="50"></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Aucun étudiant dans cette section.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
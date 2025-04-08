<?php
require_once 'config.php';
require_once 'includes/Student.php';

// Vérifier si l'utilisateur est authentifié
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}


// Définir les variables de pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

//verifier si admin

$isAdmin = $_SESSION['user']['role'] === 'admin';

// Créer une instance de la classe Student
$studentClass = new Student($conn);

// Récupérer les étudiants avec pagination
$students = $studentClass->getAllWithPagination($limit, $offset);

// Récupérer le nombre total d'étudiants pour calculer le nombre de pages
$totalStudents = $studentClass->getTotalStudents();
$totalPages = ceil($totalStudents / $limit);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les étudiants</title>
</head>
<body>
    <h2>Liste des étudiants</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Date de naissance</th>
                <th>Image</th>
                <th>Section</th>
                <?php if ($isAdmin): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= htmlspecialchars($student['id']) ?></td> 
                    <td><?= htmlspecialchars($student['name']) ?></td>
                    <td><?= htmlspecialchars($student['birthday']) ?></td>
                    <td><img src="<?= htmlspecialchars($student['image']) ?>" alt="Image" width="50"></td>
                    <td><?= htmlspecialchars($student['designation']) ?></td>
                    <?php if ($isAdmin): ?>
                        <td>
                            <a href="edit_student.php?id=<?= $student['id'] ?>">Modifier</a> |
                            <a href="delete_student.php?id=<?= $student['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?');">Supprimer</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if (!$isAdmin): ?>
        <p>En tant qu'utilisateur, vous ne pouvez pas modifier les informations.</p>
    <?php endif; ?>

    <!-- Pagination -->
    <div>
        <?php if ($page > 1): ?>
            <a href="students.php?page=<?= $page - 1 ?>">Précédent</a>
        <?php endif; ?>

        Page <?= $page ?> sur <?= $totalPages ?>

        <?php if ($page < $totalPages): ?>
            <a href="students.php?page=<?= $page + 1 ?>">Suivant</a>
        <?php endif; ?>
    </div>

    <?php if ($isAdmin): ?>
        <a href="add_student.php">Ajouter un étudiant</a><br>
    <?php endif; ?>
    <a href="dashboard.php">Retour au tableau de bord</a>
</body>
</html>

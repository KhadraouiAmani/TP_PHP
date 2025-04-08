<?php
require_once 'config.php';
require_once 'includes/Student.php';
require_once 'includes/Section.php';  // Inclure la classe Section

// Vérifier si l'utilisateur est authentifié et a un rôle admin
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: dashboard.php");
    exit;
}

$studentClass = new Student($conn);
$sectionClass = new Section($conn);  // Créer une instance de Section pour récupérer les sections

// Vérifier si l'ID de l'étudiant est passé dans l'URL
if (!isset($_GET['id'])) {
    header("Location: students.php");
    exit;
}

$id = $_GET['id'];

// Récupérer l'étudiant par son ID
$student = $studentClass->getById($id);
if (!$student) {
    header("Location: students.php");
    exit;
}

// Récupérer toutes les sections
$sections = $sectionClass->getAll();

// Initialiser des variables pour les champs du formulaire
$name = $student['name'];
$birthday = $student['birthday'];
$image = $student['image'];
$section_id = $student['section_id'];

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $image = $_POST['image'];
    $section_id = $_POST['section_id'];

    // Mettre à jour l'étudiant
    $studentClass->update($id, $name, $birthday, $image, $section_id);

    // Rediriger vers la page des étudiants après la modification
    header("Location: students.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un étudiant</title>
</head>
<body>
    <h2>Modifier l'étudiant</h2>
    <form method="POST" action="edit_student.php?id=<?= $student['id'] ?>">
        <label for="name">Nom:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required><br>

        <label for="birthday">Date de naissance:</label>
        <input type="date" id="birthday" name="birthday" value="<?= htmlspecialchars($birthday) ?>" required><br>

        <label for="image">Image URL:</label>
        <input type="text" id="image" name="image" value="<?= htmlspecialchars($image) ?>" required><br>

        <label for="section_id">Section:</label>
        <select id="section_id" name="section_id" required>
            <?php foreach ($sections as $section): ?>
                <option value="<?= $section['id'] ?>" <?= $section['id'] == $section_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($section['designation']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <button type="submit">Mettre à jour</button>
    </form>

    <a href="students.php">Retour à la liste des étudiants</a>
</body>
</html>

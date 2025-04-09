<?php
require_once 'config.php';
require_once 'includes/Student.php';
require_once 'includes/Section.php';  


session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: dashboard.php");
    exit;
}

$studentClass = new Student($conn);
$sectionClass = new Section($conn); 


if (!isset($_GET['id'])) {
    header("Location: students.php");
    exit;
}

$id = $_GET['id'];


$student = $studentClass->getById($id);
if (!$student) {
    header("Location: students.php");
    exit;
}


$sections = $sectionClass->getAll();


$name = $student['name'];
$birthday = $student['birthday'];
$image = $student['image'];
$section_id = $student['section_id'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $image = $_POST['image'];
    $section_id = $_POST['section_id'];

    // Mettre à jour
    $studentClass->update($id, $name, $birthday, $image, $section_id);

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
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 20px;
    color: #333;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
}

h2 {
    text-align: center;
    color: #007bff;
    margin-bottom: 20px;
}

form {
    background-color: #fff;
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
input[type="date"],
select {
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
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

a {
    display: inline-block;
    margin: 10px 0;
    padding: 10px 15px;
    background-color:#007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

a:hover {
    background-color:  #0056b3;
}
    </style>
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

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
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

textarea {
    resize: vertical;
    height: 100px;
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
    margin-top: 15px;
    text-decoration: none;
    color: #007bff;
    font-size: 14px;
    transition: color 0.3s ease;
}

a:hover {
    color: #0056b3;
}
    </style>
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

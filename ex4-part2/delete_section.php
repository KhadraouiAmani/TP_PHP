<?php
require_once 'config.php';
require_once 'includes/Section.php';
require_once 'includes/Student.php';
session_start();

// Vérifier si l'utilisateur est authentifié et a un rôle admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: dashboard.php");
    exit;
}

$sectionClass = new Section($conn);
$studentClass = new Student($conn);

// Vérifier si l'ID de la section est passé dans l'URL
if (!isset($_GET['id'])) {
    header("Location: sections.php");
    exit;
}

$id = $_GET['id'];

// Vérifier si des étudiants sont associés à cette section
$studentsInSection = $studentClass->getBySectionId($id);

if (count($studentsInSection) > 0) {
    // Si des étudiants sont liés à la section, afficher un message d'erreur
    echo "Impossible de supprimer cette section car elle est liée à des étudiants. Veuillez d'abord réaffecter les étudiants.";
} else {
    // Si aucun étudiant n'est lié à la section, procéder à la suppression
    $sectionClass->delete($id);
    // Rediriger vers la liste des sections après suppression
    header("Location: sections.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression d'une section</title>
    <style>
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
    <a href="sections.php">Retour à la page précédente</a>
</body>
</html>
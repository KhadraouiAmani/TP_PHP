<?php
require_once 'config.php';
require_once 'includes/Student.php';
require_once 'includes/auth.php'; // Authentification de l'utilisateur

$studentClass = new Student($conn);

// Vérifier si l'ID de l'étudiant est passé dans l'URL
if (!isset($_GET['id'])) {
    header("Location: students.php");
    exit;
}

$id = $_GET['id'];

// Supprimer l'étudiant
$studentClass->delete($id);

// Rediriger vers la page des étudiants après la suppression
header("Location: students.php");
exit;

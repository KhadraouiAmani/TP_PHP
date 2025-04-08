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

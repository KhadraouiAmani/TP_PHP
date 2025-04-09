<?php
require_once 'config.php';
require_once 'includes/Section.php';
require_once 'includes/Student.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: dashboard.php");
    exit;
}

$sectionClass = new Section($conn);
$studentClass = new Student($conn);

if (!isset($_GET['id'])) {
    header("Location: sections.php");
    exit;
}

$id = $_GET['id'];

$studentsInSection = $studentClass->getBySectionId($id);

if (count($studentsInSection) > 0) {
    echo "Impossible de supprimer cette section car elle est liée à des étudiants. Veuillez d'abord réaffecter les étudiants.";
} else {
    $sectionClass->delete($id);
    header("Location: sections.php");
    exit;
}
?>

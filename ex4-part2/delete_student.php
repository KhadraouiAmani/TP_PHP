<?php
require_once 'config.php';
require_once 'includes/Student.php';
require_once 'includes/auth.php'; 

$studentClass = new Student($conn);


if (!isset($_GET['id'])) {
    header("Location: students.php");
    exit;
}

$id = $_GET['id'];


$studentClass->delete($id);


header("Location: students.php");
exit;

?>

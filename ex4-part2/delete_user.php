<?php
require_once 'config.php';
require_once 'includes/UserClassRepo.php';
session_start();


if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: dashboard.php");
    exit;
}

$userClass = new UserClassRepo($conn);



if (!isset($_GET['id'])) {
    header("Location: usersUsingRepo.php");
    exit;
}

$id = $_GET['id'];

$userClass->delete($id);

// Rediriger vers la page des users après la suppression
header("Location: usersUsingRepo.php");
exit;

?>